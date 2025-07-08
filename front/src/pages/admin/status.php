<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple text-custom-black font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Client Information Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">Statut du Compte Client</h1>
        <div id="clientInfo" class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <p class="text-h4"><strong>Nom:</strong> <span id="clientName"></span></p>
            <p class="text-h4"><strong>Numéro Client:</strong> <span id="clientNumber"></span></p>
            <p class="text-h4"><strong>Email:</strong> <span id="clientEmail"></span></p>
            <p class="text-h4"><strong>Solde Actuel:</strong> <span id="clientBalance">0.00 EUR</span></p>
        </div>
    </div>

    <!-- Activity Management Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-4">Gestion des Activités</h2>
        <form id="activityForm" class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="activityId">
            <div>
                <label for="typeContrat" class="block text-h6 font-medium mb-2">Type de Contrat</label>
                <select id="typeContrat" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" required>
                    <option value="">Sélectionner un type</option>
                </select>
            </div>
            <div>
                <label for="nomActivite" class="block text-h6 font-medium mb-2">Nom de l'Activité</label>
                <input type="text" id="nomActivite" class="p-2 border border-custom-purple-secondary rounded-lg w-full" required>
            </div>
            <div>
                <label for="revenuNetMensuel" class="block text-h6 font-medium mb-2">Revenu Net Mensuel (€)</label>
                <input type="number" id="revenuNetMensuel" step="0.01" class="p-2 border border-custom-purple-secondary rounded-lg w-full" required>
            </div>
            <div>
                <label for="dateDebut" class="block text-h6 font-medium mb-2">Date de Début</label>
                <input type="date" id="dateDebut" class="p-2 border border-custom-purple-secondary rounded-lg w-full" required>
            </div>
            <div>
                <label for="dateFin" class="block text-h6 font-medium mb-2">Date de Fin (optionnel)</label>
                <input type="date" id="dateFin" class="p-2 border border-custom-purple-secondary rounded-lg w-full">
            </div>
            <div class="flex gap-4">
                <button type="submit" id="saveActivity" class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Enregistrer</button>
                <button type="button" id="cancelEdit" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-300 hidden">Annuler</button>
            </div>
        </form>

        <!-- Activity List -->
        <div class="overflow-x-auto">
            <table class="w-full text-base">
                <thead>
                <tr class="bg-custom-purple-secondary text-white">
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Revenu Mensuel</th>
                    <th class="p-3 text-left">Date Début</th>
                    <th class="p-3 text-left">Date Fin</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
                </thead>
                <tbody id="activityList">
                <!-- Activities will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Filter and List Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-4">Mouvements Bancaires</h2>
        <!-- Date and Movement Type Filter -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div>
                <label for="transactionDate" class="block text-h6 font-medium mb-2">Date</label>
                <input type="date" id="transactionDate" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" value="2025-07-07">
            </div>
            <div>
                <label for="movementType" class="block text-h6 font-medium mb-2">Type de Mouvement</label>
                <select id="movementType" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="all">Tous</option>
                    <option value="deposit">Dépôt</option>
                    <option value="withdrawal">Retrait</option>
                    <option value="loan">Prêt</option>
                    <option value="investment">Investissement</option>
                </select>
            </div>
            <button id="filterTransactions" class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Filtrer</button>
        </div>
        <!-- Action Buttons -->
        <div class="flex gap-4 mb-6">
            <a href="pret.php" class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Faire un Prêt</a>
            <a href="tableau-bord.php" class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Investir</a>
        </div>

        <!-- Transaction List -->
        <div class="overflow-x-auto">
            <table class="w-full text-base">
                <thead>
                <tr class="bg-custom-purple-secondary text-white">
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Montant</th>
                    <th class="p-3 text-left">Description</th>
                </tr>
                </thead>
                <tbody id="transactionList">
                <!-- Transactions will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Final Balance -->
        <div class="mt-6 text-right">
            <p class="text-h4 font-bold"><strong>Solde Final:</strong> <span id="finalBalance">0.00 EUR</span></p>
        </div>
    </div>


</div>
<script type="module" src="../../api/status.js"></script>
</body>