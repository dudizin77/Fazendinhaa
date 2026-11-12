const errorSpan = document.querySelector('.error')
const form = document.querySelector('form')

form.addEventListener('submit', async(e)=>{
    e.preventDefault()


    const data = await fetch('/projetoPW/api/users/login.php',{
        method: 'POST',
        body: new FormData(form),
    }).then(res=> res.json())

    if (data.error) {
        errorSpan.innerHTML="Erro ao fazer login"        
    }
    else{
        errorSpan.innerHTML="<p class='verde'>Login efetuado com sucesso...</p>"
        setTimeout(abrirPagInicial, 2000)
    }
})

function abrirPagInicial(){
location.href = '/projetoPW/pagInicial'
}