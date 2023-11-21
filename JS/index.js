

/* MAIN ==========================================================================================









*/
function mudaLink(str){
    let link = window.location.href;
    let a = link.split('/');
    alert(a);
}

function checkInput(pesquisa_input, resultados){
    if (pesquisa_input.value.length > 0)
        {
            resultados.id = 'ativo';
            const texto_opcoes = document.querySelectorAll('.nav_p_resultados > a > div > p');
            texto_opcoes.forEach((texto_opcao) => {
                if (texto_opcao.innerText.toLowerCase().includes(pesquisa_input.value.toLowerCase()))
                {
                    texto_opcao.parentElement.parentElement.style.display = 'block';
                }
                else
                {
                    texto_opcao.parentElement.parentElement.style.display = 'none';
                }
            });
        }
        else
        {
            resultados.id = '';
        }
}
document.addEventListener("DOMContentLoaded", function() {
    //pega a mensagem do link depois do # e mostra ela
    var link = window.location.href;
    if (!(link.includes('Sobre'))) {
        var mensagem = window.location.hash;
        mensagem = mensagem.replace('#', '');
        if (!(/^\d+$/.test(mensagem)))
        {
            if (mensagem != '') {  
                mensagem = mensagem.replaceAll('-', ' ');
                alert(mensagem);
            }
        }
    }
    

    const resultados = document.querySelector('.nav_p_resultados');
    const pesquisa_input = document.querySelector('.nav_pesquisa input');   
    const pesquisa = document.querySelector('.nav_pesquisa');
    const pesquisa_img = document.querySelector('.nav_pesquisa img');     

    pesquisa_input.addEventListener('focus', () => {
        checkInput(pesquisa_input, resultados);
        pesquisa.style.border = '2px solid #52381A';
        pesquisa_img.style.transform = 'translateX(0%)'
        pesquisa_img.style.opacity = '1';
        pesquisa_input.style.transform = 'translateX(0%)'
    });

    pesquisa_input.addEventListener('blur', () => {
        setTimeout(() => {
            resultados.id = '';
        }, 500);
            pesquisa.style.border = '2px solid #D4EBC6';
            pesquisa_img.style.transform = 'translateX(-30px)'
            pesquisa_input.style.transform = 'translateX(-30px)'
            pesquisa_img.style.opacity = '0';
    }); 

     pesquisa_input.addEventListener('input', () => {
        checkInput(pesquisa_input, resultados);
    });

    
    const nav_tres_risco = document.querySelector('.nav_tres_risco');
 
    nav_tres_risco.addEventListener('click', () => {
        const nav_elementos = document.querySelector('.nav_elementos');
        if (nav_elementos.style.opacity == '1') {
            nav_elementos.style.opacity = '0';
            nav_elementos.style.transform = 'translateY(-150%)';
        }
        else{
            nav_elementos.style.opacity = '1';
            nav_elementos.style.transform = 'translateY(0%)';
        }
    });

});