<?php
include("../section/head.php");
?>
<body class="bg-gray-100 font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Header -->
    <h1 class="text-h1 font-bold text-custom-black mb-6">Gestion des Prêts</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Somme des intérêts par mois</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-base text-custom-black mb-2">Date de début</label>
                <input type="date" id="monthly_interest_start_date" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Date de fin</label>
                <input type="date" id="monthly_interest_end_date" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div class="flex items-end">
                <button id="showMonthlyInterestsBtn" class="bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Afficher les intérêts mensuels</button>
            </div>
        </div>

        <div id="monthlyInterestsSection" class="hidden">
            <h3 class="text-h4 font-semibold text-custom-black mb-4">Détails des intérêts mensuels</h3>
            <table class="w-full text-base mb-6">
                <thead>
                <tr class="bg-custom-gray-purple">
                    <th class="p-2 text-left">Mois</th>
                    <th class="p-2 text-left">Somme totale des intérêts (€)</th>
                </tr>
                </thead>
                <tbody id="monthlyInterestTableBody">
                </tbody>
            </table>
            <h3 class="text-h4 font-semibold text-custom-black mb-4">Graphique des intérêts mensuels</h3>
            <canvas id="monthlyInterestChart" class="w-full h-64"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-base text-custom-black mb-2">Date de début</label>
                <input type="date" id="date_debut_pret" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de prêt</label>
                <select id="id_type_pret" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de remboursement</label>
                <select id="id_type_remboursement" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Statut</label>
                <select id="id_status_contrat" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
        </div>
        <div class="flex flex-row gap-8 mt-8">
            <button onclick="filterLoans()" class="mt-4 bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Appliquer les filtres</button>
            =>> SI LOCAL STORAGE ID_CLIENT NOT NULL <a href="pret-form.php" class="mt-4 bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Faire un pret</a>
        </div>
    </div>

    <!-- Loan List -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-base">
            <thead>
            <tr class="bg-custom-gray-purple">
                <th class="p-4 text-left text-custom-black">Client</th>
                <th class="p-4 text-left text-custom-black">Montant</th>
                <th class="p-4 text-left text-custom-black">Type</th>
                <th class="p-4 text-left text-custom-black">Date début</th>
                <th class="p-4 text-left text-custom-black">Statut</th>
            </tr>
            </thead>
            <tbody id="loanTable">
            <!-- Populated dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Floating Loan Details -->
    <div id="loanDetails" class="hidden fixed top-0 right-0 h-full w-1/3 bg-white shadow-xl p-6 overflow-y-auto">
        <button onclick="closeLoanDetails()" class="text-custom-black text-h5 font-semibold mb-4">Fermer</button>
        <h2 class="text-h2 font-semibold text-custom-black mb-4">Détails du Prêt #<span id="loanId"></span></h2>
        <div class="mb-6">
            <h3 class="text-h4 font-semibold text-custom-black">Contrat</h3>
            <p class="text-base"><strong>ID Contrat:</strong> <span id="contractId"></span></p>
            <p class="text-base"><strong>UUID:</strong> <span id="contractUuid"></span></p>
            <p class="text-base"><strong>Type de remboursement:</strong> <span id="repaymentType"></span></p>
            <p class="text-base"><strong>Taux revenus:</strong> <span id="revenueRate"></span></p>
            <p class="text-base"><strong>Taux assurance:</strong> <span id="insuranceRate"></span></p>
            <p class="text-base"><strong>Durée:</strong> <span id="loanDuration"></span> mois</p>
            <p class="text-base"><strong>Montant prêt:</strong> <span id="loanAmount"></span></p>
            <p class="text-base"><strong>Échéance:</strong> <span id="dueDate"></span></p>
            <p class="text-base"><strong>Client:</strong> <span id="clientName"></span></p>
            <p class="text-base"><strong>Type de prêt:</strong> <span id="loanType"></span></p>
        </div>
        <div class="mb-6">
            <h3 class="text-h4 font-semibold text-custom-black">Statut</h3>
            <p class="text-base"><strong>Statut actuel:</strong> <span id="contractStatus"></span></p>
            <p class="text-base"><strong>Date statut:</strong> <span id="statusDate"></span></p>
        </div>
        <div class="mb-6">
            <a id="downloadPdfLink" href="#" class="bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Télécharger PDF</a>
            <button id="validateContractBtn" class="hidden bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-base">Valider</button>
        </div>
        <div>
            <h3 class="text-h4 font-semibold text-custom-black">Historique des remboursements</h3>
            <table class="w-full text-base">
                <thead>
                <tr class="bg-custom-gray-purple">
                    <th class="p-2 text-left">Période</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Total dû</th>
                    <th class="p-2 text-left">Intérêts</th>
                    <th class="p-2 text-left">Capital remboursé</th>
                    <th class="p-2 text-left">Capital restant</th>
                </tr>
                </thead>
                <tbody id="repaymentTable">
                <!-- Populated via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("../section/footer.php");
?>

<script type="module"  src="../../api/pret.js">
</script>
</body>
</html>
?>