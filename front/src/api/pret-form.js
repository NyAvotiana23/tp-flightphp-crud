import { ajax } from './ajax.js';

// Utility functions
const formatDate = (date) => date.toISOString().split('T')[0];

const addMonths = (date, months) => {
    const newDate = new Date(date);
    newDate.setMonth(newDate.getMonth() + months);
    return newDate;
};

const showFeedback = (message, type = 'error') => {
    const feedback = document.getElementById('feedback');
    feedback.textContent = message;
    feedback.className = `p-4 mb-4 rounded-md text-sm ${type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}`;
    feedback.classList.remove('hidden');
    setTimeout(() => feedback.classList.add('hidden'), 5000);
};

const validateForm = (formData) => {
    if (!formData.clientId) return 'Veuillez sélectionner un client';
    if (formData.loanAmount < 1000) return 'Le montant du prêt doit être au moins 1000 €';
    if (!formData.loanTypeId) return 'Veuillez sélectionner un type de prêt';
    if (!formData.repaymentTypeId) return 'Veuillez sélectionner un type de remboursement';
    if (formData.loanDuration < 1) return 'La durée du prêt doit être d\'au moins 1 mois';
    if (formData.interestRate < 0) return 'Le taux d\'intérêt ne peut pas être négatif';
    if (formData.insuranceRate < 0) return 'Le taux d\'assurance ne peut pas être négatif';
    if (formData.repaymentDelay < 0) return 'Le délai de remboursement ne peut pas être négatif';
    return null;
};

const getFormData = () => ({
    clientId: +document.getElementById('clientId').value,
    loanAmount: +document.getElementById('loanAmount').value,
    loanTypeId: +document.getElementById('loanType').value,
    loanTypeText: document.getElementById('loanType').selectedOptions[0].text,
    repaymentTypeId: +document.getElementById('repaymentType').value,
    repaymentTypeText: document.getElementById('repaymentType').selectedOptions[0].text,
    loanDuration: +document.getElementById('loanDuration').value,
    interestRate: +document.getElementById('interestRate').value,
    insuranceRate: +document.getElementById('insuranceRate').value,
    repaymentDelay: +document.getElementById('repaymentDelay').value || 0
});

const generateSimulation = async (loanAmount, repaymentTypeId, loanDuration, interestRate, insuranceRate, repaymentDelay) => {
    try {
        const response = await new Promise((resolve, reject) => {
            ajax('GET', `/types-remboursements/${repaymentTypeId}`, null, resolve, reject);
        });
        const freq = response.repetition_annuelle;
        const pi = interestRate / 100 / freq;
        const psi = insuranceRate / 100 / freq;
        const periodicRate = interestRate / 100 / freq;
        const n = loanDuration;
        const monthlyPayment = periodicRate === 0 ? loanAmount / n : (loanAmount * periodicRate) / (1 - Math.pow(1 + periodicRate, -n));
        let rem = loanAmount;
        const data = [];
        let rows = '';
        let date_debut = addMonths(new Date(), repaymentDelay);

        for (let i = 1; i <= loanDuration; i++) {
            const interest = rem * pi;
            const insurance = psi * loanAmount;
            let cap = monthlyPayment - interest;
            if (i === loanDuration && rem - cap < 0.01) cap = rem;
            const total = monthlyPayment + insurance;
            const formattedDate = formatDate(date_debut);
            rows += `<tr class="${i % 2 === 0 ? 'bg-gray-50' : 'bg-white'} hover:bg-gray-100">
                    <td class="p-3">${i}</td>
                    <td class="p-3">${formattedDate}</td>
                    <td class="p-3">${rem.toFixed(2)}</td>
                    <td class="p-3">${interest.toFixed(2)}</td>
                    <td class="p-3">${cap.toFixed(2)}</td>
                    <td class="p-3">${insurance.toFixed(2)}</td>
                    <td class="p-3">${total.toFixed(2)}</td>
                </tr>`;
            data.push({ rem, interest, cap, insurance, total });
            date_debut = addMonths(date_debut, 12 / freq);
            rem -= cap;
        }

        document.getElementById('simulationTableBody').innerHTML = rows;
        document.getElementById('simulationSection').classList.remove('hidden');
        document.getElementById('contractSection').classList.add('hidden');

        const ctx = document.getElementById('amortizationChart').getContext('2d');
        if (window.amortChart) window.amortChart.destroy();
        window.amortChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map((_, i) => `Période ${i + 1}`),
                datasets: [
                    { label: 'Capital restant dû', data: data.map(d => d.rem), borderColor: '#8B5CF6', backgroundColor: 'rgba(139, 92, 246, 0.2)', fill: false, tension: 0.1 },
                    { label: 'Intérêts', data: data.map(d => d.interest), borderColor: '#A78BFA', backgroundColor: 'rgba(167, 139, 250, 0.2)', fill: false, tension: 0.1 },
                    { label: 'Assurance', data: data.map(d => d.insurance), borderColor: '#6B7280', backgroundColor: 'rgba(107, 114, 128, 0.2)', fill: false, tension: 0.1 }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { title: { display: true, text: 'Période' } },
                    y: { title: { display: true, text: 'Montant (€)' }, beginAtZero: true }
                }
            }
        });

        return { monthlyPayment, date_debut: formatDate(addMonths(new Date(), repaymentDelay)) };
    } catch (err) {
        showFeedback('Erreur lors de la génération de la simulation: ' + err);
        throw err;
    }
};

