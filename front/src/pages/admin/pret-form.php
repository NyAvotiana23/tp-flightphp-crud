<?php include("../section/head.php"); ?>
<body class="bg-custom-gray-purple min-h-screen flex flex-col items-center justify-center p-4 font-sans">
<?php include("../section/navbar.php"); ?>

<div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mt-16">
    <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">Demande de Prêt</h1>
    <form id="loanForm" class="space-y-6">
        <div>
            <label for="clientId" class="block text-h6 font-medium text-custom-black mb-2">ID Client</label>
            <input type="number" id="clientId" class="w-full border border-custom-purple-secondary rounded-md p-3"
                   required/>
        </div>
        <div>
            <label for="loanAmount" class="block text-h6 font-medium text-custom-black mb-2">Montant du prêt (€)</label>
            <input type="number" id="loanAmount" class="w-full border border-custom-purple-secondary rounded-md p-3"
                   required/>
        </div>
        <div>
            <label for="loanType" class="block text-h6 font-medium text-custom-black mb-2">Type de prêt</label>
            <select id="loanType" class="w-full border border-custom-purple-secondary rounded-md p-3" required>
                <option value="">Sélectionnez un type de prêt</option>
            </select>
        </div>
        <div>
            <label for="repaymentType" class="block text-h6 font-medium text-custom-black mb-2">Type de
                remboursement</label>
            <select id="repaymentType" class="w-full border border-custom-purple-secondary rounded-md p-3" required>
                <option value="">Sélectionnez une périodicité</option>
            </select>
        </div>
        <div>
            <label for="loanDuration" class="block text-h6 font-medium text-custom-black mb-2">Durée du prêt
                (mois)</label>
            <input type="number" id="loanDuration" class="w-full border border-custom-purple-secondary rounded-md p-3"
                   required/>
        </div>
        <div>
            <label for="interestRate" class="block text-h6 font-medium text-custom-black mb-2">Taux d'intérêt annuel
                (%)</label>
            <input type="number" step="0.01" id="interestRate"
                   class="w-full border border-custom-purple-secondary rounded-md p-3" required/>
        </div>
        <div>
            <label for="insuranceRate" class="block text-h6 font-medium text-custom-black mb-2">Taux d'assurance
                (%)</label>
            <input type="number" step="0.01" id="insuranceRate"
                   class="w-full border border-custom-purple-secondary rounded-md p-3" required/>
        </div>
        <div>
            <label for="repaymentDelay" class="block text-h6 font-medium text-custom-black mb-2">Délai de remboursement
                (mois)</label>
            <input type="number" id="repaymentDelay"
                   class="w-full border border-custom-purple-secondary rounded-md p-3"/>
        </div>
        <button type="submit" class="w-full bg-custom-purple-primary text-white text-h6 font-medium py-3 rounded-md">
            Soumettre la demande
        </button>
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
            <button id="acceptContract"
                    class="bg-custom-purple-primary text-white text-h6 font-medium py-2 px-4 rounded-md">Valider le
                contrat
            </button>
            <button id="rejectContract" class="bg-red-500 text-white text-h6 font-medium py-2 px-4 rounded-md">Refuser
                le contrat
            </button>
            <button id="showSimulation" class="bg-custom-black text-white text-h6 font-medium py-2 px-4 rounded-md">Voir
                la simulation
            </button>
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

<script type="module" src="../../api/pret-form.js">
</script>

</body>
