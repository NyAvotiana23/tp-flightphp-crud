<?php
include("../section/head.php");
?>
<body class="bg-gray-100 font-sans">
<?php
include("../section/navbar.php");
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <!-- Header -->
    <h1 class="text-h1 font-bold text-custom-black mb-6">Gestion des Prêts</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-base text-custom-black mb-2">Date de début</label>
                <input type="date" id="date_debut_pret" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de prêt</label>
                <select id="id_type_pret" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Type de remboursement</label>
                <select id="id_type_remboursement" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
            <div>
                <label class="block text-base text-custom-black mb-2">Statut</label>
                <select id="id_status_contrat" class="w-full border rounded-lg p-2 text-base focus:outline-none focus:ring-2 focus:ring-custom-purple-primary">
                    <option value="">Tous</option>
                    <!-- Populated dynamically -->
                </select>
            </div>
        </div>
        <div class="flex flex-row gap-8 mt-8">
            <button onclick="filterLoans()" class="mt-4 bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Appliquer les filtres</button>
            =>> SI LOCAL STORAGE ID_CLIENT NOT NULL <a href="pret-form.php" class="mt-4 bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Faire un pret</a>
        </div>
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
            <tbody id="loanTable">
            <!-- Populated dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Floating Loan Details -->
    <div id="loanDetails" class="hidden fixed top-0 right-0 h-full w-1/3 bg-white shadow-xl p-6 overflow-y-auto">
        <button onclick="closeLoanDetails()" class="text-custom-black text-h5 font-semibold mb-4">Fermer</button>
        <h2 class="text-h2 font-semibold text-custom-black mb-4">Détails du Prêt #<span id="loanId"></span></h2>
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
            <p class="text-base"><strong>Client:</strong> <span id="clientName"></span></p>
            <p class="text-base"><strong>Type de prêt:</strong> <span id="loanType"></span></p>
        </div>
        <div class="mb-6">
            <h3 class="text-h4 font-semibold text-custom-black">Statut</h3>
            <p class="text-base"><strong>Statut actuel:</strong> <span id="contractStatus"></span></p>
            <p class="text-base"><strong>Date statut:</strong> <span id="statusDate"></span></p>
        </div>
        <div class="mb-6">
            <a id="downloadPdfLink" href="#" class="bg-custom-purple-primary text-white px-4 py-2 rounded-lg hover:bg-custom-purple-secondary transition text-base">Télécharger PDF</a>
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

<?php
include("../section/footer.php");
?>

