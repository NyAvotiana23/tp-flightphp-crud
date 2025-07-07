import { ajax } from './ajax.js';

function fillClientTable(data) {
    const tbody = document.getElementById('clientList');
    if (!Array.isArray(data)) {
        console.error("Données de clients invalides :", data);
        return;
    }

    tbody.innerHTML = '';

    data.forEach(client => {
        const tr = document.createElement('tr');
        tr.className = "border-b border-custom-purple-secondary hover:bg-custom-gray-purple cursor-pointer";

        tr.onclick = () => showClientDetails(client);

        tr.innerHTML = `
            <td class="p-3">${client.numero_client}</td>
            <td class="p-3">${client.nom}</td>
            <td class="p-3">${client.prenom}</td>
            <td class="p-3">${client.email}</td>
            <td class="p-3">
                <button class="text-custom-purple-primary hover:underline">Voir détails</button>
            </td>
        `;

        tbody.appendChild(tr);
    });
}

function showClientDetails(client) {
    document.getElementById('clientId').textContent = client.id;
    document.getElementById('clientNumberDetail').textContent = client.numero_client;
    document.getElementById('clientLastName').textContent = client.nom;
    document.getElementById('clientFirstName').textContent = client.prenom;
    document.getElementById('clientDOB').textContent = client.date_naissance || 'Non renseignée';
    document.getElementById('clientEmail').textContent = client.email;
    document.getElementById('clientAddress').textContent = client.adresse || 'Non renseignée';
    document.getElementById('clientContact').textContent = client.contact || 'Non renseigné';

    // Pré-remplir le champ du numéro dans le formulaire
    document.getElementById('modalClientNumber').value = client.numero_client;

    document.getElementById('clientModal').classList.remove('hidden');
}

function closeClientDetails() {
    document.getElementById('clientModal').classList.add('hidden');
}

function handleError(error) {
    console.error("Erreur lors du chargement des clients :", error);
}

document.addEventListener('DOMContentLoaded', () => {
    ajax('GET', '/clients', null, fillClientTable, handleError);
    window.showClientDetails = showClientDetails;
    window.closeClientDetails = closeClientDetails;
});
