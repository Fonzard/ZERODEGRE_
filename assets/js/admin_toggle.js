/////////////////// DROPDOWN NAV \\\\\\\\\\\\\\\\\\\\\\\
// Fonction toggleMenu générique
function toggleMenu(menuButton, menu) {
    menu.classList.toggle("show-menu");
    menuButton.classList.toggle('close');
}

// PUBLIC \\
const headerPublicMenuButton = document.querySelector("#header-public-menu-button");
const headerPublicMenu = document.querySelector("#header-public-menu");
if (headerPublicMenuButton) {
    headerPublicMenuButton.addEventListener("click", () => {
        toggleMenu(headerPublicMenuButton, headerPublicMenu);
    });
}



// ADMIN \\
const headerAdminMenuButton = document.querySelector("#header-admin-menu-button");
const headerAdminMenu = document.querySelector("#header-admin-menu");
if (headerAdminMenuButton) {
    headerAdminMenuButton.addEventListener("click", () => {
        toggleMenu(headerAdminMenuButton, headerAdminMenu);
    });
}

// TOGGLE ARTIST \\
function toggleArtistDetails(artistInfo) {
    // Sélectionnez toutes les sections d'artiste-info
    const artistInfos = document.querySelectorAll('.artist-info');
    
    // Parcourez chaque section d'artiste-info
    artistInfos.forEach((info) => {
        // Vérifiez si c'est la section que vous cliquez
        if (info === artistInfo) {
            info.classList.toggle('show-details');
            // Faites défiler la page pour centrer l'élément cliqué
            info.scrollIntoView({
                behavior: 'smooth', // Pour une animation fluide de défilement
                block: 'center',    // Pour centrer l'élément dans la vue
            });
        } else {
            // Si ce n'est pas la section cliquée, supprimez la classe 'show-details'
            info.classList.remove('show-details');
        }
    });
}

// Sélectionnez toutes les sections d'artiste
const artistSections = document.querySelectorAll('.artist');
// Parcourez chaque section d'artiste et ajoutez un gestionnaire d'événement
artistSections.forEach((artistSection) => {
    // Sélectionnez la section artist-info dans cette section d'artiste
    const artistInfo = artistSection.querySelector('.artist-info');
    // Sélectionnez la photo de l'artiste dans cette section
    const artistPhoto = artistSection.querySelector('.artist-photo');

    // Ajoutez un gestionnaire d'événement de clic à la photo de l'artiste
    artistPhoto.addEventListener('click', () => {
        toggleArtistDetails(artistInfo);
    });
});


/////////////////// DROPDOWN ALBUM \\\\\\\\\\\\\\\\\\\\\\\
function toggleSongs(albumId) {
    const dropdown = document.querySelector(`.album-dropdown[data-album="${albumId}"]`);
    dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
}
