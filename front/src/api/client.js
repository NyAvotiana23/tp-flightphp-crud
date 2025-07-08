import {ajax} from './ajax.js';


function filterClients(event) {
    event.preventDefault();
    const nom = document.getElementById("nom").value;
    const email = document.getElementById("email").value;
    const numero = document.getElementById("numero").value;

    const filters = {
        nom: nom ? nom.trim() : null,
        email: email ? email.trim() : null,
        numero: numero ? numero.trim() : null
    };


    ajax('GET', '/clients', filters, fillClientTable, handleError);


}

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
    document.getElementById('clientContact').textContent = client.telephone || 'Non renseigné';

    document.getElementById('modalClientNumber').value = client.numero_client;

    document.getElementById('clientModal').classList.remove('hidden');
}

function closeClientDetails() {
    document.getElementById('clientModal').classList.add('hidden');
}

function handleError(error) {
    console.error("Erreur :", error);
    alert("Une erreur est survenue : " + error);
}

function onSubmitClient(event) {
    event.preventDefault();
    const clientNumber = event.target.querySelector('#clientNumber')?.value || event.target.querySelector('#modalClientNumber')?.value;
    const password = event.target.querySelector('#password')?.value || event.target.querySelector('#modalPassword')?.value;

    ajax('POST', '/clients/login', {numero_client: clientNumber, mot_de_passe: password}, (response) => {
        if (response) {
            localStorage.setItem('client', JSON.stringify(response));
            window.location.href = 'status.php';
        } else {
            alert('Échec de la connexion : Numéro client ou mot de passe incorrect');
        }
    }, handleError);
}

function onSubmitCreateClient(event) {
    event.preventDefault();
    const clientData = {
        numero_client: document.getElementById('newClientNumber').value,
        mot_de_passe: document.getElementById('newPassword').value,
        nom: document.getElementById('newLastName').value,
        prenom: document.getElementById('newFirstName').value,
        date_naissance: document.getElementById('newDOB').value,
        email: document.getElementById('newEmail').value,
        adresse: document.getElementById('newAddress').value || null,
        telephone: document.getElementById('newTelephone').value || null
    };

    ajax('POST', '/clients', clientData, (response) => {
        alert('Client créé avec succès !');
        document.querySelector('form[onsubmit="onSubmitCreateClient(event)"]').reset();
        ajax('GET', '/clients', null, fillClientTable, handleError);
    }, handleError);
}


document.addEventListener('DOMContentLoaded', () => {
    ajax('GET', '/clients', null, fillClientTable, handleError);
    window.showClientDetails = showClientDetails;
    window.closeClientDetails = closeClientDetails;
    window.onSubmitClient = onSubmitClient;
    window.onSubmitCreateClient = onSubmitCreateClient;
});