let data = await fetch('/projetoPW/api/users/get.php').then(res => res.json());
if (data.error) {
    location.href = '/projetoPW/login';
}
let user = data.user; // <- aqui está o objeto do usuário
