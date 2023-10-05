function loadingFade() {
    const loadingBg = document.querySelector('.loading-bg');
    const loadingImg = document.querySelector('.loading-img');
    loadingBg.style.opacity = "0";
    loadingImg.style.opacity = "0";
    
}

function loadingRemove() {
    const loading = document.querySelector('.loading');
    loading.style.display = "none";
}

window.setInterval(loadingFade, 2000);
window.setInterval(loadingRemove, 3000);