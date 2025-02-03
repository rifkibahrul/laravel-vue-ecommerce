document.addEventListener('DOMContentLoaded', () => {
    const loadingSpinner = document.getElementById('loading-spinner');
    if (loadingSpinner) {
        // Tambahkan durasi
        setTimeout(() => {
            loadingSpinner.style.display = 'none';
        }, 600); // Durasi dalam milidetik (2 detik = 2000 ms)
    }
});