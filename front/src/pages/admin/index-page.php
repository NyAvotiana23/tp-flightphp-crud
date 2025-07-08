<?php
include("../section/head.php");
?>
<body class="bg-custom-gray-purple text-custom-black font-sans">
<?php
include("../section/navbar.php");
?>

<!-- Section Héros -->
<section class="min-h-screen flex items-center bg-custom-gray-purple">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
        <!-- Gauche : Titre et Description -->
        <div class="md:w-1/2 mb-8 md:mb-0">
            <h1 class="text-h1 font-bold text-custom-black mb-4">Gérez vos prêts et investissements</h1>
            <p class="text-base text-custom-black/80 mb-6">
                Optimisez vos opérations financières avec notre tableau de bord administratif avancé. Suivez vos prêts, gérez vos investissements et générez des rapports détaillés avec facilité et efficacité.
            </p>
            <a href="tableau-bord.php" class="inline-block bg-custom-purple-primary text-white px-6 py-3 rounded-lg hover:bg-custom-purple-secondary transition-colors text-base">
                Commencer
            </a>
        </div>
        <!-- Droite : Image -->
        <div class="md:w-1/2">
            <img src="../../../static/images/index_image.jpg" alt="Tableau de bord financier" class="w-full h-auto rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- Section À propos -->
<section class="py-16 bg-white min-h-screen">
    <div class="container mx-auto px-4">
        <h2 class="text-h2 font-bold text-custom-black mb-6 text-center">À propos de notre banque</h2>
        <p class="text-base text-custom-black/80 mb-64 text-center max-w-3xl mx-auto">
            Fondée en 2025, notre institution financière est dédiée à l'autonomisation de la création de richesse et à la promotion de la stabilité financière. Nous offrons des solutions innovantes pour la gestion des prêts, des investissements et des services bancaires personnalisés, adaptées à vos besoins.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <h3 class="text-h4 font-semibold text-custom-black mb-4">Services de prêt</h3>
                <p class="text-base text-custom-black/80">
                    Accédez à des prêts flexibles avec des taux compétitifs pour répondre à vos besoins personnels ou professionnels.
                </p>
            </div>
            <div class="text-center">
                <h3 class="text-h4 font-semibold text-custom-black mb-4">Gestion d'investissements</h3>
                <p class="text-base text-custom-black/80">
                    Faites fructifier votre patrimoine grâce à nos stratégies d'investissement sur mesure et à nos conseils d'experts.
                </p>
            </div>
            <div class="text-center">
                <h3 class="text-h4 font-semibold text-custom-black mb-4">Support client 24/7</h3>
                <p class="text-base text-custom-black/80">
                    Notre équipe est disponible à tout moment pour répondre à vos questions et vous accompagner.
                </p>
            </div>
        </div>
    </div>
</section>



<!-- Pied de page -->
<footer class="py-16 bg-custom-black text-white ">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-h3 font-bold mb-4">Institution Financière</h2>
        <p class="text-custom-sm mb-6">Favoriser la création de richesse et la stabilité financière depuis 2025.</p>
        <ul class="flex justify-center space-x-6 text-custom-sm mb-6">
            <li><a href="#" class="hover:text-custom-purple-secondary">Contact</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary">Politique de confidentialité</a></li>
            <li><a href="#" class="hover:text-custom-purple-secondary">Conditions d'utilisation</a></li>
        </ul>
        <!-- Réseaux sociaux -->
        <div class="flex justify-center space-x-6 mb-6">
            <a href="#" class="hover:text-custom-purple-secondary"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#" class="hover:text-custom-purple-secondary"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#" class="hover:text-custom-purple-secondary"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
        </div>
        <!-- Copyright -->
        <p class="text-custom-sm">&copy; 2025 Institution Financière. Tous droits réservés.</p>
    </div>
</footer>

<!-- JavaScript pour l'animation de la barre de navigation -->
<script>
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