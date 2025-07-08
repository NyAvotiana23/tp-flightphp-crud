<?php
?>
<?php
include("../section/head.php");
?>


<body class="bg-custom-gray-purple min-h-screen flex items-center justify-center">
<div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between max-w-7xl">
    <!-- Left Section: About the Application -->
    <div class="md:w-1/2 p-8 text-center md:text-left">
        <h1 class="text-h1 font-bold text-custom-black mb-4">Gestion de Prêt & Investissement</h1>
        <p class="text-base text-custom-black mb-6">
            Bienvenue sur notre plateforme dédiée à la gestion de prêts et d'investissements. Simplifiez vos démarches
            financières avec une solution sécurisée et intuitive, conçue pour répondre aux besoins des établissements
            financiers modernes.
        </p>
        <p class="text-custom-sm text-custom-black">
            Connectez-vous pour gérer vos comptes, suivre vos investissements et optimiser vos prêts en toute
            simplicité.
            <span class="glyphicon glyphicon-ok"></span>
        </p>
    </div>

    <!-- Right Section: Login Form -->
    <div class="md:w-1/2 p-8">
        <form class="bg-white shadow-lg rounded-lg p-8 max-w-md mx-auto" onsubmit="handleLogin(event)">
            <h2 class="text-h2 font-semibold text-custom-black mb-6">Connexion</h2>
            <div>
                <div class="mb-4">
                    <label for="numero" class="block text-base text-custom-black mb-2">Numéro d'identification</label>
                    <input
                            type="text"
                            id="numero"
                            value="Admin"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary text-base"
                            placeholder="Entrez votre numéro"
                    >
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-base text-custom-black mb-2">Mot de passe</label>
                    <input
                            type="password"
                            id="password"
                            value="Admin"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple-primary text-base"
                            placeholder="Entrez votre mot de passe"
                    >
                </div>
                <button
                        type="submit"
                        class="w-full bg-custom-purple-primary text-white font-semibold py-3 rounded-md hover:bg-custom-purple-secondary transition duration-300 text-base"
                >
                    Se connecter
                </button>
            </div>
        </form>
    </div>
</div>
</body>
<script>
    function handleLogin(event) {
        event.preventDefault();
        const numero = document.getElementById('numero').value;
        const password = document.getElementById('password').value;

        if (!numero || !password) {
            alert('Veuillez remplir tous les champs.');
            return;
        }

        // // Simulate an AJAX request to the server
        // ajax.('/api/login', {numero, password})
        //     .then(response => {
        //         if (response.success) {
        //             window.location.href = '/dashboard'; // Redirect to dashboard on success
        //         } else {
        //             alert(response.message || 'Échec de la connexion. Veuillez réessayer.');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Erreur lors de la connexion:', error);
        //         alert('Une erreur est survenue. Veuillez réessayer plus tard.');
        //     });

        alert(" Numero : " + numero + " Password : " + password);
        window.location.href = "../admin/index-page.php";

    }
</script>
<script rel="script" src="../../api/ajax.js "></script>
</html>
