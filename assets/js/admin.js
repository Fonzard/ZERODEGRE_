// Fenetre Modale Delete User //
// Récupérer les éléments nécessaires
const openModalLinks = document.querySelectorAll('.open-modal');
const closeModalButtons = document.querySelectorAll('.modal, .modal #cancel-delete');
const modal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirm-delete');
const productTableBody = document.getElementById("tableBody");

let productIdToDelete;
// Fonction pour ouvrir la fenêtre modale
function openModal(event) {
    productIdToDelete = event.target.getAttribute('data-user-id');
    modal.style.display = 'block';

    // Définir l'URL de confirmation de suppression avec l'ID de l'utilisateur
    confirmBtn.setAttribute('data-user-id', productIdToDelete);
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
    
    //Pourquoi a nouveau getAttribute data-user-id ????
    modal.style.display = 'none';
    console.log("ID envoyé depuis JavaScript :", productIdToDelete);
    const requestData = {
        productIdToDelete : productIdToDelete 
    };

    fetch(`index.php?route=admin_product_delete&id=${productIdToDelete}`, {
        method: "GET", 
    })
    .then(response => response.json()) // Converti la réponse en Objet JSON
    .then((data) => {

        productTableBody.innerHTML = ''; // Vide le contenu actuel du tableau
        console.log(data);
            
        //Remplir le tableau avec les nouvelles données des users
        data.forEach(product => {
            console.log(product);
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.price}</td>
                <td>${product.description}</td>
                <td>${product.quantity}</td>
                <td>${product.categoryId}</td>
                <td>${product.mediaId}</td>
                <td>
                    <a href="index.php?route=admin_product_edit&id=${product.id}" class="edit-btn">Modifier</a>
                    <a class="open-modal" data-user-id="${product.id}">Supprimer</a>
                </td>
            `;
            productTableBody.appendChild(row);
        })
    })  
})