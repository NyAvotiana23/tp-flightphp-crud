<?php
include("../section/head.php");
?>

<body class="bg-custom-gray-purple min-h-screen p-6 font-sans">
<?php
include("../section/navbar.php");
?>
<div class="max-w-7xl mx-auto mt-16">
    <!-- Dashboard Header -->
    <header class="mb-8">
        <h1 class="text-h1 font-bold text-custom-black">Tableau de Bord - Gestion de Prêt et Investissement</h1>
        <p class="text-base text-custom-black mt-2">Filtrez et consultez les produits d'investissement des sociétés et
            entreprises.</p>
    </header>

    <!-- Filter Section -->
    <section class="mb-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-h3 font-semibold text-custom-black mb-4">Filtres</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="type-filter" class="block text-base font-medium text-custom-black">Type</label>
                <select id="type-filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base">
                    <option value="">Tous</option>
                    <option value="societe">Société</option>
                    <option value="entreprise">Entreprise</option>
                </select>
            </div>
            <div>
                <label for="name-filter" class="block text-base font-medium text-custom-black">Nom du Produit</label>
                <input type="text" id="name-filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base"
                       placeholder="Rechercher par nom...">
            </div>
            <div>
                <label for="taux-filter" class="block text-base font-medium text-custom-black">Taux Annuel (%)</label>
                <input type="number" id="taux-filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-purple-primary focus:ring focus:ring-custom-purple-secondary focus:ring-opacity-50 text-base"
                       placeholder="Taux minimum...">
            </div>
        </div>
        <button class="mt-4 bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base transition duration-300">
            Appliquer les Filtres
        </button>
    </section>

    <!-- Cards Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card Example -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-h4 font-semibold text-custom-black">Produit A</h3>
            <p class="text-custom-sm text-gray-600 mb-2">Type: Société</p>
            <p class="text-base text-custom-black mb-4">Description: Un produit d'investissement axé sur le
                développement durable avec un retour stable.</p>
            <div class="border-t pt-4">
                <h4 class="text-h5 font-medium text-custom-black">Dernier Mouvement</h4>
                <p class="text-custom-sm text-gray-600">Date: 01/07/2025</p>
                <p class="text-custom-sm text-gray-600">Durée: Min 6 mois / Max 24 mois</p>
                <p class="text-custom-sm text-gray-600">Dépôt: Min 5,000€ / Max 50,000€</p>
                <p class="text-custom-sm text-gray-600">Taux Annuel: 3.5%</p>
                <p class="text-custom-sm text-gray-600 mt-2">Commentaire: Retour stable, idéal pour investisseurs
                    prudents.</p>
            </div>
            <button class="mt-4 w-full bg-custom-purple-primary hover:bg-custom-purple-secondary text-white font-medium py-2 px-4 rounded-md text-base transition duration-300">
                Voir Détails
            </button>
        </div>
        <!-- Additional cards can be dynamically added here -->
    </section>
</div>
<script>
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
    });
const apiBase = "http://localhost/tp-flightphp-crud/ws";

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
document.addEventListener("DOMContentLoaded", () => {
  // Appelle l'API dès que la page est prête
  ajax("GET", "/produits-investissements", null, (data) => {
    console.log("Produits d'investissement reçus:", data);
    // Tu pourras ici ensuite construire dynamiquement les cards si tu veux
  }, (err) => {
    console.error("Erreur lors de la récupération des produits:", err);
  });
});
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