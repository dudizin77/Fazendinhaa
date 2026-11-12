const extratoo = document.querySelector('#extratoo')

let data = await fetch('/projetoPW/api/users/get.php').then(res => res.json());
if (data.error) {
    location.href = '/projetoPW/login';
}
let user = data.user; // <- aqui está o objeto do usuário

let dados = await fetch("/projetoPW/api/users/extrato.php").then(r => r.json());

dados.extrato.forEach(item => {
    extratoo.innerHTML += `<hr>${item.descricao}<br> no valor de R$${item.valor}<br>${item.data_operacao}`
    console.log(item.tipo, item.valor, item.descricao);
});
