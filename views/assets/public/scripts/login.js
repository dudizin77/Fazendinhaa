const form = document.querySelector('#form-login');
const errorSpan = document.querySelector('.error');

localStorage.setItem('agrocontrolLogged', 'false');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
        const response = await fetch('http://localhost/fazendinhaNOVA/api/users/login', {
                                      
            method: 'POST',
            body: new FormData(form)
        });

        const data = await response.json();
        console.log(data)

        console.log('Resposta da API:', data);
        if (data.type === 'error' || response.status >= 400) {
            console.log('Erro ao fazer login.');
            return;
        }
        console.log(data)
            localStorage.setItem(
                'agrocontrolUser',
                JSON.stringify(data)
            );
            
                console.log("Login efetuado com sucesso...");

            setTimeout(() => {
                window.location.href = 'app.html';
            }, 1000);


    } catch (error) {
        console.error('Erro na requisição:', error);
    }
});