<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple min-h-screen flex flex-col items-center justify-center p-4 font-sans">
<?php
include("../section/navbar.php");
?>
<!-- Main Container -->
<div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mt-16">
    <!-- Header -->
    <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">
        Demande de Prêt
    </h1>

    <!-- Loan Application Form -->
    <form id="loanForm" class="space-y-6">
        <div>
            <label for="loanAmount" class="block text-h6 font-medium text-custom-black mb-2">
                Montant du prêt (€)
            </label>
            <input
                type="number"
                id="loanAmount"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                placeholder="Ex: 100000"
                required
            />
        </div>

        <div>
            <label for="loanType" class="block text-h6 font-medium text-custom-black mb-2">
                Type de prêt
            </label>
            <select
                id="loanType"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                required
            >
                <option value="">Sélectionnez un type de prêt</option>
                <option value="1">Prêt immobilier (2.5% - 4%)</option>
                <option value="2">Prêt personnel (3% - 6%)</option>
                <option value="3">Prêt auto (2% - 5%)</option>
            </select>
        </div>

        <div>
            <label for="repaymentType" class="block text-h6 font-medium text-custom-black mb-2">
                Type de remboursement
            </label>
            <select
                id="repaymentType"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                required
            >
                <option value="">Sélectionnez une périodicité</option>
                <option value="12">Mensuel (12 fois par an)</option>
                <option value="4">Trimestriel (4 fois par an)</option>
                <option value="1">Annuel (1 fois par an)</option>
            </select>
        </div>

        <div>
            <label for="loanDuration" class="block text-h6 font-medium text-custom-black mb-2">
                Durée du prêt (mois)
            </label>
            <input
                type="number"
                id="loanDuration"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                placeholder="Ex: 120"
                required
            />
        </div>

        <div>
            <label for="interestRate" class="block text-h6 font-medium text-custom-black mb-2">
                Taux d'intérêt annuel (%)
            </label>
            <input
                type="number"
                step="0.01"
                id="interestRate"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                placeholder="Ex: 3.5"
                required
            />
        </div>

        <div>
            <label for="insuranceRate" class="block text-h6 font-medium text-custom-black mb-2">
                Taux d'assurance (%)
            </label>
            <input
                type="number"
                step="0.01"
                id="insuranceRate"
                class="w-full border border-custom-purple-secondary rounded-md p-3 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                placeholder="Ex: 0.5"
                required
            />
        </div>

        <button
            type="submit"
            class="w-full bg-custom-purple-primary text-white text-h6 font-medium py-3 rounded-md hover:bg-custom-purple-secondary transition duration-300"
        >
            Soumettre la demande
        </button>
    </form>

    <!-- Contract Section (Hidden by default) -->
    <div id="contractSection" class="hidden mt-8 p-6 bg-custom-gray-purple rounded-lg">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-4">Contrat de Prêt</h2>
        <div id="contractDetails" class="space-y-4 text-base text-custom-black">
            <!-- Contract details will be populated dynamically -->
            <p><strong>Montant du prêt:</strong> <span id="contractLoanAmount"></span> €</p>
            <p><strong>Type de prêt:</strong> <span id="contractLoanType"></span></p>
            <p><strong>Type de remboursement:</strong> <span id="contractRepaymentType"></span></p>
            <p><strong>Durée:</strong> <span id="contractDuration"></span> mois</p>
            <p><strong>Taux d'intérêt annuel:</strong> <span id="contractInterestRate"></span>%</p>
            <p><strong>Taux d'assurance:</strong> <span id="contractInsuranceRate"></span>%</p>
            <p><strong>Mensualité estimée:</strong> <span id="contractMonthlyPayment"></span> €</p>
        </div>

        <div class="flex space-x-4 mt-6">
            <button
                id="acceptContract"
                class="bg-custom-purple-primary text-white text-h6 font-medium py-2 px-4 rounded-md hover:bg-custom-purple-secondary transition duration-300"
            >
                Valider le contrat
            </button>
            <button
                id="rejectContract"
                class="bg-red-500 text-white text-h6 font-medium py-2 px-4 rounded-md hover:bg-red-600 transition duration-300"
            >
                Refuser le contrat
            </button>
            <button
                id="showSimulation"
                class="bg-custom-black text-white text-h6 font-medium py-2 px-4 rounded-md hover:bg-gray-700 transition duration-300"
            >
                Voir la simulation
            </button>
        </div>
    </div>

    <!-- Simulation Section (Hidden by default) -->
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
                    <th class="p-3 text-left">Total dû (€)</th>
                </tr>
                </thead>
                <tbody id="simulationTableBody">
                <!-- Simulation data will be populated dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Chart for Amortization -->
        <div class="mt-6">
            <h3 class="text-h3 font-medium text-custom-black mb-4">Graphique d'amortissement</h3>
            <canvas id="amortizationChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js for the amortization chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Form submission handler
    document.getElementById('loanForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const loanAmount = parseFloat(document.getElementById('loanAmount').value);
        const loanType = document.getElementById('loanType').options[document.getElementById('loanType').selectedIndex].text;
        const repaymentType = document.getElementById('repaymentType').options[document.getElementById('repaymentType').selectedIndex].text;
        const repaymentFreq = parseInt(document.getElementById('repaymentType').value);
        const loanDuration = parseInt(document.getElementById('loanDuration').value);
        const interestRate = parseFloat(document.getElementById('interestRate').value) / 100;
        const insuranceRate = parseFloat(document.getElementById('insuranceRate').value) / 100;

        // Calculate monthly payment using amortization formula
        const monthlyRate = interestRate / repaymentFreq;
        const numPayments = loanDuration;
        const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -numPayments));

        // Populate contract details
        document.getElementById('contractLoanAmount').textContent = loanAmount.toFixed(2);
        document.getElementById('contractLoanType').textContent = loanType;
        document.getElementById('contractRepaymentType').textContent = repaymentType;
        document.getElementById('contractDuration').textContent = loanDuration;
        document.getElementById('contractInterestRate').textContent = (interestRate * 100).toFixed(2);
        document.getElementById('contractInsuranceRate').textContent = (insuranceRate * 100).toFixed(2);
        document.getElementById('contractMonthlyPayment').textContent = monthlyPayment.toFixed(2);

        // Show contract section
        document.getElementById('contractSection').classList.remove('hidden');
    });

    // Accept contract
    document.getElementById('acceptContract').addEventListener('click', function () {
        alert('Contrat validé avec succès !');
        document.getElementById('contractSection').classList.add('hidden');
    });

    // Reject contract
    document.getElementById('rejectContract').addEventListener('click', function () {
        alert('Contrat refusé.');
        document.getElementById('contractSection').classList.add('hidden');
    });

    // Show simulation
    document.getElementById('showSimulation').addEventListener('click', function () {
        const loanAmount = parseFloat(document.getElementById('contractLoanAmount').textContent);
        const repaymentFreq = parseInt(document.getElementById('repaymentType').value);
        const loanDuration = parseInt(document.getElementById('contractDuration').textContent);
        const interestRate = parseFloat(document.getElementById('contractInterestRate').textContent) / 100;
        const monthlyPayment = parseFloat(document.getElementById('contractMonthlyPayment').textContent);

        const monthlyRate = interestRate / repaymentFreq;
        let remainingCapital = loanAmount;
        const simulationData = [];

        // Generate amortization table
        let tableBody = '';
        for (let i = 1; i <= loanDuration; i++) {
            const interest = remainingCapital * monthlyRate;
            const capitalRepaid = monthlyPayment - interest;
            const newRemainingCapital = remainingCapital - capitalRepaid;

            tableBody += `
                    <tr>
                        <td class="p-3">${i}</td>
                        <td class="p-3">${remainingCapital.toFixed(2)}</td>
                        <td class="p-3">${interest.toFixed(2)}</td>
                        <td class="p-3">${capitalRepaid.toFixed(2)}</td>
                        <td class="p-3">${monthlyPayment.toFixed(2)}</td>
                    </tr>
                `;

            simulationData.push({
                period: i,
                remainingCapital: remainingCapital,
                interest: interest,
                capitalRepaid: capitalRepaid
            });

            remainingCapital = newRemainingCapital;
        }

        document.getElementById('simulationTableBody').innerHTML = tableBody;
        document.getElementById('simulationSection').classList.remove('hidden');

        // Create chart
        const ctx = document.getElementById('amortizationChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: simulationData.map(data => data.period),
                datasets: [
                    {
                        label: 'Capital restant dû (€)',
                        data: simulationData.map(data => data.remainingCapital),
                        borderColor: '#8B5CF6',
                        fill: false
                    },
                    {
                        label: 'Intérêts (€)',
                        data: simulationData.map(data => data.interest),
                        borderColor: '#A78BFA',
                        fill: false
                    }
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
    });
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
    });
</script>
</body>
