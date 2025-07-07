<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple text-custom-black font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">

    <!-- Login Form -->
    <div class="max-w-md mx-auto mb-12 bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">Connexion Client</h1>
        <form onsubmit="onSubmitClient(event)">
            <div class="mb-4">
                <label for="clientNumber" class="block text-h6 font-medium mb-2">Numéro Client</label>
                <input type="text" id="clientNumber" class="w-full p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" placeholder="Entrez votre numéro client">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-h6 font-medium mb-2">Mot de passe</label>
                <input type="password" id="password" class="w-full p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" placeholder="Entrez votre mot de passe">
            </div>
            <button type="submit" class="w-full bg-custom-purple-primary text-white py-2 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Se connecter</button>
        </form>
    </div>

    <!-- Client List and Filters -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-h2 font-bold text-custom-purple-primary mb-6">Liste des Clients</h2>
        <!-- Filters -->
        <div class="flex flex-wrap gap-4 mb-6">
            <input type="text" placeholder="Filtrer par Nom" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            <input type="text" placeholder="Filtrer par Email" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            <input type="text" placeholder="Filtrer par Numéro Client" class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
        </div>

        <!-- Client List -->
        <div class="overflow-x-auto">
            <table class="w-full text-base">
                <thead>
                <tr class="bg-custom-purple-secondary text-white">
                    <th class="p-3 text-left">Numéro Client</th>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Prénom</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
                </thead>
                <tbody id="clientList">
                <!-- Example Client Row -->
                <tr class="border-b border-custom-purple-secondary hover:bg-custom-gray-purple cursor-pointer" onclick="showClientDetails(1)">
                    <td class="p-3">C001</td>
                    <td class="p-3">Dupont</td>
                    <td class="p-3">Jean</td>
                    <td class="p-3">jean.dupont@example.com</td>
                    <td class="p-3">
                        <button class="text-custom-purple-primary hover:underline">Voir détails</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Floating Client Details Modal -->
    <div id="clientModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h3 class="text-h3 font-bold text-custom-purple-primary mb-4">Détails du Client</h3>
            <div id="clientDetails" class="text-base">
                <p><strong>ID:</strong> <span id="clientId">1</span></p>
                <p><strong>Numéro Client:</strong> <span id="clientNumberDetail">C001</span></p>
                <p><strong>Nom:</strong> <span id="clientLastName">Dupont</span></p>
                <p><strong>Prénom:</strong> <span id="clientFirstName">Jean</span></p>
                <p><strong>Date de Naissance:</strong> <span id="clientDOB">01/01/1980</span></p>
                <p><strong>Email:</strong> <span id="clientEmail">jean.dupont@example.com</span></p>
                <p><strong>Adresse:</strong> <span id="clientAddress">123 Rue Exemple, Paris</span></p>
                <p><strong>Contact:</strong> <span id="clientContact">+33 123 456 789</span></p>
            </div>
            <div class="mt-6">
                <h4 class="text-h4 font-medium mb-4">Connexion au compte</h4>
                <form onsubmit="onSubmitClient(event)">
                    <div class="mb-4">
                        <label for="modalClientNumber" class="block text-h6 font-medium mb-2">Numéro Client</label>
                        <input type="text" id="modalClientNumber" class="w-full p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" value="C001" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="modalPassword" class="block text-h6 font-medium mb-2">Mot de passe</label>
                        <input type="password" id="modalPassword" class="w-full p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary" placeholder="Mot de passe">
                    </div>
                    <button type="submit" class="w-full bg-custom-purple-primary text-white py-2 rounded-lg hover:bg-custom-purple-secondary transition duration-300">Se connecter</button>
                </form>
            </div>
            <button onclick="closeClientDetails()" class="mt-4 text-custom-purple-primary hover:underline">Fermer</button>
        </div>
    </div>
</div>

<script type='module' src='../../api/client.js'></script>
</body>
