<?php include("../section/head.php"); ?>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">
<?php include("../section/navbar.php"); ?>

<div class="w-full max-w-5xl bg-white rounded-xl shadow-2xl p-8 mt-16">
    <h1 class="text-3xl font-bold text-purple-700 mb-8 text-center">Demande de Prêt</h1>
    <div id="feedback" class="hidden p-4 mb-4 rounded-md text-sm"></div>
    <form id="loanForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="clientId" class="block text-sm font-medium text-gray-700 mb-2">ID Client</label>
                <select id="clientId" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required>
                    <option value="">Sélectionnez un client</option>
                </select>
            </div>
            <div>
                <label for="loanAmount" class="block text-sm font-medium text-gray-700 mb-2">Montant du prêt (€)</label>
                <input type="number" id="loanAmount" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required min="1000" step="100"/>
            </div>
            <div>
                <label for="loanType" class="block text-sm font-medium text-gray-700 mb-2">Type de prêt</label>
                <select id="loanType" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required>
                    <option value="">Sélectionnez un type de prêt</option>
                </select>
            </div>
            <div>
                <label for="repaymentType" class="block text-sm font-medium text-gray-700 mb-2">Type de remboursement</label>
                <select id="repaymentType" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required>
                    <option value="">Sélectionnez une périodicité</option>
                </select>
            </div>
            <div>
                <label for="loanDuration" class="block text-sm font-medium text-gray-700 mb-2">Durée du prêt (mois)</label>
                <input type="number" id="loanDuration" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required min="1"/>
            </div>
            <div>
                <label for="interestRate" class="block text-sm font-medium text-gray-700 mb-2">Taux d'intérêt annuel (%)</label>
                <input type="number" step="0.01" id="interestRate" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required min="0"/>
            </div>
            <div>
                <label for="insuranceRate" class="block text-sm font-medium text-gray-700 mb-2">Taux d'assurance (%)</label>
                <input type="number" step="0.01" id="insuranceRate" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required min="0"/>
            </div>
            <div>
                <label for="repaymentDelay" class="block text-sm font-medium text-gray-700 mb-2">Délai de remboursement (mois)</label>
                <input type="number" id="repaymentDelay" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" min="0" value="0"/>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
            <button id="submitLoan" type="submit" class="flex-1 bg-purple-600 text-white text-sm font-medium py-3 rounded-md hover:bg-purple-700 transition">Soumettre la demande</button>
            <button id="viewSimulation" type="button" class="flex-1 bg-blue-600 text-white text-sm font-medium py-3 rounded-md hover:bg-blue-700 transition">Voir la simulation</button>
            <button id="saveSimulation" type="button" class="flex-1 bg-green-600 text-white text-sm font-medium py-3 rounded-md hover:bg-green-700 transition">Sauvegarder la simulation</button>
        </div>
    </form>

    <div id="contractSection" class="hidden mt-8 p-6 bg-gray-50 rounded-lg">
        <h2 class="text-2xl font-bold text-purple-700 mb-4">Contrat de Prêt</h2>
        <div id="contractDetails" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
            <p><strong>ID Contrat:</strong> <span id="contractId"></span></p>
            <p><strong>Montant du prêt:</strong> <span id="contractLoanAmount"></span> €</p>
            <p><strong>Type de prêt:</strong> <span id="contractLoanType"></span></p>
            <p><strong>Type de remboursement:</strong> <span id="contractRepaymentType"></span></p>
            <p><strong>Durée:</strong> <span id="contractDuration"></span> mois</p>
            <p><strong>Taux d'intérêt annuel:</strong> <span id="contractInterestRate"></span>%</p>
            <p><strong>Taux d'assurance:</strong> <span id="contractInsuranceRate"></span>%</p>
            <p><strong>Délai de remboursement:</strong> <span id="contractDelay"></span> mois</p>
            <p><strong>Mensualité estimée:</strong> <span id="contractMonthlyPayment"></span> €</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4 mt-6">
            <button id="acceptContract" class="bg-purple-600 text-white text-sm font-medium py-2 px-4 rounded-md hover:bg-purple-700 transition">Valider le contrat</button>
            <button id="rejectContract" class="bg-red-500 text-white text-sm font-medium py-2 px-4 rounded-md hover:bg-red-600 transition">Refuser le contrat</button>
            <button id="showSimulation" class="bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-md hover:bg-gray-700 transition">Voir la simulation</button>
        </div>
    </div>

    <div id="simulationSection" class="hidden mt-8 p-6 bg-gray-50 rounded-lg">
        <h2 class="text-2xl font-bold text-purple-700 mb-4">Simulation de Remboursement</h2>
        <div id="simulationTable" class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700 border border-gray-200">
                <thead>
                <tr class="bg-purple-100 text-gray-800">
                    <th class="p-3 text-left">Période</th>
                    <th class="p-3 text-left">Date Remboursement</th>
                    <th class="p-3 text-left">Capital restant dû (€)</th>
                    <th class="p-3 text-left">Intérêts (€)</th>
                    <th class="p-3 text-left">Capital remboursé (€)</th>
                    <th class="p-3 text-left">Assurance (€)</th>
                    <th class="p-3 text-left">Total dû (€)</th>
                </tr>
                </thead>
                <tbody id="simulationTableBody" class="divide-y divide-gray-200"></tbody>
            </table>
        </div>
        <div class="mt-6">
            <h3 class="text-xl font-medium text-gray-700 mb-4">Graphique d'amortissement</h3>
            <canvas id="amortizationChart" class="w-full h-80"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="../../api/pret-form.js"></script>
</body>