<?php include("../section/head.php"); ?>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4 font-sans antialiased">
<?php include("../section/navbar.php"); ?>

<div class="w-full max-w-7xl bg-white rounded-xl shadow-2xl p-8 mt-16">
    <h1 class="text-3xl font-bold text-purple-700 mb-8 text-center">Comparaison de Simulations de Prêt</h1>
    <div id="feedback" class="hidden p-4 mb-4 rounded-md text-sm"></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Simulation 1 Selection -->
        <div>
            <h2 class="text-2xl font-bold text-purple-700 mb-4">Première Simulation</h2>
            <div class="mb-6">
                <label for="simulation1" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner une simulation</label>
                <select id="simulation1" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required>
                    <option value="">Choisir une simulation enregistrée</option>
                </select>
            </div>
        </div>

        <!-- Simulation 2 Selection -->
        <div>
            <h2 class="text-2xl font-bold text-purple-700 mb-4">Deuxième Simulation</h2>
            <div class="mb-6">
                <label for="simulation2" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner une simulation</label>
                <select id="simulation2" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500" required>
                    <option value="">Choisir une simulation enregistrée</option>
                </select>
            </div>
        </div>
    </div>

    <button id="compareSimulations" type="button" class="w-full bg-purple-600 text-white text-sm font-medium py-3 rounded-md hover:bg-purple-700 transition">Comparer les simulations</button>

    <!-- Comparison Section -->
    <div id="comparisonSection" class="hidden mt-8 p-6 bg-gray-50 rounded-lg">
        <h2 class="text-2xl font-bold text-purple-700 mb-4">Résultats de la Comparaison</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Simulation 1 -->
            <div>
                <h3 class="text-xl font-medium text-gray-700 mb-4">Première Simulation</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-700 border border-gray-200">
                        <thead>
                        <tr class="bg-purple-100 text-gray-800">
                            <th class="p-3 text-left">Période</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Capital restant (€)</th>
                            <th class="p-3 text-left">Intérêts (€)</th>
                            <th class="p-3 text-left">Capital remboursé (€)</th>
                            <th class="p-3 text-left">Assurance (€)</th>
                            <th class="p-3 text-left">Total dû (€)</th>
                        </tr>
                        </thead>
                        <tbody id="simulation1TableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">Graphique</h4>
                    <canvas id="simulation1Chart" class="w-full h-80"></canvas>
                </div>
            </div>
            <!-- Simulation 2 -->
            <div>
                <h3 class="text-xl font-medium text-gray-700 mb-4">Deuxième Simulation</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-700 border border-gray-200">
                        <thead>
                        <tr class="bg-purple-100 text-gray-800">
                            <th class="p-3 text-left">Période</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Capital restant (€)</th>
                            <th class="p-3 text-left">Intérêts (€)</th>
                            <th class="p-3 text-left">Capital remboursé (€)</th>
                            <th class="p-3 text-left">Assurance (€)</th>
                            <th class="p-3 text-left">Total dû (€)</th>
                        </tr>
                        </thead>
                        <tbody id="simulation2TableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">Graphique</h4>
                    <canvas id="simulation2Chart" class="w-full h-80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="../../api/compare-simulation.js"></script>
</body>