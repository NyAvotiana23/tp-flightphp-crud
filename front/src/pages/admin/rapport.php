<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple min-h-screen font-sans text-custom-black">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-h1 font-bold text-custom-purple-primary">Gestion des Prêts et Investissements</h1>
        <p class="text-base text-custom-black mt-2">Suivez l'état financier de votre établissement en temps réel.</p>
    </header>

    <!-- Filters Section -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-purple-primary mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date-filter" class="block text-base font-medium mb-2">Date du mouvement</label>
                <input type="date" id="date-filter" class="w-full p-2 border border-custom-purple-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label for="type-filter" class="block text-base font-medium mb-2">Type de mouvement</label>
                <select id="type-filter" class="w-full p-2 border border-custom-purple-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <option value="gain_fond">Gain Fond</option>
                    <option value="retour_fond">Retour Fond</option>
                    <option value="sortis_pret">Sortis Prêt</option>
                    <option value="remboursement_pret">Remboursement Prêt</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-custom-purple-primary text-white p-2 rounded-md hover:bg-custom-purple-secondary transition duration-200">Appliquer les filtres</button>
            </div>
        </div>
    </section>

    <!-- Financial Status Section -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-purple-primary mb-4">Statut de l'Établissement Financier</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-base font-medium">Nom de l'établissement</p>
                <p class="text-custom-lg text-custom-black">[Nom de l'Établissement]</p>
            </div>
            <div>
                <p class="text-base font-medium">Lieu</p>
                <p class="text-custom-lg text-custom-black">[Lieu de l'Établissement]</p>
            </div>
            <div>
                <p class="text-base font-medium">Numéro d'identification</p>
                <p class="text-custom-lg text-custom-black">[Numéro d'Identification]</p>
            </div>
            <div>
                <p class="text-base font-medium">Date de création</p>
                <p class="text-custom-lg text-custom-black">[Date de Création]</p>
            </div>
            <div class="col-span-2">
                <p class="text-base font-medium">Commentaire</p>
                <p class="text-base text-custom-black">[Commentaire]</p>
            </div>
        </div>
    </section>

    <!-- Transactions Table -->
    <section class="bg-white rounded-lg shadow p-6">
        <h2 class="text-h3 font-semibold text-custom-purple-primary mb-4">Mouvements Financiers</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                <tr class="bg-custom-purple-secondary text-white">
                    <th class="p-3 text-base font-semibold">Date</th>
                    <th class="p-3 text-base font-semibold">Type de mouvement</th>
                    <th class="p-3 text-base font-semibold">Montant</th>
                </tr>
                </thead>
                <tbody>
                <tr class="border-b border-custom-purple-secondary">
                    <td class="p-3 text-base">[Date]</td>
                    <td class="p-3 text-base">[TypeMouvementEF]</td>
                    <td class="p-3 text-base">[Montant]</td>
                </tr>
                <!-- Additional rows can be dynamically added here -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Total Balance -->
    <section class="mt-8 text-center">
        <h2 class="text-h2 font-bold text-custom-purple-primary">Solde Total</h2>
        <p class="text-h1 text-custom-black">[Montant Total]</p>
        <p class="text-custom-sm text-custom-black">À la date du [Date]</p>
    </section>
</div>
</body>
