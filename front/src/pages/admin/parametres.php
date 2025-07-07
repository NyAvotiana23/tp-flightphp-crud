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
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition" onclick="openModal('bank-movement-types')">
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
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition" onclick="openModal('contract-types')">
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
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition" onclick="openModal('establishment-movement-types')">
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
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition" onclick="openModal('repayment-types')">
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
                    <button class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary transition" onclick="openModal('loan-types')">
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

<script>
    const apiBase = "http://localhost/finance/tp-flightphp-crud/ws";

    // AJAX function (provided by user)
    function ajax(method, url, data, callback, errorCallback) {
        const xhr = new XMLHttpRequest();
        const fullUrl = apiBase + url;

        xhr.open(method, fullUrl, true);

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
                        if (errorCallback) errorCallback("Invalid JSON response from server");
                    }
                } else {
                    console.error(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                    if (errorCallback) errorCallback(`Request failed with status ${xhr.status}: ${xhr.statusText}`);
                }
            }
        };

        xhr.onerror = () => {
            console.error("Network error occurred");
            if (errorCallback) errorCallback("Network error occurred");
        };

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

    // Configuration for each section
    const sections = {
        'bank-movement-types': {
            endpoint: '/types-mouvements-bancaires',
            fields: [
                { id: 'nom_type_mouvement', label: 'Nom', type: 'text', required: true },
                { id: 'description', label: 'Description', type: 'textarea', required: false }
            ],
            tableColumns: ['nom_type_mouvement', 'description'],
            tableLabels: ['Nom', 'Description']
        },
        'contract-types': {
            endpoint: '/types-contrats-activite',
            fields: [
                { id: 'nom_type_contrat', label: 'Nom', type: 'text', required: true },
                { id: 'description', label: 'Description', type: 'textarea', required: false }
            ],
            tableColumns: ['nom_type_contrat', 'description'],
            tableLabels: ['Nom', 'Description']
        },
        'establishment-movement-types': {
            endpoint: '/types-mouvements-etablissements',
            fields: [
                { id: 'nom_type_mouvement', label: 'Nom', type: 'text', required: true }
            ],
            tableColumns: ['nom_type_mouvement'],
            tableLabels: ['Nom']
        },
        'repayment-types': {
            endpoint: '/types-remboursements',
            fields: [
                { id: 'nom_type_remboursement', label: 'Nom', type: 'text', required: true },
                { id: 'repetition_annuelle', label: 'Répétition Annuelle', type: 'number', required: true }
            ],
            tableColumns: ['nom_type_remboursement', 'repetition_annuelle'],
            tableLabels: ['Nom', 'Répétition Annuelle']
        },
        'loan-types': {
            endpoint: '/types-prets',
            fields: [
                { id: 'nom_type_pret', label: 'Nom', type: 'text', required: true },
                { id: 'taux_interet_min_annuel', label: 'Taux Min (%)', type: 'number', step: '0.01', required: true },
                { id: 'taux_interet_max_annuel', label: 'Taux Max (%)', type: 'number', step: '0.01', required: true },
                { id: 'motif', label: 'Motif', type: 'textarea', required: false }
            ],
            tableColumns: ['nom_type_pret', 'taux_interet_min_annuel', 'taux_interet_max_annuel', 'motif'],
            tableLabels: ['Nom', 'Taux Min (%)', 'Taux Max (%)', 'Motif']
        }
    };

    // Initialize all sections
    document.addEventListener('DOMContentLoaded', () => {
        Object.keys(sections).forEach(sectionId => {
            loadSectionData(sectionId);
        });
    });

    // Load data for a specific section
    function loadSectionData(sectionId) {
        const config = sections[sectionId];
        ajax('GET', config.endpoint, null, (response) => {
            const tbody = document.querySelector(`#${sectionId} tbody`);
            tbody.innerHTML = '';
            response.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-t';
                let cells = '';
                config.tableColumns.forEach(col => {
                    cells += `<td class="py-2 text-base">${item[col] || ''}</td>`;
                });
                // Sanitize item for JSON
                const sanitizedItem = {};
                config.tableColumns.forEach(col => {
                    sanitizedItem[col] = item[col] || '';
                });
                cells += `
                <td class="py-2">
                    <button class="text-custom-purple-primary hover:underline mr-2" onclick='openModal("${sectionId}", ${item.id}, JSON.parse("${escapeJSON(sanitizedItem)}"))'>Modifier</button>
                    <button class="text-red-600 hover:underline" onclick="deleteItem('${sectionId}', ${item.id})">Supprimer</button>
                </td>
            `;
                row.innerHTML = cells;
                tbody.appendChild(row);
            });
        }, (error) => {
            alert(`Erreur lors du chargement des données pour ${sectionId}: ${error}`);
        });
    }

    function escapeJSON(json) {
        return JSON.stringify(json).replace(/"/g, '\\"');
    }

    // Open modal for adding/editing
    function openModal(sectionId, id = null, item = {}) {
        const config = sections[sectionId];
        const modal = document.createElement('div');
        modal.id = 'modal';
        modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center';
        let formFields = '';
        config.fields.forEach(field => {
            const value = item[field.id] || '';
            if (field.type === 'textarea') {
                formFields += `
                <div class="mb-4">
                    <label class="block text-custom-black mb-2" for="${field.id}">${field.label}</label>
                    <textarea id="${field.id}" class="w-full p-2 border rounded" ${field.required ? 'required' : ''}>${value}</textarea>
                </div>
            `;
            } else {
                formFields += `
                <div class="mb-4">
                    <label class="block text-custom-black mb-2" for="${field.id}">${field.label}</label>
                    <input type="${field.type}" id="${field.id}" value="${value}" class="w-full p-2 border rounded" ${field.step ? `step="${field.step}"` : ''} ${field.required ? 'required' : ''}>
                </div>
            `;
            }
        });
        modal.innerHTML = `
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-h2 font-semibold text-custom-purple-primary mb-4">${id ? 'Modifier' : 'Ajouter'} ${config.tableLabels[0]}</h2>
            <form id="item-form">
                ${formFields}
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-custom-black px-4 py-2 rounded hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="bg-custom-purple-primary text-white px-4 py-2 rounded hover:bg-custom-purple-secondary">${id ? 'Modifier' : 'Ajouter'}</button>
                </div>
            </form>
        </div>
    `;
        document.body.appendChild(modal);

        const form = document.getElementById('item-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const data = {};
            config.fields.forEach(field => {
                const value = document.getElementById(field.id).value;
                data[field.id] = field.type === 'number' ? parseFloat(value) : value;
            });
            if (id) {
                updateItem(sectionId, id, data);
            } else {
                addItem(sectionId, data);
            }
        });
    }

    // Close modal
    function closeModal() {
        const modal = document.getElementById('modal');
        if (modal) modal.remove();
    }

    // Add a new item
    function addItem(sectionId, data) {
        const config = sections[sectionId];
        ajax('POST', config.endpoint, data, () => {
            closeModal();
            loadSectionData(sectionId);
            alert(`Ajout réussi pour ${sectionId}.`);
        }, (error) => {
            alert(`Erreur lors de l'ajout pour ${sectionId}: ${error}`);
        });
    }

    // Update an existing item
    function updateItem(sectionId, id, data) {
        console.log("Mdal update " + sectionId + " ID: " + id + " Data: ", data);
        const config = sections[sectionId];
        ajax('PUT', `${config.endpoint}/${id}`, data, () => {
            closeModal();
            loadSectionData(sectionId);
            alert(`Modification réussie pour ${sectionId}.`);
        }, (error) => {
            alert(`Erreur lors de la modification pour ${sectionId}: ${error}`);
        });
    }

    // Delete an item
    function deleteItem(sectionId, id) {
        if (confirm(`Voulez-vous vraiment supprimer cet élément de ${sectionId} ?`)) {
            const config = sections[sectionId];
            ajax('DELETE', `${config.endpoint}/${id}`, null, () => {
                loadSectionData(sectionId);
                alert(`Suppression réussie pour ${sectionId}.`);
            }, (error) => {
                alert(`Erreur lors de la suppression pour ${sectionId}: ${error}`);
            });
        }
    }
</script>
</body>
</html>