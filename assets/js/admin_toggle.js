/////////////////// DROPDOWN NAV \\\\\\\\\\\\\\\\\\\\\\\

const headerAdminMenuButton = document.querySelector("#header-admin-menu-button");
const headerAdminMenu = document.querySelector("#header-admin-menu");

headerAdminMenuButton.addEventListener("click", () => {
    headerAdminMenu.classList.toggle("show-menu");
    headerAdminMenuButton.classList.toggle('close');
});


/////////////////// DROPDOWN ALBUM \\\\\\\\\\\\\\\\\\\\\\\

function toggleSongs(albumId) {
    const dropdown = document.querySelector(`.album-dropdown[data-album="${albumId}"]`);
    dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
}