import { ajax } from './ajax.js';

ajax('GET', '/type-partenaire', null, res => {
    const sel = document.getElementById('typePartenaire');
    res.forEach(t => sel.appendChild(new Option(`${t.designation}`, t.id)));
});

function createCard(produit) {
    const client = localStorage.getItem('client') ? JSON.parse(localStorage.getItem('client')) : null;
    const investirButton = client ? `
        <button class="investir-btn mt-2 w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-base" data-partenaire-id="${produit.id}">
            Investir
        </button>
    ` : '';

    return `
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-h4 font-semibold text-custom-black">${produit.type_partenaire} / ${produit.nom_partenaire}</h3>
            <p class="text-custom-sm text-gray-600 mb-2">Statut: ${produit.statut_produit || 'Actif'}</p>
            <p class="text-base text-custom-black mb-4">${produit.description_partenaire || 'Pas de description.'}</p>
            <div class="border-t pt-4">
                <h4 class="text-h5 font-medium text-custom-black">Informations</h4>
                ${produit.commentaire ? `<p class="text-custom-sm text-gray-600 mt-2">${produit.commentaire}</p>` : ''}
            </div>
            <div class="flex flex-col gap-2">
                <a href="investissement-client.php" class="w-full bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base">
                    Voir Détails
                </a>
                ${investirButton}
            </div>
        </div>
    `;
}

document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("cards-container");
    const modal = document.getElementById("investment-modal");
    const form = document.getElementById("investment-form");
    const cancelBtn = document.getElementById("cancel-investment");

    ajax("GET", "/partenaire", null, (data) => {
        if (data.length === 0) {
            container.innerHTML = `<p class="text-gray-500 col-span-3">Aucun produit disponible.</p>`;
            return;
        }
        container.innerHTML = data.map(produit => createCard(produit)).join('');

        // Add event listeners for Investir buttons
        document.querySelectorAll('.investir-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const partenaireId = btn.getAttribute('data-partenaire-id');
                document.getElementById('id_partenaire').value = partenaireId;
                modal.classList.remove('hidden');
            });
        });
    }, (err) => {
        container.innerHTML = `<p class="text-red-500 col-span-3">Erreur lors du chargement des produits.</p>`;
        console.error("Erreur:", err);
    });

    // Close modal on cancel
    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.reset();
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const client = JSON.parse(localStorage.getItem('client'));
        if (!client) {
            alert("Vous devez être connecté en tant que client pour investir.");
            return;
        }

        const data = {
            id_partenaire: document.getElementById('id_partenaire').value,
            id_client: client.id,
            montant_investi: parseFloat(document.getElementById('montant_investi').value),
            date_investissement: document.getElementById('date_investissement').value
        };

        ajax('POST', '/fonds-investis-clients', data, (res) => {
            alert('Investissement effectué avec succès !');
            modal.classList.add('hidden');
            form.reset();
        }, (err) => {
            alert('Erreur lors de l\'investissement : ' + err);
        });
    });

    // Apply filters
    document.getElementById('apply-filters').addEventListener('click', () => {
        const type = document.getElementById('typePartenaire').value;
        const name = document.getElementById('name-filter').value;
        const taux = document.getElementById('taux-filter').value;

        const conditions = [];
        if (type) conditions.push({ column: 'id_type_partenaire', operator: '=', value: type });
        if (name) conditions.push({ column: 'nom_partenaire', operator: 'LIKE', value: `%${name}%` });
        // Note: taux filtering requires joining with EF_mouvements_partenaire
        if (taux) conditions.push({ column: 'taux_rendement_annuel', operator: '>=', value: taux });

        ajax('POST', '/partenaire/filter', { conditions }, (data) => {
            container.innerHTML = data.map(produit => createCard(produit)).join('');
            // Re-attach event listeners for Investir buttons
            document.querySelectorAll('.investir-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const partenaireId = btn.getAttribute('data-partenaire-id');
                    document.getElementById('id_partenaire').value = partenaireId;
                    modal.classList.remove('hidden');
                });
            });
        }, (err) => {
            container.innerHTML = `<p class="text-red-500 col-span-3">Erreur lors du filtrage des produits.</p>`;
            console.error("Erreur:", err);
        });
    });
});

window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    navbar.style.transform = window.scrollY > 50 ? 'translateY(-100%)' : 'translateY(0)';
});