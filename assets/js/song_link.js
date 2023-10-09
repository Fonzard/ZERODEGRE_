document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez tous les boutons de lecture et tous les éléments audio sur la page
    const playButtons = document.querySelectorAll(".play-button");
    const audioElements = document.querySelectorAll(".audio-element");

    // Variable pour suivre l'élément audio actuellement en cours de lecture
    let currentAudio = null;

    // Parcourir chaque bouton de lecture
    playButtons.forEach((playButton, index) => {
        // Ajouter un écouteur de clic à chaque bouton de lecture
        playButton.addEventListener("click", function () {
            // Sélectionner l'élément audio correspondant
            const audioElement = audioElements[index];

            // Réinitialiser l'apparence de tous les boutons de lecture à "lecture" (icône "play")
            playButtons.forEach((button) => {
                button.innerHTML = '<i class="fa-solid fa-play"></i>';
            });

            // Si un élément audio est en cours de lecture et ce n'est pas l'élément actuel, l'arrêter
            if (currentAudio && currentAudio !== audioElement) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
            }

            // Si l'élément audio est en pause, le lire et mettre à jour le bouton de lecture
            if (audioElement.paused) {
                audioElement.play();
                playButton.innerHTML = '<i class="fa-solid fa-pause"></i>';
                currentAudio = audioElement;
            } else {
                // Si l'élément audio est en lecture, le mettre en pause et mettre à jour le bouton de lecture
                audioElement.pause();
                playButton.innerHTML = '<i class="fa-solid fa-play"></i>';
                currentAudio = null;
            }
        });
    });
});
