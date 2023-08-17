// Fenetre Modale Delete User //

// Récupérer les éléments nécessaires
const openModalLinks = document.querySelectorAll('.open-modal');
const closeModalButtons = document.querySelectorAll('.modal, .modal #cancel-delete');
let userIdToDelete;
// Fonction pour ouvrir la fenêtre modale
function openModal(event) {
    userIdToDelete = event.target.getAttribute('data-user-id');
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'block';

    // Définir l'URL de confirmation de suppression avec l'ID de l'utilisateur
    const confirmButton = modal.querySelector('#confirm-delete');
    confirmButton.setAttribute('data-user-id', userIdToDelete);
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

document.getElementById("confirm-delete").addEventListener("click", function(){
    
    const modal = document.getElementById('deleteModal');
    const deleteBtn = document.getElementById('confirm-delete');
    const userId = deleteBtn.getAttribute('data-user-id');
    modal.style.display = 'none';
    console.log("ID envoyé depuis JavaScript :", userId);
    const requestData = {
        userId : userIdToDelete 
    };

    fetch(`index.php?route=admin_user_delete&id=${userId}`, {
        method: "GET", 
    })
    .then(response => response.json()) // Converti la réponse en Objet JSON
    .then(data => {
        if (Array.isArray(data))
        {
            echo("yoooo")
            const userTableBody = document.getElementById("userTableBody");
            userTableBody.innerHTML = '' // Vide le contenu actuel du tableau
            
            //Remplir le tableau avec les nouvelles données des users
            data.newUserList.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.firstName}</td>
                    <td>${user.lastName}</td>
                    <td>${user.email}</td>
                    <td>${user.roleId}</td>
                    <td>
                        <a href="index.php?route=admin_user_edit&id=${user.id}" class="edit-user-btn">Modifier</a>
                        <a class="open-modal" data-user-id="${user.id}">Supprimer</a>
                    </td>
                `;
                userTableBody.appendChild(row);
            })
        }
    })
    .catch(error => {
        console.error("Une erreur c'est produite :", error.error);
    })
    
});

//Vider le html avec un inner je sais plus quoi et demander au fetch de remplir le tableau avec les nouvelles données de la BDD