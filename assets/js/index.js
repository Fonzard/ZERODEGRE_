// Fenetre Modale Delete User //
// Récupérer les éléments nécessaires
const openModalLinks = document.querySelectorAll('.open-modal');
const closeModalButtons = document.querySelectorAll('.modal, .modal #cancel-delete');
const modal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirm-delete');
const userTableBody = document.getElementById("userTableBody");

let userIdToDelete;
// Fonction pour ouvrir la fenêtre modale
function openModal(event) {
    userIdToDelete = event.target.getAttribute('data-user-id');
    modal.style.display = 'block';

    // Définir l'URL de confirmation de suppression avec l'ID de l'utilisateur
    confirmBtn.setAttribute('data-user-id', userIdToDelete);
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

document.getElementById("confirm-delete").addEventListener("click", function(){
    
    const userId = confirmBtn.getAttribute('data-user-id');
    modal.style.display = 'none';
    console.log("ID envoyé depuis JavaScript :", userId);
    const requestData = {
        userId : userIdToDelete 
    };

    fetch(`index.php?route=admin_user_delete&id=${userId}`, {
        method: "GET", 
    })
    .then(response => response.json()) // Converti la réponse en Objet JSON
    .then((data) => {

        userTableBody.innerHTML = ''; // Vide le contenu actuel du tableau
        console.log(data);
            
        //Remplir le tableau avec les nouvelles données des users
        data.forEach(user => {
            console.log(user);
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
    })  
})