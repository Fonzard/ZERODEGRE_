
// Fenetre modale delete
document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('.delete-user-link');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    const cancelDeleteButton = document.getElementById('cancelDelete');
    let userIdToDelete = null;

    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            userIdToDelete = link.getAttribute('data-user-id');
            deleteModal.style.display = 'block';
        });
    });

    confirmDeleteButton.addEventListener('click', function() {
        if (userIdToDelete !== null) {
            // Rediriger vers le script PHP de suppression en passant l'ID de l'utilisateur
            window.location.href = `index.php?route=admin/user/delete&id=${userIdToDelete}`;
        }
    });

    cancelDeleteButton.addEventListener('click', function() {
        deleteModal.style.display = 'none';
    });
});

