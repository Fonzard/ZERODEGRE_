// Attendre que le DOM soit complètement chargé avant d'exécuter le code.
document.addEventListener("DOMContentLoaded", function () {
    // Définir une fonction pour initialiser le carrousel avec des sélecteurs et un intervalle de temps spécifiés.
    function initializeCarousel(slideSelector, prevButtonSelector, nextButtonSelector, intervalTime) {
        // Sélectionner tous les éléments de diapositive, boutons précédents et boutons suivants.
        const slides = document.querySelectorAll(slideSelector);
        const prevButtons = document.querySelectorAll(prevButtonSelector);
        const nextButtons = document.querySelectorAll(nextButtonSelector);

        // Variable pour suivre l'index de la diapositive actuelle.
        let currentIndex = 0;

        // Fonction pour mettre à jour la diapositive centrale.
        function updateCenterSlide() {
            // Supprimer la classe "center" de toutes les diapositives.
            slides.forEach((slide) => {
                slide.classList.remove("center");
            });

            // Ajouter la classe "center" à la diapositive actuelle.
            slides[currentIndex].classList.add("center");
        }

        // Fonction pour passer à la diapositive suivante.
        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCenterSlide();
        }

        // Fonction pour passer à la diapositive précédente.
        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateCenterSlide();
        }

        // Mettre à jour la diapositive centrale au démarrage.
        updateCenterSlide();

        // Ajouter des écouteurs de clic aux boutons précédents pour passer à la diapositive précédente.
        prevButtons.forEach((button) => {
            button.addEventListener("click", prevSlide);
        });

        // Ajouter des écouteurs de clic aux boutons suivants pour passer à la diapositive suivante.
        nextButtons.forEach((button) => {
            button.addEventListener("click", nextSlide);
        });

        // Ajouter la fonction pour faire défiler automatiquement avec l'intervalle de temps spécifié.
        setInterval(nextSlide, intervalTime);
    }

    // Appeler la fonction initializeCarousel avec différents sélecteurs et intervalles de temps pour deux carrousels différents.
    initializeCarousel(".slide-album .slide", ".slide-album .prev-button", ".slide-album .next-button", 5000); // 5000 ms pour 5 secondes
    initializeCarousel(".slide-post .slide", ".slide-post .prev-button", ".slide-post .next-button", 6000); // 6000 ms pour 6 secondes
});
