function loadingFade() {
    // Sélectionne les éléments du chargement par leurs classes CSS.
    const loadingBg = document.querySelector('.loading-bg'); // Sélectionne l'arrière-plan de chargement.
    const loadingImg = document.querySelector('.loading-img'); // Sélectionne l'image de chargement.

    // Réduit l'opacité de l'arrière-plan et de l'image 
    loadingBg.style.opacity = "0";
    loadingImg.style.opacity = "0";
}

function loadingRemove() {
    // Sélectionne l'élément de chargement complet par sa classe CSS.
    const loading = document.querySelector('.loading');

    // Cache l'élément de chargement en le configurant pour ne pas être affiché.
    loading.style.display = "none";
}

// Démarre la fonction loadingFade toutes les 2 secondes
window.setInterval(loadingFade, 2000);

// Démarre la fonction loadingRemove toutes les 3 secondes en 
window.setInterval(loadingRemove, 3000);
