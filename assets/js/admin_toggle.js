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




/////////////////// DROPDOWN ALBUM \\\\\\\\\\\\\\\\\\\\\\\

function toggleSongs(albumId) {
    const dropdown = document.querySelector(`.album-dropdown[data-album="${albumId}"]`);
    dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
}