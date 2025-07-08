<?php include("../section/head.php"); ?>
<body class="bg-custom-gray-purple min-h-screen p-6 font-sans">
<?php include("../section/navbar.php"); ?>
<div class="max-w-7xl mx-auto mt-16">

    <!-- Dashboard Header -->
    <header class="mb-8">
        <h1 class="text-h1 font-bold text-custom-black">Tableau de Bord - Gestion de Prêt et Investissement</h1>
        <p class="text-base text-custom-black mt-2">Filtrez et consultez les produits d'investissement des sociétés et entreprises.</p>
    </header>

    <!-- Filter Section -->
    <section class="mb-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="type-filter" class="block text-base font-medium text-custom-black">Type</label>
                <select id="typePartenaire" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base">
                    <option value="">Tous</option>
                </select>
            </div>
            <div>
                <label for="name-filter" class="block text-base font-medium text-custom-black">Nom du Produit</label>
                <input type="text" id="name-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base" placeholder="Rechercher par nom...">
            </div>
            <div>
                <label for="taux-filter" class="block text-base font-medium text-custom-black">Taux Annuel (%)</label>
                <input type="number" id="taux-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base" placeholder="Taux minimum...">
            </div>
        </div>
        <button id="apply-filters" class="mt-4 bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base transition duration-300">
            Appliquer les Filtres
        </button>
    </section>

    <!-- Cards Section -->
    <section id="cards-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Les cartes seront injectées ici par JavaScript -->
    </section>

    <!-- Investment Modal -->
    <div id="investment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-h3 font-semibold text-custom-black mb-4">Investir</h2>
            <form id="investment-form">
                <input type="hidden" id="id_partenaire" name="id_partenaire">
                <div class="mb-4">
                    <label for="montant_investi" class="block text-base font-medium text-custom-black">Montant à investir</label>
                    <input type="number" id="montant_investi" name="montant_investi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base" placeholder="Entrez le montant" required step="0.01" min="0">
                </div>
                <div class="mb-4">
                    <label for="date_investissement" class="block text-base font-medium text-custom-black">Date d'investissement</label>
                    <input type="date" id="date_investissement" name="date_investissement" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancel-investment" class="mr-2 bg-gray-300 hover:bg-gray-400 text-black font-medium py-2 px-4 rounded-md text-base">Annuler</button>
                    <button type="submit" class="bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base">Investir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type='module' src='../../api/produit.js'></script>
</body>