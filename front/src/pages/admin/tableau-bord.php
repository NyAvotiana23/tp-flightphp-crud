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
                <select id="type-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base">
                    <option value="">Tous</option>
                    <option value="societe">Société</option>
                    <option value="entreprise">Entreprise</option>
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
        <button class="mt-4 bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base transition duration-300">
            Appliquer les Filtres
        </button>
    </section>

    <!-- Cards Section -->
    <section id="cards-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Les cartes seront injectées ici par JavaScript -->
    </section>
</div>

<script type='module' src='../../api/produit.js'></script>

</body>