<script type="module">
    const apiBase = "http://localhost/Tp%20Final%20S4/tp-flightphp-crud/ws";

    function ajax(method, url, data, callback, errorCallback) {
        const xhr = new XMLHttpRequest();
        const fullUrl = apiBase + url;

        xhr.open(method, fullUrl, true);

        // Set Content-Type for POST and PUT requests
        if (method === 'POST' || method === 'PUT') {
            xhr.setRequestHeader("Content-Type", "application/json");
        } else {
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        }

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        callback(response);
                    } catch (e) {
                        console.error("Error parsing response:", e);
                        if (errorCallback) {
                            errorCallback("Invalid JSON response from server");
                        }
                    }
                } else {
                    console.error(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                    if (errorCallback) {
                        errorCallback(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                    }
                }
            }
        };

        xhr.onerror = () => {
            console.error("Network error occurred");
            if (errorCallback) {
                errorCallback("Network error occurred");
            }
        };

        // Prepare data based on method
        let requestData = null;
        if (data) {
            if (method === 'POST' || method === 'PUT') {
                requestData = JSON.stringify(data);
            } else if (method === 'GET' || method === 'DELETE') {
                const params = new URLSearchParams(data).toString();
                xhr.open(method, fullUrl + (params ? `?${params}` : ''), true);
            }
        }

        xhr.send(requestData);
    }

    // Fetch loan types, repayment types, and statuses on page load
    function loadFilterOptions() {
        // Fetch loan types
        ajax('GET', '/types-prets', null, (loanTypes) => {
            const loanTypeSelect = document.getElementById('id_type_pret');
            loanTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.nom_type_pret;
                loanTypeSelect.appendChild(option);
            });
        }, (error) => {
            console.error('Erreur lors du chargement des types de prêt:', error);
        });

        // Fetch repayment types
        ajax('GET', '/types-remboursements', null, (repaymentTypes) => {
            const repaymentTypeSelect = document.getElementById('id_type_remboursement');
            repaymentTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.nom_type_remboursement;
                repaymentTypeSelect.appendChild(option);
            });
        }, (error) => {
            console.error('Erreur lors du chargement des types de remboursement:', error);
        });

        // Fetch status types
        ajax('GET', '/status-contrats', null, (statuses) => {
            const statusSelect = document.getElementById('id_status_contrat');
            statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status.id;
                option.textContent = status.libelle;
                statusSelect.appendChild(option);
            });
        }, (error) => {
            console.error('Erreur lors du chargement des statuts:', error);
        });
    }

    // Filter loans based on form input
    function filterLoans() {
        const filters = {
            date_debut_pret: document.getElementById('date_debut_pret').value,
            id_type_pret: document.getElementById('id_type_pret').value,
            id_type_remboursement: document.getElementById('id_type_remboursement').value,
            id_status_contrat: document.getElementById('id_status_contrat').value
        };

        ajax('POST', '/pret-clients/filter', filters, (loans) => {
            const loanTable = document.getElementById('loanTable');
            loanTable.innerHTML = '';
            loans.forEach(loan => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-custom-gray-purple cursor-pointer';
                row.onclick = () => showLoanDetails(loan.id);
                row.innerHTML = `
                    <td class="p-4">${loan.id}</td>
                    <td class="p-4">${loan.client_prenom} ${loan.client_nom}</td>
                    <td class="p-4">${loan.montant_pret} €</td>
                    <td class="p-4">${loan.nom_type_pret}</td>
                    <td class="p-4">${loan.date_debut_pret}</td>
                    <td class="p-4">${loan.status_libelle || 'N/A'}</td>
                `;
                loanTable.appendChild(row);
            });
        }, (error) => {
            console.error('Erreur lors du filtrage des prêts:', error);
        });
    }

    // Fetch and display loan details
    function showLoanDetails(loanId) {
        ajax('GET', `/pret-clients/${loanId}/details`, null, (data) => {
            document.getElementById('loanId').textContent = loanId;
            document.getElementById('contractId').textContent = data.contract.id;
            document.getElementById('contractUuid').textContent = data.contract.uuid;
            document.getElementById('repaymentType').textContent = data.contract.repaymentType;
            document.getElementById('revenueRate').textContent = data.contract.revenueRate + '%';
            document.getElementById('insuranceRate').textContent = data.contract.insuranceRate + '%';
            document.getElementById('loanDuration').textContent = data.contract.duration;
            document.getElementById('loanAmount').textContent = data.contract.amount + ' €';
            document.getElementById('dueDate').textContent = data.contract.dueDate;
            document.getElementById('clientName').textContent = data.contract.client;
            document.getElementById('loanType').textContent = data.contract.loanType;
            document.getElementById('contractStatus').textContent = data.status ? data.status.libelle : 'N/A';
            document.getElementById('statusDate').textContent = data.status ? data.status.date : 'N/A';
            document.getElementById('downloadPdfLink').href = `${apiBase}/prets-clients/${loanId}/pdf`;

            const repaymentTable = document.getElementById('repaymentTable');
            repaymentTable.innerHTML = '';
            data.repayments.forEach(repayment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="p-2">${repayment.index_period}</td>
                    <td class="p-2">${repayment.date_retour || 'N/A'}</td>
                    <td class="p-2">${repayment.total_due} €</td>
                    <td class="p-2">${repayment.interet} €</td>
                    <td class="p-2">${repayment.capital_rembourse} €</td>
                    <td class="p-2">${repayment.capital_restant} €</td>
                `;
                repaymentTable.appendChild(row);
            });

            document.getElementById('loanDetails').classList.remove('hidden');
        }, (error) => {
            console.error('Erreur lors du chargement des détails du prêt:', error);
        });
    }

    function closeLoanDetails() {
        document.getElementById('loanDetails').classList.add('hidden');
    }

    // Load filter options and initial loan list on page load
    window.onload = () => {
        loadFilterOptions();
        filterLoans();
    };

    // Navbar scroll effect
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
</html>
?>