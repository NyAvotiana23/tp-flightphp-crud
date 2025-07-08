import { ajax } from './ajax.js';

ajax('GET', '/type-partenaire', null, res => {
    const sel = document.getElementById('typePartenaire');
    res.forEach(t => sel.appendChild(new Option(`${t.designation}`, t.id)));
});
function createCard(produit) {
        return `
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 class="text-h4 font-semibold text-custom-black">${produit.type_partenaire} / ${produit.nom_partenaire}</h3>
                <p class="text-custom-sm text-gray-600 mb-2">Statut: ${produit.statut_produit}</p>
                <p class="text-base text-custom-black mb-4">${produit.description_partenaire || 'Pas de description.'}</p>
                <div class="border-t pt-4">
                    <h4 class="text-h5 font-medium text-custom-black">Informations</h4>
                    ${produit.commentaire ? `<p class="text-custom-sm text-gray-600 mt-2">${produit.commentaire}</p>` : ''}
                </div>
                <button  class="mt-4 w-full bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base">
                    Voir Détails
                </button>
            </div>
        `;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("cards-container");

        ajax("GET", "/partenaire", null, (data) => {
            if (data.length === 0) {
                container.innerHTML = `<p class="text-gray-500 col-span-3">Aucun produit disponible.</p>`;
                return;
            }
            console.log(data);
            container.innerHTML = data.map(produit => createCard(produit)).join('');
        }, (err) => {
            container.innerHTML = `<p class="text-red-500 col-span-3">Erreur lors du chargement des produits.</p>`;
            console.error("Erreur:", err);
        });
    });

    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        navbar.style.transform = window.scrollY > 50 ? 'translateY(-100%)' : 'translateY(0)';
    });