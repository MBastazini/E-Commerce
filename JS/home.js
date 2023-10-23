
function criaBorda(filho, pai) {
    const quadrado = document.querySelector(filho);
    const larguraTela = window.innerWidth; // Obtém a largura da tela do navegador
    const larguraContainer = document.querySelector('.tela_inicial').offsetWidth; // Obtém a largura do container
    const larguraQuadrado = (larguraTela - larguraContainer) / 2; // Calcula a largura do quadrado
    
    quadrado.style.width = larguraQuadrado + 'px'; // Define a largura do quadrado
};

function ajusteTelaInicial(altura_a_descer = 0){
    const alturaTela = window.innerHeight;
    const alturaElemento = document.querySelector('.tela_inicial').offsetHeight;
    const tela_inicial_flex = document.querySelector('.tela_inicial_flex');
    if (alturaElemento > alturaTela) {
        tela_inicial_flex.style.alignItems = 'flex-start';
        tela_inicial_flex.style.height = 'auto';
        altura_a_descer = alturaElemento - alturaTela;
    }
    else{ 
        tela_inicial_flex.style.alignItems = 'center';
        tela_inicial_flex.style.height = '100vh';
        altura_a_descer = 0;
    }
    return altura_a_descer;
}

/*function mudaBlur()
{
    const altura_tela_incio = document.querySelector('.tela_inicial').offsetHeight;
    const scrol = window.scrollY;
    var porcentagem_blur = (scrol * 100) / altura_tela_incio;
    return porcentagem_blur/20;
}*/

const produtos_container = document.querySelector('.produtos_container');

produtos_container.addEventListener("wheel", (e) => {
  const delta = e.deltaY || e.detail || e.wheelDelta;

  // Ajuste a velocidade da rolagem conforme necessário
  const scrollSpeed = 2;

  // Mude a posição da div horizontalmente com base na rolagem do mouse
  produtos_container.scrollLeft += delta * scrollSpeed;

  // Impedir a rolagem padrão da página
  e.preventDefault();
});

function addCart(){
    alert('Produto adicionado ao carrinho!');
}

function muda_info01(el_1){
    const el_direita = document.querySelector('.inf1_d');
    const el_esquerda = document.querySelector('.inf1_e');
    const el_centro = document.querySelector('.inf1_c');

    const bola_ativa = document.querySelector('#bola_ativa');
    const bola_ativa_order = parseInt(getComputedStyle(bola_ativa).getPropertyValue('order'));

    if (el_1.classList.contains('inf1_d'))
    {  
        

        el_1.style.animation = 'inf_grande_d 0.5s forwards';
        el_centro.style.animation = 'inf_pequeno_e 0.5s forwards';
        el_esquerda.style.animation = 'inf_scroll_e_1 0.25s linear forwards, inf_scroll_e_2 0.25s linear 0.25s forwards';
        setTimeout(function() {
            if (bola_ativa_order == 2) {
                bola_ativa.style.order = 0;
            }
            else {
                bola_ativa.style.order = parseInt(bola_ativa_order) + 1;
            }
            el_1.classList.remove('inf1_d');
            el_1.classList.add('inf1_c');
            el_1.removeAttribute('style');

            el_centro.classList.remove('inf1_c');
            el_centro.classList.add('inf1_e');
            el_centro.removeAttribute('style');

            el_esquerda.classList.remove('inf1_e');
            el_esquerda.classList.add('inf1_d');
            el_esquerda.removeAttribute('style');
        }, 500)
        
    }
    else if(el_1.classList.contains('inf1_e'))
    {      

        


        el_1.style.animation = 'inf_grande_e 0.5s forwards';
        el_centro.style.animation = 'inf_pequeno_d 0.5s forwards';
        el_direita.style.animation = 'inf_scroll_d_1 0.25s linear forwards, inf_scroll_d_2 0.25s linear 0.25s forwards';

        setTimeout(function() {

            if (bola_ativa_order == 0) {
                bola_ativa.style.order = 2;
            }
            else {
                bola_ativa.style.order = parseInt(bola_ativa_order) - 1;
            }

            el_1.classList.remove('inf1_e');
            el_1.classList.add('inf1_c');
            el_1.removeAttribute('style');

            el_centro.classList.remove('inf1_c');
            el_centro.classList.add('inf1_d');
            el_centro.removeAttribute('style');

            el_direita.classList.remove('inf1_d');
            el_direita.classList.add('inf1_e');
            el_direita.removeAttribute('style');
        }, 500)
    }

}

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }
        /*else{
            entry.target.classList.remove('show');
        }*/
    });
});

const hidden = document.querySelectorAll('.hidden');
hidden.forEach(hiddens => observer.observe(hiddens));


document.addEventListener("DOMContentLoaded", function() {

     // Barra de pesquisa
     criaBorda('.tela_verde_esquerda', '.tela_inicial');
     var altura_a_descer = 0;
     altura_a_descer = ajusteTelaInicial(altura_a_descer);
 
     window.addEventListener('resize', () => {
         criaBorda('.tela_verde_esquerda', '.tela_inicial');
         altura_a_descer = ajusteTelaInicial(altura_a_descer);
     });
     
    const produtos = document.querySelectorAll('.produto');
    produtos.forEach(produto => {
        const img = produto.querySelector('h2');
        var caminho = img.innerHTML;
        produto.style.backgroundImage = 'url(' + caminho + ')';
    });
 
 
 
 
     // Tela inicial
     document.addEventListener('mousemove', (e) => {
         document.querySelector('.tela_inicial_img').style.transform = `translate(${e.clientX / 100}px, ${e.clientY / 100}px)`;
     });
 
     document.addEventListener('scroll', () => {
         const telaInicio = document.querySelector('.telaInicio');
         if (window.scrollY > altura_a_descer) {
             document.querySelector('.nav_nav').style.transform = 'translateY(0%)';
             //telaInicio.style.filter = 'blur(' + mudaBlur() + 'px)';
         } else {
             document.querySelector('.nav_nav').style.transform = 'translateY(-100%)';
             //telaInicio.style.filter = 'blur(0%)';
         }
     });
 
 
     // Info_01
     const elemento_1 = document.getElementsByClassName('info01_1')[0];
     const elemento_2 = document.getElementsByClassName('info01_1')[1];
     const elemento_3 = document.getElementsByClassName('info01_1')[2];
 
     elemento_1.addEventListener('click', () => muda_info01(elemento_1));
     elemento_2.addEventListener('click', () => muda_info01(elemento_2));
     elemento_3.addEventListener('click', () => muda_info01(elemento_3));
 
     /*const info01_1 = document.querySelectorAll('.info01_1');
     info01_1.forEach(infos => {
         infos.addEventListener('mouseenter', () => {
             info01_1.forEach(inf_h => {
                 inf_h.classList.add('info01_1_hover');
             });
         });
         infos.addEventListener('mouseleave', () => {
             info01_1.forEach(inf_h => {
                 inf_h.classList.remove('info01_1_hover');
             });
         });
     });*/
});