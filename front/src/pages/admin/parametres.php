<?php
include("../section/head.php");
?>

<body class="bg-custom-gray-purple min-h-screen font-sans text-custom-black">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-12 mt-16">
    <!-- Page Header -->
    <header class="mb-12 text-center">
        <h1 class="text-h1 font-bold text-custom-purple-primary mb-4">Gestion des Prêts et Investissements</h1>
        <p class="text-base text-custom-black max-w-2xl mx-auto">Administrez efficacement les types de mouvements
            bancaires, contrats, remboursements et prêts pour votre établissement financier.</p>
    </header>

    <!-- Main Content -->
    <main class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Types de Mouvements Bancaires -->
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">Types de Mouvements Bancaires</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-h4 font-medium">Liste des Mouvements</h3>
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition"
                            onclick="openModal('bank-movement-types')">
                        Ajouter
                    </button>
                </div>
                <table id="bank-movement-types" class="w-full text-left">
                    <thead>
                    <tr class="text-h6 text-custom-black">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- Types de Contrats d'Activité -->
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">Types de Contrats d'Activité</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-h4 font-medium">Liste des Contrats</h3>
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition"
                            onclick="openModal('contract-types')">
                        Ajouter
                    </button>
                </div>
                <table id="contract-types" class="w-full text-left">
                    <thead>
                    <tr class="text-h6 text-custom-black">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- Types de Mouvements d'Établissements -->
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">Types de Mouvements d'Établissements</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-h4 font-medium">Liste des Mouvements</h3>
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition"
                            onclick="openModal('establishment-movement-types')">
                        Ajouter
                    </button>
                </div>
                <table id="establishment-movement-types" class="w-full text-left">
                    <thead>
                    <tr class="text-h6 text-custom-black">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- Types de Remboursements -->
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">Types de Remboursements</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-h4 font-medium">Liste des Remboursements</h3>
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition"
                            onclick="openModal('repayment-types')">
                        Ajouter
                    </button>
                </div>
                <table id="repayment-types" class="w-full text-left">
                    <thead>
                    <tr class="text-h6 text-custom-black">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Répétition Annuelle</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- Types de Prêts -->
        <section class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">Types de Prêts</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-h4 font-medium">Liste des Prêts</h3>
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition"
                            onclick="openModal('loan-types')">
                        Ajouter
                    </button>
                </div>
                <table id="loan-types" class="w-full text-left">
                    <thead>
                    <tr class="text-h6 text-custom-black">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Taux Min (%)</th>
                        <th class="py-2">Taux Max (%)</th>
                        <th class="py-2">Motif</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<script type='module'  src="../../api/parametres.js">
</script>
</body>
</html>