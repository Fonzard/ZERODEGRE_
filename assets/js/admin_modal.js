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

// Fonction pour confirmer la suppression
function confirmDelete() {
    if (entityIdToDelete && entityType) {
        // Envoyez une requête JSON pour supprimer l'utilisateur ou l'entité en fonction de entityType et entityIdToDelete.
        fetch(entityType + '/delete&id=' + entityIdToDelete, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Suppression réussie
                // Mettez à jour la table en supprimant la ligne correspondante sans recharger la page
                const rowToDelete = document.querySelector(`#tableBody tr[data-entity-id="${entityIdToDelete}"]`);
                if (rowToDelete) {
                    rowToDelete.remove();
                }
        
                // Mettez à jour la table avec les nouvelles données renvoyées par le serveur
                const tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = ''; // Effacez le contenu actuel de la table
        
                // Boucle à travers les nouvelles données et ajoutez-les à la table
                data.users.forEach(user => {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.firstName}</td>
                        <td>${user.lastName}</td>
                        <td>${user.email}</td>
                        <td>${user.role === 2 ? 'Admin' : 'User'}</td>
                        <td>
                            <div class="admin-table-btn">
                                <a href="/ZERODEGRE_/admin/user/edit&id=${user.id}" class="edit-user-btn">Modifier</a>
                                <a class="open-modal" data-entity-id="${user.id}" data-entity-type="user">Supprimer</a>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                });
        
                closeModal();
            } else {
                // Gérer les erreurs
                console.error('Erreur lors de la suppression de l\'utilisateur : ' + data.message);
            }
        })


    }
}
confirmBtn.addEventListener('click', confirmDelete);