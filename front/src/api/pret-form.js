import { ajax } from './ajax.js';

ajax('GET', '/types-prets', null, res => {
    const sel = document.getElementById('loanType');
    res.forEach(t => sel.appendChild(new Option(`${t.nom_type_pret} (${t.taux_interet_min_annuel}%–${t.taux_interet_max_annuel}%)`, t.id)));
});
ajax('GET', '/types-remboursements', null, res => {
    const sel = document.getElementById('repaymentType');
    res.forEach(t => sel.appendChild(new Option(`${t.nom_type_remboursement} (${t.repetition_annuelle}/an)`, t.id)));
});
ajax('GET', '/clients', null, res => {
    const sel = document.getElementById('clientId');
    res.forEach(t => sel.appendChild(new Option(`${t.numero_client} ${t.nom}`, t.id)));
});


document.getElementById('loanForm').addEventListener('submit', e => {
    e.preventDefault();
    const clientId = +document.getElementById('clientId').value;
    const loanAmount = +document.getElementById('loanAmount').value;
    const loanTypeId = +document.getElementById('loanType').value;
    const loanTypeText = document.getElementById('loanType').selectedOptions[0].text;
    const repaymentTypeId = +document.getElementById('repaymentType').value;
    const repaymentTypeText = document.getElementById('repaymentType').selectedOptions[0].text;
    const loanDuration = +document.getElementById('loanDuration').value;
    const interestRate = +document.getElementById('interestRate').value;
    const insuranceRate = +document.getElementById('insuranceRate').value;
    const repaymentDelay = +document.getElementById('repaymentDelay').value;

    ajax('GET', `/types-remboursements/${repaymentTypeId}`, null, r => {
        const freq = r.repetition_annuelle;
        const periodicRate = interestRate/100/freq;
        const n = loanDuration;
        const monthlyPayment = periodicRate===0 ? loanAmount/n : (loanAmount*periodicRate)/(1-Math.pow(1+periodicRate,-n));

        const contractData = {
            id_client: clientId,
            id_type_remboursement: repaymentTypeId,
            id_type_pret: loanTypeId,
            uuid: crypto.randomUUID(),
            taux_interet_annuel: interestRate,
            taux_assurance_annuel: insuranceRate,
            duree_remboursement_mois: loanDuration,
            montant_pret: loanAmount,
            montant_echeance: monthlyPayment,
            duree_remboursement_mois: repaymentDelay
        };

        ajax('POST', '/contrats-prets', contractData, resp => {
            document.getElementById('contractId').textContent = resp.id;
            document.getElementById('contractLoanAmount').textContent = loanAmount.toFixed(2);
            document.getElementById('contractLoanType').textContent = loanTypeText;
            document.getElementById('contractRepaymentType').textContent = repaymentTypeText;
            document.getElementById('contractDuration').textContent = loanDuration;
            document.getElementById('contractInterestRate').textContent = interestRate.toFixed(2);
            document.getElementById('contractInsuranceRate').textContent = insuranceRate.toFixed(2);
            document.getElementById('contractDelay').textContent = repaymentDelay;
            document.getElementById('contractMonthlyPayment').textContent = monthlyPayment.toFixed(2);
            document.getElementById('contractSection').classList.remove('hidden');
            document.getElementById('simulationSection').classList.add('hidden');
        }, err => alert('Erreur création contrat: '+err));
    }, err => alert('Erreur récupération type remboursement: '+err));
});

document.getElementById('acceptContract').addEventListener('click', () => {
    const cid = +document.getElementById('contractId').textContent;
    const delay = +document.getElementById('contractDelay').textContent;
    ajax('POST', `/contrats-prets/${cid}/approve`, { date: new Date().toISOString().split('T')[0], delai_remboursement: delay }, _ => {
        alert('Contrat validé !');
        document.getElementById('contractSection').classList.add('hidden');
    }, err => alert('Erreur validation: '+err));
});

document.getElementById('rejectContract').addEventListener('click', () => {
    const cid = +document.getElementById('contractId').textContent;
    ajax('POST', `/contrats-prets/${cid}/reject`, {}, _ => {
        alert('Contrat refusé.');
        document.getElementById('contractSection').classList.add('hidden');
    }, err => alert('Erreur refus: '+err));
});

document.getElementById('showSimulation').addEventListener('click', () => {
    const loanAmount = +document.getElementById('contractLoanAmount').textContent;
    const repaymentTypeId = +document.getElementById('repaymentType').value;
    const loanDuration = +document.getElementById('contractDuration').textContent;
    const interestRate = +document.getElementById('contractInterestRate').textContent;
    const insuranceRate = +document.getElementById('contractInsuranceRate').textContent;
    const monthlyPayment = +document.getElementById('contractMonthlyPayment').textContent;

    ajax('GET', `/types-remboursements/${repaymentTypeId}`, null, r => {
        const freq = r.repetition_annuelle;
        const pi = interestRate/100/freq;
        const psi = insuranceRate/100/freq;
        let rem = loanAmount;
        const data = [];
        let rows = '';

        for (let i = 1; i <= loanDuration; i++) {
            const interest = rem * pi;
            const insurance = psi * loanAmount;
            let cap = monthlyPayment - interest;
            if(i===loanDuration && rem-cap<0.01) cap = rem;
            const total = monthlyPayment + insurance;
            rows += `<tr>
                    <td class="p-3">${i}</td>
                    <td class="p-3">${rem.toFixed(2)}</td>
                    <td class="p-3">${interest.toFixed(2)}</td>
                    <td class="p-3">${cap.toFixed(2)}</td>
                    <td class="p-3">${insurance.toFixed(2)}</td>
                    <td class="p-3">${total.toFixed(2)}</td>
                </tr>`;
            data.push({ rem, interest, cap, insurance, total });
            rem -= cap;
        }

        document.getElementById('simulationTableBody').innerHTML = rows;
        document.getElementById('simulationSection').classList.remove('hidden');

        const ctx = document.getElementById('amortizationChart').getContext('2d');
        if (window.amortChart) window.amortChart.destroy();
        window.amortChart = new Chart(ctx, {
            type: 'line',
            data: { labels: data.map((_,i)=>i+1), datasets: [
                    { label: 'Capital restant dû', data: data.map(d=>d.rem), borderColor: '#8B5CF6', fill: false },
                    { label: 'Intérêts', data: data.map(d=>d.interest), borderColor: '#A78BFA', fill: false },
                    { label: 'Assurance', data: data.map(d=>d.insurance), borderColor: '#6B7280', fill: false }
                ]}
        });
    }, err => alert('Erreur simulation: '+err));
});