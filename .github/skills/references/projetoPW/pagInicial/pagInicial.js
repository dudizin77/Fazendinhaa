const saldoDaConta = document.querySelector('#saldoDaConta')
const investimentos = document.querySelector('#investimentos')
const saldoDoUsuario = document.querySelector('#saldoDoUsuario')
const nomeUsuario = document.querySelector('.nomeUsuario')
const areapix = document.querySelector('#areapix')
const logout = document.querySelector('#logout')
const extrato = document.querySelector('#extrato')
const naoDisponivel = document.querySelectorAll('.naoDisponivel')
let data = await fetch('/projetoPW/api/users/get.php').then(res => res.json());
if (data.error) {
    location.href = '/projetoPW/login';
}
let user = data.user; // <- aqui está o objeto do usuário
saldoDoUsuario.innerHTML = `<p>Saldo de R$${user.saldo}</p>`;
nomeUsuario.innerHTML = `<p>${user.name}</p>`;


areapix.addEventListener('click', ()=>{
    location.href = '/projetoPW/pagarPix';
})

investimentos.addEventListener('click', ()=>{
    location.href = '/projetoPW/investimentos';
})

extrato.addEventListener('click', ()=>{
    location.href = '/projetoPW/extrato';
})

naoDisponivel.forEach(botao => {
    botao.addEventListener('click', () => {
        location.href = '/projetoPW/naoDisponivel';
    });
});

logout.addEventListener('click', ()=>{
    fetch('/projetoPW/api/users/logout.php');
    location.href = '/projetoPW/login';
})

async function recarregarSaldo() {
  const resposta = await fetch('/projetoPW/api/users/get.php');
  const dados = await resposta.json();

  if (!dados.error) {
    const usuario = dados.user;
    saldoDaConta.innerHTML = `<p>Saldo: R$ ${usuario.saldo.toFixed(2)}</p>`;
  }
}

console.log(data);