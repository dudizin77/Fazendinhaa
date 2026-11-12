const nome = document.querySelector('#nome')
const email = document.querySelector('#email')
const id = document.querySelector('#id')
const logout = document.querySelector('#logout')

let data = await fetch('/projetoPW/api/users/get.php').then(res => res.json());
let user = data.user; 

logout.addEventListener('click', ()=>{
    fetch('/projetoPW/api/users/logout.php');
    location.href = '/projetoPW/login';
})

nome.innerHTML = `<p>${user.name}</p>`;
email.innerHTML = `<p>Email: ${user.email}</p>`;
id.innerHTML = `<p>Id: ${user.id}</p>`;