// Script da área do cliente (logout)
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logout');
    if (logoutBtn) {
        logoutBtn.onclick = function() {
            localStorage.removeItem('agrocontrolLogged');
            window.location.href = '../index.html';
        }
    }
});