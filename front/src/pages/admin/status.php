<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple text-custom-black font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Account Status Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-12">
        <h1 class="text-h1 font-bold text-custom-purple-primary mb-6 text-center">Statut du Compte Client</h1>
        <div id="clientInfo" class="mb-6">
            <p class="text-h4"><strong>Nom:</strong> <span id="clientName"></span></p>
            <p class="text-h4"><strong>Numéro Client:</strong> <span id="clientNumber"></span></p>
            <p class="text-h4"><strong>Solde Actuel:</strong> <span id="clientBalance">0.00 EUR</span></p>
        </div>

        <!-- Date and Movement Type Filter -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div>
                <label for="transactionDate" class="block text-h6 font-medium mb-2">Date</label>
                <input type="date" id="transactionDate"
                       class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary"
                       value="2025-07-07">
            </div>
            <div>
                <label for="movementType" class="block text-h6 font-medium mb-2">Type de Mouvement</label>
                <select id="movementType"
                        class="p-2 border border-custom-purple-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="all">Tous</option>
                    <option value="deposit">Dépôt</option>
                    <option value="withdrawal">Retrait</option>
                    <option value="loan">Prêt</option>
                    <option value="investment">Investissement</option>
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mb-6">
            <a href="pret.php"
               class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">
                Faire un Prêt
            </a>
            <a href="tableau-bord.php"
               class="bg-custom-purple-primary text-white py-2 px-4 rounded-lg hover:bg-custom-purple-secondary transition duration-300">
                Investir
            </a>
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
    <script>
        // Mock client data from localStorage
        function loadClientData() {
            const client = JSON.parse(localStorage.getItem('client')) || {
                numeroClient: 'C001',
                nom: 'Dupont',
                prenom: 'Jean',
                balance: 1000.00,
                transactions: []
            };
            document.getElementById('clientNumber').textContent = client.numeroClient;
            document.getElementById('clientName').textContent = `${client.prenom} ${client.nom}`;
            document.getElementById('clientBalance').textContent = `${client.balance.toFixed(2)} EUR`;
            return client;
        }

        // Load and display transactions
        function loadTransactions(filterType = 'all', filterDate = '2025-07-07') {
            const client = loadClientData();
            const transactions = client.transactions.filter(t => {
                return (filterType === 'all' || t.type === filterType) && (!filterDate || t.date === filterDate);
            });

            const transactionList = document.getElementById('transactionList');
            transactionList.innerHTML = '';
            transactions.forEach(t => {
                const row = document.createElement('tr');
                row.className = 'border-b border-custom-purple-secondary';
                row.innerHTML = `
                    <td class="p-3">${t.date}</td>
                    <td class="p-3">${t.type}</td>
                    <td class="p-3">${t.amount.toFixed(2)} EUR</td>
                    <td class="p-3">${t.description}</td>
                `;
                transactionList.appendChild(row);
            });

            const finalBalance = transactions.reduce((sum, t) => sum + (t.type === 'deposit' || t.type === 'loan' ? t.amount : -t.amount), client.balance);
            document.getElementById('finalBalance').textContent = `${finalBalance.toFixed(2)} EUR`;
        }



        // Initial load
        loadTransactions();
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
        });
    </script>
</body>
