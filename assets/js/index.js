// Fenetre Modale Delete User
// Récupérer les éléments nécessaires
const openModalLinks = document.querySelectorAll('.open-modal');
const closeModalButtons = document.querySelectorAll('.modal .close, .modal #cancel-delete');

// Fonction pour ouvrir la fenêtre modale
function openModal(event) {
    const userId = event.target.getAttribute('data-user-id');
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'block';

    // Définir l'URL de confirmation de suppression avec l'ID de l'utilisateur
    const confirmButton = modal.querySelector('#confirm-delete');
    confirmButton.setAttribute('href', `index.php?route=admin_user_delete&id=${userId}`);
}

// Fonction pour fermer la fenêtre modale
function closeModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
}

// Attacher les gestionnaires d'événements aux liens et boutons
openModalLinks.forEach(link => {
    link.addEventListener('click', openModal);
});

closeModalButtons.forEach(button => {
    button.addEventListener('click', closeModal);
});

// Fermer la fenêtre modale si l'utilisateur clique en dehors d'elle
window.addEventListener('click', event => {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeModal();
    }
});
