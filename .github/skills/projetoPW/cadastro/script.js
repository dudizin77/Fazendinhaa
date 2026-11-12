

const errorSpan = document.querySelector('.error')
const form = document.querySelector('form')
form.addEventListener('submit', async (e)=>{
    e.preventDefault();

    const fd = new FormData(form);
    errorSpan.innerHTML= '';
    // console.log(fd.get('password'))

    if (fd.get('password').length<8) {
        errorSpan.innerHTML="Senha deve possuir 8 digitos";
        return
    }

    if (fd.get('password')!=fd.get('confirm')) {
        errorSpan.innerHTML="Senhas são diferentes";
        return
    }

    const data = await fetch('/projetoPW/api/users/add.php',{
        method: 'POST',
        body: fd,
    }).then(res=>res.json())
    console.log(data);

    if (data.error) {
        errorSpan.innerHTML= data.message
    }else{
        errorSpan.innerHTML="<p class='verde'>Cadastrado com sucesso</p>"
        setTimeout(abrirLogin, 2000)
    }
})

function abrirLogin(){
location.href = '/projetoPW/login'
}