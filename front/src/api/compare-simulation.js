import { ajax } from './ajax.js';

// Utility functions
const showFeedback = (message, type = 'error') => {
    const feedback = document.getElementById('feedback');
    feedback.textContent = message;
    feedback.className = `p-4 mb-4 rounded-md text-sm ${type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}`;
    feedback.classList.remove('hidden');
    setTimeout(() => feedback.classList.add('hidden'), 5000);
};

const formatDate = (date) => date.toISOString().split('T')[0];

const addMonths = (date, months) => {
    const newDate = new Date(date);
    newDate.setMonth(newDate.getMonth() + months);
    return newDate;
};

const validateForm = (formData) => {
    if (!formData.simulationId1) return 'Veuillez sélectionner la première simulation enregistrée';
    if (!formData.simulationId2) return 'Veuillez sélectionner la deuxième simulation enregistrée';
    if (formData.simulationId1 === formData.simulationId2) return 'Veuillez sélectionner deux simulations différentes';
    return null;
};

const getFormData = () => ({
    simulationId1: +document.getElementById('simulation1')?.value || 0,
    simulationId2: +document.getElementById('simulation2')?.value || 0
});

const generateSimulation = async (simulationData, tableId, chartId, repaymentTypeId = null) => {
    try {
        // Convert all numerical fields to numbers
        const loanAmount = +simulationData.montant_pret;
        const loanDuration = +simulationData.durre_remboursement_mois;
        const interestRate = +simulationData.taux_interet_annuel;
        const insuranceRate = +simulationData.taux_assurance_annuel || 0;
        const repaymentDelay = +simulationData.delai_remboursement_mois || 0;
        let monthlyPayment = +simulationData.montant_echeance;

        // Fetch repayment type data
        const response = await new Promise((resolve, reject) => {
            ajax('GET', `/types-remboursements/${repaymentTypeId || simulationData.id_type_remboursement || 1}`, null, resolve, reject);
        });
        const freq = +response.repetition_annuelle;

        // Validate inputs
        if (isNaN(loanAmount) || loanAmount <= 0) throw new Error('Montant du prêt invalide');
        if (isNaN(loanDuration) || loanDuration <= 0) throw new Error('Durée du prêt invalide');
        if (isNaN(interestRate) || interestRate < 0) throw new Error('Taux d\'intérêt invalide');
        if (isNaN(insuranceRate) || insuranceRate < 0) throw new Error('Taux d\'assurance invalide');
        if (isNaN(repaymentDelay) || repaymentDelay < 0) throw new Error('Délai de remboursement invalide');
        if (isNaN(freq) || freq <= 0) throw new Error('Fréquence de remboursement invalide');

        // Calculate monthly payment if not provided or invalid
        const periodicRate = interestRate / 100 / freq;
        if (isNaN(monthlyPayment) || monthlyPayment <= 0) {
            monthlyPayment = periodicRate === 0 ? loanAmount / loanDuration : (loanAmount * periodicRate) / (1 - Math.pow(1 + periodicRate, -loanDuration));
        }

        const pi = interestRate / 100 / freq;
        const psi = insuranceRate / 100 / freq;
        let rem = loanAmount;
        const data = [];
        let rows = '';
        let date_debut = new Date(simulationData.date_debut_pret);

        if (isNaN(date_debut.getTime())) {
            date_debut = addMonths(new Date(), repaymentDelay);
        }

        for (let i = 1; i <= loanDuration; i++) {
            const interest = rem * pi;
            const insurance = psi * loanAmount;
            let cap = monthlyPayment - interest;
            if (i === loanDuration && Math.abs(rem - cap) < 0.01) cap = rem; // Adjust for final payment
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

        document.getElementById(tableId).innerHTML = rows;

        // Ensure canvas element exists
        const canvas = document.getElementById(chartId);
        if (!canvas) throw new Error(`Canvas element with ID ${chartId} not found`);

        const ctx = canvas.getContext('2d');
        if (!ctx) throw new Error(`Failed to get 2D context for canvas ${chartId}`);

        // Destroy previous chart if it exists and is a valid Chart.js instance
        if (window[chartId] && typeof window[chartId].destroy === 'function') {
            window[chartId].destroy();
        }

        // Create new chart and store it in window[chartId]
        window[chartId] = new Chart(ctx, {
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
    } catch (err) {
        showFeedback('Erreur lors de la génération de la simulation: ' + err.message);
        throw err;
    }
};

// Initialize dropdowns
const initDropdowns = () => {
    ajax('GET', '/simulation-pret', null, res => {
        const sel1 = document.getElementById('simulation1');
        const sel2 = document.getElementById('simulation2');
        if (sel1 && sel2) {
            res.forEach(s => {
                const option1 = new Option(`Simulation #${s.id} - ${s.montant_pret}€, ${s.durre_remboursement_mois} mois`, s.id);
                const option2 = new Option(`Simulation #${s.id} - ${s.montant_pret}€, ${s.durre_remboursement_mois} mois`, s.id);
                sel1.appendChild(option1);
                sel2.appendChild(option2);
            });
        }
    }, err => showFeedback('Erreur chargement simulations enregistrées: ' + err));
};

// Compare simulations
document.getElementById('compareSimulations')?.addEventListener('click', async () => {
    const formData = getFormData();
    const validationError = validateForm(formData);
    if (validationError) {
        showFeedback(validationError);
        return;
    }

    try {
        // Fetch both simulations
        const simulation1 = await new Promise((resolve, reject) => {
            ajax('GET', `/simulation-pret/${formData.simulationId1}`, null, resolve, reject);
        });
        const simulation2 = await new Promise((resolve, reject) => {
            ajax('GET', `/simulation-pret/${formData.simulationId2}`, null, resolve, reject);
        });

        // Generate both simulations
        await generateSimulation(simulation1, 'simulation1TableBody', 'simulation1Chart');
        await generateSimulation(simulation2, 'simulation2TableBody', 'simulation2Chart');

        document.getElementById('comparisonSection').classList.remove('hidden');
        showFeedback('Simulations comparées avec succès !', 'success');
    } catch (err) {
        console.error('Comparison error:', err);
        showFeedback('Erreur lors de la comparaison des simulations: ' + (err.message || err));
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', initDropdowns);