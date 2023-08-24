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
document.getElementById("confirm-delete").addEventListener("click", function(){
    modal.style.display = 'none';

    // Construire l'URL de suppression en fonction du type d'entité
    const deleteUrl = `/ZERODEGRE_/admin/${entityType}/delete&id=${entityIdToDelete}`;

    fetch(deleteUrl, {
        method: "GET", 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(data.message);
            console.log(data[`${entityType}s`]);
            tableBody.innerHTML = ''; // Vide le contenu actuel du tableau

            // Remplir le tableau avec les nouvelles données des entités
            data[`${entityType}s`].forEach(entity => {
                const row = document.createElement('tr');
                // Construire les cellules de la ligne en fonction du type d'entité
                let cellContent = '';
                if (entityType === 'user') {
                    cellContent = `
                        <td>${entity.id}</td>
                        <td>${entity.firstName}</td>
                        <td>${entity.lastName}</td>
                        <td>${entity.email}</td>
                        <td>${entity.roleId}</td>
                    `;
                } else if (entityType === 'product') {
                    cellContent = `
                        <td>${entity.id}</td>
                        <td>${entity.name}</td>
                        <td>${entity.price}</td>
                        <td>${entity.description}</td>
                        <td>${entity.quantity}</td>
                        <td>${entity.category_id}</td>
                        <td>${entity.media_id}</td>
                    `;
                }
                // Ajouter les cellules restantes et la ligne au tableau
                row.innerHTML = `
                    ${cellContent}
                    <td>
                        <a href="/ZERODEGRE_/admin/${entityType}/edit&id=${entity.id}" class="edit-btn">Modifier</a>
                        <a class="open-modal" data-entity-id="${entity.id}" data-entity-type="${entityType}">Supprimer</a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            console.log(data.message); // Affiche un message d'erreur
        }
    });  
});
