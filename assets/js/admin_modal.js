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

/////////////////// DELETE BTN ALBUM \\\\\\\\\\\\\\\\\\\\\\


document.addEventListener("DOMContentLoaded", function() {
    const deleteForm = document.getElementById("deleteForm");
    const songIdSelect = document.getElementById("songId");
    const songList = document.getElementById("songIdList");
    
    deleteForm.addEventListener("submit", function(event) {
        event.preventDefault()
            
        const selectedSongId = songIdSelect.value;
        if (!selectedSongId) {
            return; // Quitter si aucune chanson n'est sélectionnée
            
        // Effectuer une requête AJAX vers le serveur pour supprimer la chanson
        fetch(`/ZERODEGRE_/admin/album/deleteSong?id=${selectedSongId}`, {
            method: "POST",
        })
        .then(response => response.json())
        .then(data => {
            // Effacer la liste actuelle de chansons
            songList.innerHTML = ""
            // Ajouter les nouvelles chansons à la liste
            data.forEach(song => {
                const songItem = document.createElement("li");
                songItem.textContent = song.title;
                songList.appendChild(songItem);
                })
            // Afficher un message ou effectuer d'autres actions nécessaires
            alert("Chanson supprimée avec succès !");
        })
        .catch(error => {
            console.error("Erreur lors de la requête AJAX :", error);
        });
    });
});



/////////////////// DROPDOWN ALBUM \\\\\\\\\\\\\\\\\\\\\\\

function toggleSongs(albumId) {
    const dropdown = document.querySelector(`.album-dropdown[data-album="${albumId}"]`);
    dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
}