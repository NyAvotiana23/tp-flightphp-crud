<?php include("../section/head.php"); ?>
<body class="bg-custom-gray-purple min-h-screen flex flex-col items-center justify-center p-4 font-sans">
<?php include("../section/navbar.php"); ?>

<div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mt-16">
    <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">Demande de Prêt</h1>
    <form id="loanForm" class="space-y-6">
        <div>
            <label for="clientId" class="block text-h6 font-medium text-custom-black mb-2">ID Client</label>
            <input type="number" id="clientId" class="w-full border border-custom-purple-secondary rounded-md p-3" required />
        </div>
        <div>
            <label for="loanAmount" class="block text-h6 font-medium text-custom-black mb-2">Montant du prêt (€)</label>
            <input type="number" id="loanAmount" class="w-full border border-custom-purple-secondary rounded-md p-3" required />
        </div>
        <div>
            <label for="loanType" class="block text-h6 font-medium text-custom-black mb-2">Type de prêt</label>
            <select id="loanType" class="w-full border border-custom-purple-secondary rounded-md p-3" required>
                <option value="">Sélectionnez un type de prêt</option>
            </select>
        </div>
        <div>
            <label for="repaymentType" class="block text-h6 font-medium text-custom-black mb-2">Type de remboursement</label>
            <select id="repaymentType" class="w-full border border-custom-purple-secondary rounded-md p-3" required>
                <option value="">Sélectionnez une périodicité</option>
            </select>
        </div>
        <div>
            <label for="loanDuration" class="block text-h6 font-medium text-custom-black mb-2">Durée du prêt (mois)</label>
            <input type="number" id="loanDuration" class="w-full border border-custom-purple-secondary rounded-md p-3" required />
        </div>
        <div>
            <label for="interestRate" class="block text-h6 font-medium text-custom-black mb-2">Taux d'intérêt annuel (%)</label>
            <input type="number" step="0.01" id="interestRate" class="w-full border border-custom-purple-secondary rounded-md p-3" required />
        </div>
        <div>
            <label for="insuranceRate" class="block text-h6 font-medium text-custom-black mb-2">Taux d'assurance (%)</label>
            <input type="number" step="0.01" id="insuranceRate" class="w-full border border-custom-purple-secondary rounded-md p-3" required />
        </div>
        <div>
            <label for="repaymentDelay" class="block text-h6 font-medium text-custom-black mb-2">Délai de remboursement (mois)</label>
            <input type="number" id="repaymentDelay" class="w-full border border-custom-purple-secondary rounded-md p-3" />
        </div>
        <button type="submit" class="w-full bg-custom-purple-primary text-white text-h6 font-medium py-3 rounded-md">Soumettre la demande</button>
    </form>

    <div id="contractSection" class="hidden mt-8 p-6 bg-custom-gray-purple rounded-lg">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-4">Contrat de Prêt</h2>
        <div id="contractDetails" class="space-y-4 text-base text-custom-black">
            <p><strong>ID Contrat:</strong> <span id="contractId"></span></p>
            <p><strong>Montant du prêt:</strong> <span id="contractLoanAmount"></span> €</p>
            <p><strong>Type de prêt:</strong> <span id="contractLoanType"></span></p>
            <p><strong>Type de remboursement:</strong> <span id="contractRepaymentType"></span></p>
            <p><strong>Durée:</strong> <span id="contractDuration"></span> mois</p>
            <p><strong>Taux d'intérêt annuel:</strong> <span id="contractInterestRate"></span>%</p>
            <p><strong>Taux d'assurance:</strong> <span id="contractInsuranceRate"></span>%</p>
            <p><strong>Délai de remboursement:</strong> <span id="contractDelay"></span> jours</p>
            <p><strong>Mensualité estimée:</strong> <span id="contractMonthlyPayment"></span> €</p>
        </div>
        <div class="flex space-x-4 mt-6">
            <button id="acceptContract" class="bg-custom-purple-primary text-white text-h6 font-medium py-2 px-4 rounded-md">Valider le contrat</button>
            <button id="rejectContract" class="bg-red-500 text-white text-h6 font-medium py-2 px-4 rounded-md">Refuser le contrat</button>
            <button id="showSimulation" class="bg-custom-black text-white text-h6 font-medium py-2 px-4 rounded-md">Voir la simulation</button>
        </div>
    </div>

    <div id="simulationSection" class="hidden mt-8 p-6 bg-custom-gray-purple rounded-lg">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-4">Simulation de Remboursement</h2>
        <div id="simulationTable" class="overflow-x-auto">
            <table class="w-full text-base text-custom-black">
                <thead>
                    <tr class="bg-custom-purple-secondary text-white">
                        <th class="p-3 text-left">Période</th>
                        <th class="p-3 text-left">Capital restant dû (€)</th>
                        <th class="p-3 text-left">Intérêts (€)</th>
                        <th class="p-3 text-left">Capital remboursé (€)</th>
                        <th class="p-3 text-left">Assurance (€)</th>
                        <th class="p-3 text-left">Total dû (€)</th>
                    </tr>
                </thead>
                <tbody id="simulationTableBody"></tbody>
            </table>
        </div>
        <div class="mt-6">
            <h3 class="text-h3 font-medium text-custom-black mb-4">Graphique d'amortissement</h3>
            <canvas id="amortizationChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
    const apiBase = "http://localhost/tp-flightphp-crud/ws";

    function ajax(method, url, data, callback, errorCallback) {
        let fullUrl = apiBase + url;
        let requestData = null;
        if (data && (method === 'GET' || method === 'DELETE')) {
            fullUrl += '?' + new URLSearchParams(data).toString();
        } else if (data && (method === 'POST' || method === 'PUT')) {
            requestData = JSON.stringify(data);
        }
        const xhr = new XMLHttpRequest();
        xhr.open(method, fullUrl, true);
        if (method === 'POST' || method === 'PUT') {
            xhr.setRequestHeader("Content-Type", "application/json");
        }
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const resp = xhr.responseText ? JSON.parse(xhr.responseText) : {};
                    callback(resp);
                } else {
                    if (errorCallback) errorCallback(xhr.statusText);
                }
            }
        };
        xhr.onerror = () => { if (errorCallback) errorCallback('Network error'); };
        xhr.send(requestData);
    }

    ajax('GET', '/types-prets', null, res => {
        const sel = document.getElementById('loanType');
        res.forEach(t => sel.appendChild(new Option(`${t.nom_type_pret} (${t.taux_interet_min_annuel}%–${t.taux_interet_max_annuel}%)`, t.id)));
    });
    ajax('GET', '/types-remboursements', null, res => {
        const sel = document.getElementById('repaymentType');
        res.forEach(t => sel.appendChild(new Option(`${t.nom_type_remboursement} (${t.repetition_annuelle}/an)`, t.id)));
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
</script>
</body>
