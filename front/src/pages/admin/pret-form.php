<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple min-h-screen flex flex-col items-center justify-center p-4 font-sans">
<?php
include("../section/navbar.php");
?>
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
        <button type="submit" class="w-full bg-custom-purple-primary text-white text-h6 font-medium py expropriate-3 rounded-md">Soumettre la demande</button>
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
    const apiBase = "http://localhost/Tp%20Final%20S4/tp-flightphp-crud/ws";

    function ajax(method, url, data, callback, errorCallback) {
        const xhr = new XMLHttpRequest();
        const fullUrl = apiBase + url;

        xhr.open(method, fullUrl, true);

        // Set Content-Type for POST and PUT requests
        if (method === 'POST' || method === 'PUT') {
            xhr.setRequestHeader("Content-Type", "application/json");
        } else {
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        }

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        callback(response);
                    } catch (e) {
                        console.error("Error parsing response:", e);
                        if (errorCallback) {
                            errorCallback("Invalid JSON response from server");
                        }
                    }
                } else {
                    console.error(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                    if (errorCallback) {
                        errorCallback(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                    }
                }
            }
        };

        xhr.onerror = () => {
            console.error("Network error occurred");
            if (errorCallback) {
                errorCallback("Network error occurred");
            }
        };

        // Prepare data based on method
        let requestData = null;
        if (data) {
            if (method === 'POST' || method === 'PUT') {
                requestData = JSON.stringify(data);
            } else if (method === 'GET' || method === 'DELETE') {
                const params = new URLSearchParams(data).toString();
                xhr.open(method, fullUrl + (params ? `?${params}` : ''), true);
            }
        }

        xhr.send(requestData);
    }

    ajax('GET', '/types-prets', null, (response) => {
        const loanTypeSelect = document.getElementById('loanType');
        response.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = `${type.nom_type_pret} (${type.taux_interet_min_annuel}% - ${type.taux_interet_max_annuel}%)`;
            loanTypeSelect.appendChild(option);
        });
    }, (error) => console.error('Error fetching loan types:', error));

    ajax('GET', '/types-remboursements', null, (response) => {
        const repaymentTypeSelect = document.getElementById('repaymentType');
        response.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = `${type.nom_type_remboursement} (${type.repetition_annuelle} fois par an)`;
            repaymentTypeSelect.appendChild(option);
        });
    }, (error) => console.error('Error fetching repayment types:', error));

    document.getElementById('loanForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const clientId = parseInt(document.getElementById('clientId').value);
        const loanAmount = parseFloat(document.getElementById('loanAmount').value);
        const loanTypeId = parseInt(document.getElementById('loanType').value);
        const loanTypeText = document.getElementById('loanType').options[document.getElementById('loanType').selectedIndex].text;
        const repaymentTypeId = parseInt(document.getElementById('repaymentType').value);
        const repaymentTypeText = document.getElementById('repaymentType').options[document.getElementById('repaymentType').selectedIndex].text;
        const loanDuration = parseInt(document.getElementById('loanDuration').value);
        const interestRate = parseFloat(document.getElementById('interestRate').value);
        const insuranceRate = parseFloat(document.getElementById('insuranceRate').value);

        ajax('GET', `/types-remboursements/${repaymentTypeId}`, null, (repaymentType) => {
            const repetitionAnnuelle = repaymentType.repetition_annuelle;
            const monthlyRate = interestRate / 100 / repetitionAnnuelle;
            const numPayments = loanDuration;
            const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));

            const contractData = {
                id_client: clientId,
                id_type_remboursement: repaymentTypeId,
                id_type_pret: loanTypeId,
                uuid: crypto.randomUUID(),
                taux_interet_annuel: interestRate,
                taux_assurance_annuel: insuranceRate,
                duree_remboursement_mois: loanDuration,
                montant_pret: loanAmount,
                montant_echeance: monthlyPayment
            };

            ajax('POST', '/contrats-prets', contractData, (response) => {
                document.getElementById('contractId').textContent = response.id;
                document.getElementById('contractLoanAmount').textContent = loanAmount.toFixed(2);
                document.getElementById('contractLoanType').textContent = loanTypeText;
                document.getElementById('contractRepaymentType').textContent = repaymentTypeText;
                document.getElementById('contractDuration').textContent = loanDuration;
                document.getElementById('contractInterestRate').textContent = interestRate.toFixed(2);
                document.getElementById('contractInsuranceRate').textContent = insuranceRate.toFixed(2);
                document.getElementById('contractMonthlyPayment').textContent = monthlyPayment.toFixed(2);
                document.getElementById('contractSection').classList.remove('hidden');
            }, (error) => alert('Erreur lors de la création du contrat: ' + error));
        }, (error) => alert('Erreur lors de la récupération du type de remboursement: ' + error));
    });

    document.getElementById('acceptContract').addEventListener('click', function () {
        const contractId = parseInt(document.getElementById('contractId').textContent);
        ajax('POST', `/contrats-prets/${contractId}/approve`, { date: new Date().toISOString().split('T')[0], delai_remboursement: 0 }, (response) => {
            alert('Contrat validé avec succès !');
            document.getElementById('contractSection').classList.add('hidden');
        }, (error) => alert('Erreur lors de la validation du contrat: ' + error));
    });

    document.getElementById('rejectContract').addEventListener('click', function () {
        const contractId = parseInt(document.getElementById('contractId').textContent);
        ajax('POST', `/contrats-prets/${contractId}/reject`, {}, (response) => {
            alert('Contrat refusé.');
            document.getElementById('contractSection').classList.add('hidden');
        }, (error) => alert('Erreur lors du refus du contrat: ' + error));
    });

    document.getElementById('showSimulation').addEventListener('click', function () {
        const loanAmount = parseFloat(document.getElementById('contractLoanAmount').textContent);
        const repaymentTypeId = parseInt(document.getElementById('repaymentType').value);
        const loanDuration = parseInt(document.getElementById('contractDuration').textContent);
        const interestRate = parseFloat(document.getElementById('contractInterestRate').textContent) / 100;
        const insuranceRate = parseFloat(document.getElementById('contractInsuranceRate').textContent) / 100;
        const monthlyPayment = parseFloat(document.getElementById('contractMonthlyPayment').textContent);

        ajax('GET', `/types-remboursements/${repaymentTypeId}`, null, (repaymentType) => {
            const repaymentFreq = repaymentType.repetition_annuelle;
            const monthlyRate = interestRate / repaymentFreq;
            let remainingCapital = loanAmount;
            const simulationData = [];
            let tableBody = '';
            for (let i = 1; i <= loanDuration; i++) {
                const interest = remainingCapital * monthlyRate;
                const insurance = (insuranceRate / repaymentFreq) * loanAmount;
                const capitalRepaid = monthlyPayment - interest;
                const totalDue = monthlyPayment + insurance;
                const newRemainingCapital = remainingCapital - capitalRepaid;

                tableBody += `
                    <tr>
                        <td class="p-3">${i}</td>
                        <td class="p-3">${remainingCapital.toFixed(2)}</td>
                        <td class="p-3">${interest.toFixed(2)}</td>
                        <td class="p-3">${capitalRepaid.toFixed(2)}</td>
                        <td class="p-3">${insurance.toFixed(2)}</td>
                        <td class="p-3">${totalDue.toFixed(2)}</td>
                    </tr>
                `;
                simulationData.push({ period: i, remainingCapital, interest, capitalRepaid, insurance, totalDue });
                remainingCapital = newRemainingCapital;
            }
            document.getElementById('simulationTableBody').innerHTML = tableBody;
            document.getElementById('simulationSection').classList.remove('hidden');

            const ctx = document.getElementById('amortizationChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: simulationData.map(data => data.period),
                    datasets: [
                        { label: 'Capital restant dû (€)', data: simulationData.map(data => data.remainingCapital), borderColor: '#8B5CF6', fill: false },
                        { label: 'Intérêts (€)', data: simulationData.map(data => data.interest), borderColor: '#A78BFA', fill: false },
                        { label: 'Assurance (€)', data: simulationData.map(data => data.insurance), borderColor: '#6B7280', fill: false }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { title: { display: true, text: 'Période' } },
                        y: { title: { display: true, text: 'Montant (€)' } }
                    }
                }
            });
        }, (error) => alert('Erreur lors de la récupération du type de remboursement: ' + error));
    });
</script>
</body>