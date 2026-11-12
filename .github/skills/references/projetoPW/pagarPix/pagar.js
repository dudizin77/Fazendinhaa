const saldoDaConta = document.querySelector('#saldoDaConta');
const inputEmail = document.querySelector('#inputChavePix');
const inputValor = document.querySelector('#inputValorPix');
const enviar = document.querySelector('#enviar');
const msg = document.querySelector('#msg');

const resposta = await fetch('/projetoPW/api/users/get.php');
const data = await resposta.json();

if (data.error) {
    location.href = '/projetoPW/login';
}

const usuario = data.user;
saldoDaConta.innerHTML = `<p>Saldo: R$ ${usuario.saldo.toFixed(2)}</p>`;


// Função para enviar o Pix
async function enviarPix() {
    const emailDestino = inputEmail.value.trim();
    const valor = parseFloat(inputValor.value);

    if (!emailDestino || isNaN(valor) || valor <= 0) {
        msg.innerHTML="<p class='mensagemm'>Preencha o email e o valor corretamente!</p>";
        return;
    }

    const resposta = await fetch('/projetoPW/api/users/transferencia.php', {
        method: 'POST',
        body: new URLSearchParams({
            emailDestino: emailDestino,
            valor: valor
        })
    });

    const resultado = await resposta.json();

    if (resultado.erro) {
        alert(resultado.mensagem);
        msg.innerHTML="<p class='mensagemmm'>Preencha o email e o valor corretamente!</p>";
    } else {
        alert(resultado.mensagem);
        msg.innerHTML="<p class='mensagemmm'>Preencha o email e o valor corretamente!</p>";
        location.reload(); 
    }
}



const modal = document.querySelector('#confirmacao');
const textoConfirmacao = document.querySelector('#textoConfirmacao');
const confirmarEnvio = document.querySelector('#confirmarEnvio');
const cancelarEnvio = document.querySelector('#cancelarEnvio');

// quando clicar no botão ENVIAR → abrir popup de confirmação
enviar.addEventListener('click', () => {
    const emailDestino = inputEmail.value.trim();
    const valor = parseFloat(inputValor.value);

    if (!emailDestino || isNaN(valor) || valor <= 0) {
        msg.innerHTML = "<p class='mensagemm'>Preencha o email e o valor corretamente!</p>";
        return;
    }

    // texto da confirmação
    textoConfirmacao.innerHTML = `
        Tem certeza que deseja enviar <b>R$ ${valor.toFixed(2)}</b><br>
        para <b>${emailDestino}</b>?
    `;

    modal.style.display = 'flex';
});

cancelarEnvio.addEventListener('click', () => {
    modal.style.display = 'none';
});

confirmarEnvio.addEventListener('click', () => {
    modal.style.display = 'none';
    enviarPix();
});