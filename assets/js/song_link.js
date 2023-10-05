// Nécessaire pour faire le lien entre l'audio et play / pause
document.addEventListener("DOMContentLoaded", function () {
    const playButtons = document.querySelectorAll(".play-button");
    const audioElements = document.querySelectorAll(".audio-element");

    let currentAudio = null;

    playButtons.forEach((playButton, index) => {
        playButton.addEventListener("click", function () {
            const audioElement = audioElements[index];

            if (currentAudio && currentAudio !== audioElement) {
                // Arrêtez le lecteur audio précédent s'il existe
                currentAudio.pause();
                currentAudio.currentTime = 0;
            }

            if (audioElement.paused) {
                audioElement.play();
                playButton.innerHTML = '<i class="fa-solid fa-pause"></i>';
                currentAudio = audioElement;
            } else {
                audioElement.pause();
                playButton.innerHTML = '<i class="fa-solid fa-play"></i>';
                currentAudio = null;
            }
        });
    });
});
