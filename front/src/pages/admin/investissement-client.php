<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple min-h-screen font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-h1 font-bold text-custom-black">Gestion des Investissements</h1>
        <p class="text-base text-custom-black mt-2">Suivez et gérez les investissements de vos clients avec efficacité.</p>
    </header>

    <!-- Filter Section -->
    <section class="mb-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="type-partenaire" class="block text-base text-custom-black mb-1">Type de Partenaire</label>
                <select id="type-partenaire" class="w-full p-2 rounded-lg border border-custom-purple-secondary text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous les types</option>
                    <option value="1">Type A</option>
                    <option value="2">Type B</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="partenaire" class="block text-base text-custom-black mb-1">Partenaire</label>
                <select id="partenaire" class="w-full p-2 rounded-lg border border-custom-purple-secondary text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous les partenaires</option>
                    <option value="1">Partenaire 1</option>
                    <option value="2">Partenaire 2</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Investments Table -->
    <section class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Liste des Investissements</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-base text-custom-black">
                <thead>
                <tr class="bg-custom-purple-secondary text-white">
                    <th class="p-3 text-h6 font-semibold">Partenaire</th>
                    <th class="p-3 text-h6 font-semibold">Type</th>
                    <th class="p-3 text-h6 font-semibold">Client</th>
                    <th class="p-3 text-h6 font-semibold">Montant Investi</th>
                    <th class="p-3 text-h6 font-semibold">Date Investissement</th>
                    <th class="p-3 text-h6 font-semibold">Taux Annuel</th>
                    <th class="p-3 text-h6 font-semibold">Retrait</th>
                </tr>
                </thead>
                <tbody>
                <tr class="border-b border-custom-purple-secondary hover:bg-custom-gray-purple">
                    <td class="p-3">Partenaire 1</td>
                    <td class="p-3">Type A</td>
                    <td class="p-3">Client 1</td>
                    <td class="p-3">10,000 €</td>
                    <td class="p-3">2025-01-15</td>
                    <td class="p-3">5.2%</td>
                    <td class="p-3">2,500 € (2025-06-01)</td>
                </tr>
                <tr class="border-b border-custom-purple-secondary hover:bg-custom-gray-purple">
                    <td class="p-3">Partenaire 2</td>
                    <td class="p-3">Type B</td>
                    <td class="p-3">Client 2</td>
                    <td class="p-3">15,000 €</td>
                    <td class="p-3">2025-03-10</td>
                    <td class="p-3">4.8%</td>
                    <td class="p-3">-</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Partner Details Section -->
    <section class="mt-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Détails du Partenaire</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-h4 font-semibold text-custom-black">Partenaire 1</h3>
                <p class="text-base text-custom-black mt-2"><strong>Type:</strong> Type A</p>
                <p class="text-base text-custom-black mt-2"><strong>Description:</strong> Partenaire spécialisé dans les investissements à long terme.</p>
                <p class="text-base text-custom-black mt-2"><strong>Commentaire:</strong> Fiable, bonne performance.</p>
                <p class="text-base text-custom-black mt-2"><strong>Dépôt Min/Max:</strong> 1,000 € / 50,000 €</p>
                <p class="text-base text-custom-black mt-2"><strong>Durée Min/Max:</strong> 6 mois / 5 ans</p>
                <p class="text-base text-custom-black mt-2"><strong>Taux Annuel:</strong> 5.2%</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-h4 font-semibold text-custom-black">Partenaire 2</h3>
                <p class="text-base text-custom-black mt-2"><strong>Type:</strong> Type B</p>
                <p class="text-base text-custom-black mt-2"><strong>Description:</strong> Investissements à court terme avec rendements rapides.</p>
                <p class="text-base text-custom-black mt-2"><strong>Commentaire:</strong> Risque modéré.</p>
                <p class="text-base text-custom-black mt-2"><strong>Dépôt Min/Max:</strong> 500 € / 30,000 €</p>
                <p class="text-base text-custom-black mt-2"><strong>Durée Min/Max:</strong> 3 mois / 2 ans</p>
                <p class="text-base text-custom-black mt-2"><strong>Taux Annuel:</strong> 4.8%</p>
            </div>
        </div>
    </section>
</div>
</body>
<script type="module" src='../../api/investissement.js'></script>