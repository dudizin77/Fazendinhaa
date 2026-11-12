// Script da área admin (logout)
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logout');
    if (logoutBtn) {
        logoutBtn.onclick = function() {
            localStorage.removeItem('agrocontrolLogged');
            localStorage.removeItem('agrocontrolIsAdmin');
            window.location.href = '../index.html';
        }
    }
});