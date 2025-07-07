<?php
include("../section/head.php");
?>
<body class="bg-gray-100 font-sans">
<nav id="navbar"
     class="fixed top-0 left-0 right-0 bg-custom-purple-primary text-white shadow-lg transition-transform duration-300 ease-in-out z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-h5 font-bold">Administration Financière</h1>
        <ul class="flex space-x-6">
            <li><a href="tableau-bord.php" class="hover:text-custom-purple-secondary text-base ">Nos partenaires</a>
            </li>
            <li><a href="pret.php" class="hover:text-custom-purple-secondary text-base">Prêts</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary text-base">Investissements</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary text-base">Rapports</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary text-base">Paramètres</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary text-base">Clients</a></li>
        </ul>
    </div>
</nav>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Header -->
    <h1 class="text-h1 font-bold text-custom-black mb-6">Gestion des Prêts</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-base text-custom-black mb-2">Date de début</label>
                <input type="date" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de prêt</label>
                <select class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option>Tous</option>
                    <option>Immobilier</option>
                    <option>Consommation</option>
                    <option>Investissement</option>
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de remboursement</label>
                <select class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option>Tous</option>
                    <option>Mensuel</option>
                    <option>Trimestriel</option>
                    <option>Annuel</option>
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Statut</label>
                <select class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option>Tous</option>
                    <option>En attente</option>
                    <option>Validé</option>
                    <option>Refusé</option>
                </select>
            </div>
        </div>
        <button class="mt-4 bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Appliquer les filtres</button>
    </div>

    <!-- Loan List -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-base">
            <thead>
            <tr class="bg-custom-gray-purple">
                <th class="p-4 text-left text-custom-black">ID Prêt</th>
                <th class="p-4 text-left text-custom-black">Client</th>
                <th class="p-4 text-left text-custom-black">Montant</th>
                <th class="p-4 text-left text-custom-black">Type</th>
                <th class="p-4 text-left text-custom-black">Date début</th>
                <th class="p-4 text-left text-custom-black">Statut</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover:bg-custom-gray-purple cursor-pointer" onclick="showLoanDetails('123')">
                <td class="p-4">123</td>
                <td class="p-4">Jean Dupont</td>
                <td class="p-4">100 000 €</td>
                <td class="p-4">Immobilier</td>
                <td class="p-4">2025-01-01</td>
                <td class="p-4">Validé</td>
            </tr>
            <!-- More rows dynamically populated -->
            </tbody>
        </table>
    </div>

    <!-- Floating Loan Details -->
    <div id="loanDetails" class="hidden fixed top-0 right-0 h-full w-1/3 bg-white shadow-xl p-6 overflow-y-auto">
        <button onclick="closeLoanDetails()" class="text-custom-black text-h5 font-semibold mb-4">Fermer</button>
        <h2 class="text-h2 font-semibold text-custom-black mb-4">Détails du Prêt #123</h2>
        <div class="mb-6">
            <h3 class="text-h4 font-semibold text-custom-black">Contrat</h3>
            <p class="text-base"><strong>ID Contrat:</strong> <span id="contractId"></span></p>
            <p class="text-base"><strong>UUID:</strong> <span id="contractUuid"></span></p>
            <p class="text-base"><strong>Type de remboursement:</strong> <span id="repaymentType"></span></p>
            <p class="text-base"><strong>Taux revenus:</strong> <span id="revenueRate"></span></p>
            <p class="text-base"><strong>Taux assurance:</strong> <span id="insuranceRate"></span></p>
            <p class="text-base"><strong>Durée:</strong> <span id="loanDuration"></span> mois</p>
            <p class="text-base"><strong>Montant prêt:</strong> <span id="loanAmount"></span></p>
            <p class="text-base"><strong>Échéance:</strong> <span id="dueDate"></span></p>
        </div>
        <div class="mb-6">
            <h3 class="text-h4 font-semibold text-custom-black">Statut</h3>
            <p class="text-base"><strong>Statut actuel:</strong> <span id="contractStatus"></span></p>
            <p class="text-base"><strong>Date statut:</strong> <span id="statusDate"></span></p>
        </div>
        <div>
            <h3 class="text-h4 font-semibold text-custom-black">Historique des remboursements</h3>
            <table class="w-full text-base">
                <thead>
                <tr class="bg-custom-gray-purple">
                    <th class="p-2 text-left">Période</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Total dû</th>
                    <th class="p-2 text-left">Intérêts</th>
                    <th class="p-2 text-left">Capital remboursé</th>
                    <th class="p-2 text-left">Capital restant</th>
                </tr>
                </thead>
                <tbody id="repaymentTable">
                <!-- Populated via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showLoanDetails(loanId) {
        // Simulate AJAX call to fetch loan details
        fetchLoanDetails(loanId).then(data => {
            document.getElementById('contractId').textContent = data.contract.id;
            document.getElementById('contractUuid').textContent = data.contract.uuid;
            document.getElementById('repaymentType').textContent = data.contract.repaymentType;
            document.getElementById('revenueRate').textContent = data.contract.revenueRate + '%';
            document.getElementById('insuranceRate').textContent = data.contract.insuranceRate + '%';
            document.getElementById('loanDuration').textContent = data.contract.duration;
            document.getElementById('loanAmount').textContent = data.contract.amount + ' €';
            document.getElementById('dueDate').textContent = data.contract.dueDate;
            document.getElementById('contractStatus').textContent = data.status.libelle;
            document.getElementById('statusDate').textContent = data.status.date;

            const repaymentTable = document.getElementById('repaymentTable');
            repaymentTable.innerHTML = '';
            data.repayments.forEach(repayment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td class="p-2">${repayment.index_period}</td>
                        <td class="p-2">${repayment.date_retour}</td>
                        <td class="p-2">${repayment.total_due} €</td>
                        <td class="p-2">${repayment.interet} €</td>
                        <td class="p-2">${repayment.capital_rembourse} €</td>
                        <td class="p-2">${repayment.capital_restant} €</td>
                    `;
                repaymentTable.appendChild(row);
            });

            document.getElementById('loanDetails').classList.remove('hidden');
        });
    }

    function closeLoanDetails() {
        document.getElementById('loanDetails').classList.add('hidden');
    }

    // Simulated AJAX fetch
    async function fetchLoanDetails(loanId) {
        // Replace with actual AJAX call
        return {
            contract: {
                id: 'C123',
                uuid: 'abc-123-def-456',
                repaymentType: 'Mensuel',
                revenueRate: 3,
                insuranceRate: 0.5,
                duration: 60,
                amount: 100000,
                dueDate: '2030-01-01'
            },
            status: {
                libelle: 'Validé',
                date: '2025-01-01'
            },
            repayments: [
                {
                    index_period: 1,
                    date_retour: '2025-02-01',
                    total_due: 1321,
                    interet: 250,
                    capital_rembourse: 1071,
                    capital_restant: 98929
                },
                {
                    index_period: 2,
                    date_retour: '2025-03-01',
                    total_due: 1321,
                    interet: 247,
                    capital_rembourse: 1074,
                    capital_restant: 97855
                }
            ]
        };
    }
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
