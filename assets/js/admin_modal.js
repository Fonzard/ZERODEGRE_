// Récupérer les éléments nécessaires pour la suppression
const openModalLinks = document.querySelectorAll('.open-modal');
const closeModalButtons = document.querySelectorAll('.modal, .modal #cancel-delete');
const modal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirm-delete');
const tableBody = document.getElementById("tableBody");

let entityIdToDelete;
let entityType; // "user" or "product"

// Fonction pour ouvrir la fenêtre modale
function openModal(event) {
    entityIdToDelete = event.target.getAttribute('data-entity-id');
    entityType = event.target.getAttribute('data-entity-type');
    modal.style.display = 'block';

    // Définir l'URL de confirmation de suppression avec l'ID de l'entité
    confirmBtn.setAttribute('data-entity-id', entityIdToDelete);
} 

// Fonction pour fermer la fenêtre modale
function closeModal() {
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
    if (event.target === modal) {
        closeModal();
    }
});

// Ajouter un gestionnaire d'événement pour la suppression

    //Change la valeur de l'id que recoit le btn 
    // const songIdList = document.getElementById("songIdList");
    // const songDeleteBtn = document.getElementById("song-delete-btn");
    // const baseAction = songDeleteBtn.getAttribute("data-action");
    
    
    
    // songIdList.addEventListener("change", function() {
    //     console.log('yoooo');
    //     // const selectIndex = songIdList.selectedIndex;
    //     // console.log(selectIndex);
    //     // const selectedSongId = selectIndex.value;
    //     // const newAction = baseAction + selectedSongId;
    //     // songDeleteBtn.setAttribute("data-action", newAction);
    // });
