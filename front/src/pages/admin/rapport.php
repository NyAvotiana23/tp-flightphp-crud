<?php include("../section/head.php"); ?>
<body class="bg-custom-gray-purple min-h-screen font-sans text-custom-black">
<?php include("../section/navbar.php"); ?>
<div class="container mx-auto px-4 py-8 mt-16">

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
            <div>
                <label for="date-debut" class="block text-base font-medium mb-2">Date de début</label>
                <input type="date" id="date-debut"
                    class="w-full p-2 border border-custom-purple-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label for="date-fin" class="block text-base font-medium mb-2">Date de fin</label>
                <input type="date" id="date-fin"
                    class="w-full p-2 border border-custom-purple-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            </div>
            <div>
                <label for="type-filter" class="block text-base font-medium mb-2">Type de mouvement</label>
                <select id="type-filter"
                        class="w-full p-2 border border-custom-purple-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="applyFiltersBtn" class="w-full bg-custom-purple-primary text-white p-2 rounded-md hover:bg-custom-purple-secondary transition duration-200">
                    Appliquer les filtres
                </button>
            </div>
        </div>
    </section>

    <!-- Financial Status Section -->
    <section class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-purple-primary mb-4">Statut de l'Établissement Financier</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Rempli dynamiquement -->
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
                    <!-- Rempli dynamiquement -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Total Balance -->
    <section class="mt-8 text-center">
        <h2 class="text-h2 font-bold text-custom-purple-primary">Solde Total</h2>
        <p class="text-h1 text-custom-black">0 €</p>
        <p class="text-custom-sm text-custom-black">À la date du -</p>
    </section>
</div>

<!-- Navbar auto-hide on scroll -->
<script>
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
    });
</script>

<script type="module" src="../../api/rapport.js"></script>
</body>
