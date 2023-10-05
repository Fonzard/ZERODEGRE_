document.addEventListener("DOMContentLoaded", function () {
    function initializeCarousel(slideSelector, prevButtonSelector, nextButtonSelector, intervalTime) {
        const slides = document.querySelectorAll(slideSelector);
        const prevButtons = document.querySelectorAll(prevButtonSelector);
        const nextButtons = document.querySelectorAll(nextButtonSelector);
        let currentIndex = 0;

        function updateCenterSlide() {
            slides.forEach((slide) => {
                slide.classList.remove("center");
            });

            slides[currentIndex].classList.add("center");
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCenterSlide();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateCenterSlide();
        }

        updateCenterSlide();

        prevButtons.forEach((button) => {
            button.addEventListener("click", prevSlide);
        });

        nextButtons.forEach((button) => {
            button.addEventListener("click", nextSlide);
        });

        // Ajout de la fonction pour faire défiler automatiquement avec le temps spécifié
        setInterval(nextSlide, intervalTime);
    }

    // Utilisez la fonction initializeCarousel avec l'intervalle de temps souhaité (par exemple, 5000 ms pour 5 secondes)
    initializeCarousel(".slide-album .slide", ".slide-album .prev-button", ".slide-album .next-button", 5000);
    initializeCarousel(".slide-post .slide", ".slide-post .prev-button", ".slide-post .next-button", 6000);
});
