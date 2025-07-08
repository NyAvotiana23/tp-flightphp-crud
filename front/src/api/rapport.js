import { ajax } from './ajax.js';

function fillEtablissementInfo(data) {
    const container = document.querySelector("section:nth-of-type(2) .grid");
    container.innerHTML = `
        <div>
            <p class="text-base font-medium">Nom de l'établissement</p>
            <p class="text-custom-lg text-custom-black">${data.nom_etablissement}</p>
        </div>
        <div>
            <p class="text-base font-medium">Lieu</p>
            <p class="text-custom-lg text-custom-black">${data.adresse_etablissement}</p>
        </div>
        <div>
            <p class="text-base font-medium">Numéro d'identification</p>
            <p class="text-custom-lg text-custom-black">${data.numero_identification}</p>
        </div>
        <div>
            <p class="text-base font-medium">Date de création</p>
            <p class="text-custom-lg text-custom-black">${data.date_creation}</p>
        </div>
        <div class="col-span-2">
            <p class="text-base font-medium">Commentaire</p>
            <p class="text-base text-custom-black">${data.commentaire || 'Aucun'}</p>
        </div>
    `;
}

function loadMouvements() {
    const dateDebut = document.getElementById('date-debut').value;
    const dateFin = document.getElementById('date-fin').value;
    const typeId = document.getElementById('type-filter').value;

    const params = new URLSearchParams();

    if (dateDebut) params.append('date_debut', dateDebut);
    if (dateFin) params.append('date_fin', dateFin);
    if (typeId) params.append('type_mouvement_id', typeId);

    const url = `/mouvements-bancaires-etablissements/firstEtablissement?${params.toString()}`;

    ajax('GET', url, null, fillTransactionsTable, handleError);
}

function fillTransactionsTable(data) {
    const tbody = document.querySelector("section:nth-of-type(3) tbody");
    tbody.innerHTML = '';
    let total = 0;

    data.forEach(tx => {
        const tr = document.createElement('tr');
        tr.className = "border-b border-custom-purple-secondary";

        tr.innerHTML = `
            <td class="p-3 text-base">${tx.date_mouvement}</td>
            <td class="p-3 text-base">${tx.nom_type_mouvement}</td>
            <td class="p-3 text-base">${parseFloat(tx.montant).toFixed(2)} €</td>
        `;

        tbody.appendChild(tr);
        total += parseFloat(tx.montant);
    });

    document.querySelector("section:nth-of-type(4) .text-h1").textContent = `${total.toFixed(2)} €`;
    const today = new Date().toLocaleDateString();
    document.querySelector("section:nth-of-type(4) .text-custom-sm").textContent = `À la date du ${today}`;
}

function fillTypeMouvementFilter(data) {
    const select = document.getElementById('type-filter');
    select.innerHTML = `<option value="">Tous</option>`;
    data.forEach(type => {
        const option = document.createElement('option');
        option.value = type.id;
        option.textContent = type.nom_type_mouvement;
        select.appendChild(option);
    });
}

function handleError(error) {
    console.error("Erreur lors du chargement des données du rapport :", error);
}

document.addEventListener('DOMContentLoaded', () => {
    ajax('GET', '/etablissement-financier/first', null, fillEtablissementInfo, handleError);
    ajax('GET', '/types-mouvements-etablissements', null, fillTypeMouvementFilter, handleError);

    document.getElementById('applyFiltersBtn').addEventListener('click', (e) => {
        e.preventDefault();
        loadMouvements();
    });

    loadMouvements();
});
