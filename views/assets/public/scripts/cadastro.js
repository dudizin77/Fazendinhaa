// Exibe o campo CNPJ se "Administrador" for selecionado
document.addEventListener('DOMContentLoaded', function () {
    const accountType = document.querySelector('select[name="accountType"]');
    const form = document.querySelector('form');
    
    if (!accountType) return;

    // Cria o campo CNPJ (inicialmente oculto)
    const cnpjInput = document.createElement('input');
    cnpjInput.type = 'text';
    cnpjInput.name = 'cnpj';
    cnpjInput.placeholder = 'CNPJ';
    cnpjInput.required = true;
    cnpjInput.style.display = 'none';
    cnpjInput.style.marginTop = '10px';

    // Insere o campo CNPJ após o select
    accountType.parentNode.insertBefore(cnpjInput, accountType.nextSibling);

    accountType.addEventListener('change', function () {
        if (accountType.value === 'admin') {
            cnpjInput.style.display = '';
            cnpjInput.required = true;
        } else {
            cnpjInput.style.display = 'none';
            cnpjInput.required = false;
        }
    });

    // Garante o estado correto ao carregar a página
    if (accountType.value === 'admin') {
        cnpjInput.style.display = '';
        cnpjInput.required = true;
    }

    // Função de envio do formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const fd = new FormData(form);  

        const name = form.querySelector('input[name="name"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const password = form.querySelector('input[name="password"]').value;
        const accountTypeValue = form.querySelector('select[name="accountType"]').value;

        // type_id: 1 = ADMIN, 2 = STANDARD (CLIENTE)
        const typeId = accountTypeValue === 'admin' ? 1 : 2;

        fetch('http://localhost/fazendinhaNOVA/api/users/register', {
            method: 'POST',
            body: fd
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                alert('Cadastro realizado com sucesso! Você será redirecionado para o login.');
                window.location.href = 'login.html';
            } else {
                console.log('Erro: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            console.log('Erro ao cadastrar. Tente novamente.');
        });
    });
});