// Initialize dropdowns
const initDropdowns = () => {
    ajax('GET', '/types-prets', null, res => {
        const sel = document.getElementById('loanType');
        res.forEach(t => sel.appendChild(new Option(`${t.nom_type_pret} (${t.taux_interet_min_annuel}%–${t.taux_interet_max_annuel}%)`, t.id)));
    }, err => showFeedback('Erreur chargement types de prêt: ' + err));

    ajax('GET', '/types-remboursements', null, res => {
        const sel = document.getElementById('repaymentType');
        res.forEach(t => sel.appendChild(new Option(`${t.nom_type_remboursement} (${t.repetition_annuelle}/an)`, t.id)));
    }, err => showFeedback('Erreur chargement types de remboursement: ' + err));

    ajax('GET', '/clients', null, res => {
        const sel = document.getElementById('clientId');
        res.forEach(t => sel.appendChild(new Option(`${t.numero_client} ${t.nom}`, t.id)));
    }, err => showFeedback('Erreur chargement clients: ' + err));
};

// Submit loan form
// Submit loan form
document.getElementById('loanForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = getFormData();
    const validationError = validateForm(formData);
    if (validationError) {
        showFeedback(validationError);
        return;
    }

    try {
        const response = await new Promise((resolve, reject) => {
            ajax('GET', `/types-remboursements/${formData.repaymentTypeId}`, null, resolve, reject);
        });
        const freq = response.repetition_annuelle;
        const periodicRate = formData.interestRate / 100 / freq;
        const n = formData.loanDuration;
        const monthlyPayment = periodicRate === 0 ? formData.loanAmount / n : (formData.loanAmount * periodicRate) / (1 - Math.pow(1 + periodicRate, -n));

        const contractData = {
            id_client: formData.clientId,
            id_type_remboursement: formData.repaymentTypeId,
            id_type_pret: formData.loanTypeId,
            uuid: crypto.randomUUID(),
            taux_interet_annuel: formData.interestRate,
            taux_assurance_annuel: formData.insuranceRate,
            duree_remboursement_mois: formData.loanDuration,
            montant_pret: formData.loanAmount,
            montant_echeance: monthlyPayment,
            delay_remboursement_mois: formData.repaymentDelay // Changed from delai_remboursement_mois
        };

        const resp = await new Promise((resolve, reject) => {
            ajax('POST', '/contrats-prets', contractData, resolve, reject);
        });

        document.getElementById('contractId').textContent = resp.id;
        document.getElementById('contractLoanAmount').textContent = formData.loanAmount.toFixed(2);
        document.getElementById('contractLoanType').textContent = formData.loanTypeText;
        document.getElementById('contractRepaymentType').textContent = formData.repaymentTypeText;
        document.getElementById('contractDuration').textContent = formData.loanDuration;
        document.getElementById('contractInterestRate').textContent = formData.interestRate.toFixed(2);
        document.getElementById('contractInsuranceRate').textContent = formData.insuranceRate.toFixed(2);
        document.getElementById('contractDelay').textContent = formData.repaymentDelay;
        document.getElementById('contractMonthlyPayment').textContent = monthlyPayment.toFixed(2);
        document.getElementById('contractSection').classList.remove('hidden');
        document.getElementById('simulationSection').classList.add('hidden');
        showFeedback('Contrat créé avec succès !', 'success');
    } catch (err) {
        console.error('Submit loan error:', err);
        showFeedback('Erreur création contrat: ' + (err.message || err));
    }
});

