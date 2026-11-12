const btn = document.querySelector('.btn')
const botoes = document.querySelector('#botoes')

btn.addEventListener('click', ()=>{
    botoes.innerHTML='<button class="btnTemConta">Já tenho conta!</button> <button class="btnNtemConta">Não tenho uma conta</button>'
    const btnTem = document.querySelector('.btnTemConta')
    const btnNtem = document.querySelector('.btnNtemConta')

    btnTem.addEventListener('click', ()=>{
    location.href = '/projetoPW/login'
    })
    btnNtem.addEventListener('click', ()=>{
    location.href = '/projetoPW/cadastro'
    })
})