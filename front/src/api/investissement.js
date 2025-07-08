import { ajax } from './ajax.js';

function fillTypePartenaireSelect(data) {
    const select = document.getElementById('type-partenaire');

    if (!Array.isArray(data)) return;

    select.innerHTML = '<option value="">Tous les types</option>';
    select.style.color = '#000';

    data.forEach(type => {
        const option = document.createElement('option');
        option.value = type.id;
        option.textContent = type.description;
        option.style.color = '#000';
        select.appendChild(option);
    });
}

function fillPartenaireSelect(data) {
    const select = document.getElementById('partenaire');

    if (!Array.isArray(data)) return;

    select.innerHTML = '<option value="">Tous les partenaires</option>';
    select.style.color = '#000';

    data.forEach(partenaire => {
        const option = document.createElement('option');
        option.value = partenaire.id;
        option.textContent = partenaire.nom;
        option.style.color = '#000';
        select.appendChild(option);
    });
}

function fillInvestissementsTable(data) {
    const tbody = document.querySelector('table tbody');
    if (!Array.isArray(data)) {
        console.error("Données d'investissements invalides :", data);
        return;
    }

    tbody.innerHTML = ''; // Vider le tableau avant d'ajouter

    data.forEach(invest => {
        const tr = document.createElement('tr');
        tr.className = "border-b border-custom-purple-secondary hover:bg-custom-gray-purple";

        tr.innerHTML = `
            <td class="p-3">${invest.nom_partenaire}</td>
            <td class="p-3">${invest.type}</td>
            <td class="p-3">${invest.nom}</td>
            <td class="p-3">${invest.montant_investi} €</td>
            <td class="p-3">${invest.date_investissement}</td>
            <td class="p-3">${invest.taux_rendement_applique} %</td>
            <td class="p-3">${invest.retrait || '-'}</td>
        `;

        tbody.appendChild(tr);
    });
}

function fillPartenaireDetailsSection(data) {
    const section = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.gap-6');

    if (!Array.isArray(data)) return;

    section.innerHTML = ''; // Vide les anciennes cartes

    data.forEach(partenaire => {
        const div = document.createElement('div');
        div.className = 'bg-white rounded-lg shadow-lg p-6';

        div.innerHTML = `
            <h3 class="text-h4 font-semibold text-custom-black">${partenaire.nom}</h3>
            <p class="text-base text-custom-black mt-2"><strong>Type:</strong> ${partenaire.type}</p>
            <p class="text-base text-custom-black mt-2"><strong>Description:</strong> ${partenaire.description}</p>
            <p class="text-base text-custom-black mt-2"><strong>Commentaire:</strong> ${partenaire.commentaire || '-'}</p>
            <p class="text-base text-custom-black mt-2"><strong>Dépôt Min/Max:</strong> ${partenaire.depot_min} € / ${partenaire.depot_max} €</p>
            <p class="text-base text-custom-black mt-2"><strong>Durée Min/Max:</strong> ${partenaire.duree_min} mois / ${partenaire.duree_max} mois</p>
            <p class="text-base text-custom-black mt-2"><strong>Taux Annuel:</strong> ${partenaire.taux_annuel} %</p>
        `;

        section.appendChild(div);
    });
}

function handleError(error) {
    console.error("Erreur lors d’un chargement :", error);
}

document.addEventListener('DOMContentLoaded', () => {
    ajax('GET', '/type-partenaire', null, fillTypePartenaireSelect, handleError);
    ajax('GET', '/partenaire', null, fillPartenaireSelect, handleError);
    ajax('GET', '/partenaire', null, fillPartenaireDetailsSection, handleError);
    ajax('GET', '/fonds-investis-clients', null, fillInvestissementsTable, handleError);
});