// Accept contract
document.getElementById('acceptContract').addEventListener('click', async () => {
    const cid = +document.getElementById('contractId').textContent;
    const delay = +document.getElementById('contractDelay').textContent;
    try {
        await new Promise((resolve, reject) => {
            ajax('POST', `/contrats-prets/${cid}/approve`, { date: formatDate(new Date()), delai_remboursement: delay }, resolve, reject);
        });
        showFeedback('Contrat validé !', 'success');
        document.getElementById('contractSection').classList.add('hidden');
    } catch (err) {
        showFeedback('Erreur validation contrat: ' + err);
    }
});

// Reject contract
document.getElementById('rejectContract').addEventListener('click', async () => {
    const cid = +document.getElementById('contractId').textContent;
    try {
        await new Promise((resolve, reject) => {
            ajax('POST', `/contrats-prets/${cid}/reject`, {}, resolve, reject);
        });
        showFeedback('Contrat refusé.', 'success');
        document.getElementById('contractSection').classList.add('hidden');
    } catch (err) {
        showFeedback('Erreur refus contrat: ' + err);
    }
});

// Show simulation from contract
document.getElementById('showSimulation').addEventListener('click', () => {
    const loanAmount = +document.getElementById('contractLoanAmount').textContent;
    const repaymentTypeId = +document.getElementById('repaymentType').value;
    const loanDuration = +document.getElementById('contractDuration').textContent;
    const interestRate = +document.getElementById('contractInterestRate').textContent;
    const insuranceRate = +document.getElementById('contractInsuranceRate').textContent;
    const repaymentDelay = +document.getElementById('contractDelay').textContent;

    generateSimulation(loanAmount, repaymentTypeId, loanDuration, interestRate, insuranceRate, repaymentDelay);
});

// View simulation
document.getElementById('viewSimulation').addEventListener('click', () => {
    const formData = getFormData();
    const validationError = validateForm(formData);
    if (validationError) {
        showFeedback(validationError);
        return;
    }

    generateSimulation(
        formData.loanAmount,
        formData.repaymentTypeId,
        formData.loanDuration,
        formData.interestRate,
        formData.insuranceRate,
        formData.repaymentDelay
    );
});

// Save simulation
document.getElementById('saveSimulation').addEventListener('click', async () => {
    const formData = getFormData();
    const validationError = validateForm(formData);
    if (validationError) {
        showFeedback(validationError);
        return;
    }

    try {
        const response = await new Promise((resolve, reject) => {
            ajax('GET', `/types-remboursements/${formData.repaymentTypeId}`, null, resolve, reject);
        });
        const freq = response.repetition_annuelle;
        const periodicRate = formData.interestRate / 100 / freq;
        const n = formData.loanDuration;
        const monthlyPayment = periodicRate === 0 ? formData.loanAmount / n : (formData.loanAmount * periodicRate) / (1 - Math.pow(1 + periodicRate, -n));

        const simulationData = {
            montant_pret: formData.loanAmount,
            montant_echeance: monthlyPayment,
            durre_pret: formData.loanDuration, // Included for compatibility
            durre_remboursement_mois: formData.loanDuration,
            taux_interet_annuel: formData.interestRate,
            taux_assurance_annuel: formData.insuranceRate,
            date_debut_pret: formatDate(addMonths(new Date(), formData.repaymentDelay)),
            delai_remboursement_mois: formData.repaymentDelay
        };

        const resp = await new Promise((resolve, reject) => {
            ajax('POST', '/simulation-pret', simulationData, resolve, reject);
        });

        showFeedback(`Simulation sauvegardée ! ID: ${resp}`, 'success');
        generateSimulation(
            formData.loanAmount,
            formData.repaymentTypeId,
            formData.loanDuration,
            formData.interestRate,
            formData.insuranceRate,
            formData.repaymentDelay
        );
    } catch (err) {
        showFeedback('Erreur sauvegarde simulation: ' + err);
    }
});

// Initialize on page load
initDropdowns();