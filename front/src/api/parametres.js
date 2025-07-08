import { ajax } from './ajax.js';

// Configuration for each section
export const sections = {
    'bank-movement-types': {
        endpoint: '/types-mouvements-bancaires',
        fields: [
            {id: 'nom_type_mouvement', label: 'Nom', type: 'text', required: true},
            {id: 'description', label: 'Description', type: 'textarea', required: false}
        ],
        tableColumns: ['nom_type_mouvement', 'description'],
        tableLabels: ['Nom', 'Description']
    },
    'contract-types': {
        endpoint: '/types-contrats-activite',
        fields: [
            {id: 'nom_type_contrat', label: 'Nom', type: 'text', required: true},
            {id: 'description', label: 'Description', type: 'textarea', required: false}
        ],
        tableColumns: ['nom_type_contrat', 'description'],
        tableLabels: ['Nom', 'Description']
    },
    'establishment-movement-types': {
        endpoint: '/types-mouvements-etablissements',
        fields: [
            {id: 'nom_type_mouvement', label: 'Nom', type: 'text', required: true}
        ],
        tableColumns: ['nom_type_mouvement'],
        tableLabels: ['Nom']
    },
    'repayment-types': {
        endpoint: '/types-remboursements',
        fields: [
            {id: 'nom_type_remboursement', label: 'Nom', type: 'text', required: true},
            {id: 'repetition_annuelle', label: 'Répétition Annuelle', type: 'number', required: true}
        ],
        tableColumns: ['nom_type_remboursement', 'repetition_annuelle'],
        tableLabels: ['Nom', 'Répétition Annuelle']
    },
    'loan-types': {
        endpoint: '/types-prets',
        fields: [
            {id: 'nom_type_pret', label: 'Nom', type: 'text', required: true},
            {id: 'taux_interet_min_annuel', label: 'Taux Min (%)', type: 'number', step: '0.01', required: true},
            {id: 'taux_interet_max_annuel', label: 'Taux Max (%)', type: 'number', step: '0.01', required: true},
            {id: 'motif', label: 'Motif', type: 'textarea', required: false}
        ],
        tableColumns: ['nom_type_pret', 'taux_interet_min_annuel', 'taux_interet_max_annuel', 'motif'],
        tableLabels: ['Nom', 'Taux Min (%)', 'Taux Max (%)', 'Motif']
    }
};



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
// Initialize all sections
document.addEventListener('DOMContentLoaded', () => {
    Object.keys(sections).forEach(sectionId => {
        loadSectionData(sectionId);
    });
});
// Expose functions to the global scope for inline event handlers
window.openModal = openModal;
window.deleteItem = deleteItem;
window.closeModal = closeModal;

window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.style.transform = 'translateY(-100%)';
    } else {
        navbar.style.transform = 'translateY(0)';
    }
});