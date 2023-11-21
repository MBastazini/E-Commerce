
 /*function clickMudaImg(img_clicada){
    /* Chamar a função mudaImg(1), até que a 'img_clicada' possua o id='ativa' 
    while(img_clicada.id != 'ativo'){
        mudaImg(1);
    }
}
function mudaImg(a){
    const img = document.querySelectorAll('.div_img_pequena > img');
    const img_ativa = document.getElementById('img_ativa');
    /* Se 'a' vale 0, indica uma movimentação de uma imagem para a direita,
    se for 1, vai mudar uma imagem para a esquerda (existem 4 imagens) 
    if (a == 0){
        for (let i = 0; i < img.length; i++){
            if (img[i].id == 'ativo'){
                img[i].id = '';
                if (i == img.length - 1){
                    img[0].id = 'ativo';
                    img_ativa.style.left = -10 + 'px';
                    break;
                }
                else{
                    img[i + 1].id = 'ativo';
                    let distancia = parseInt(img_ativa.style.left);
                    img_ativa.style.left = (distancia + 100) + 'px';
                    break;
                }
            }
        }
    }
    else{
        for (let i = 0; i < img.length; i++){
            if (img[i].id == 'ativo'){
                img[i].id = '';
                if (i == 0){
                    img[img.length - 1].id = 'ativo';
                    img_ativa.style.left = 290 + 'px';
                    break;
                }
                else{
                    img[i - 1].id = 'ativo';
                    let distancia = parseInt(img_ativa.style.left);
                    img_ativa.style.left = (distancia - 100) + 'px';
                    break;
                }
            }
        }
    }

    img.forEach((img) => {
        if (img.id == 'ativo')
        {
            const img_grande = document.getElementById('img_grande');
            img_grande.src = img.src;
        }
    });
        
}*/

function addCart(event) {
    event.stopPropagation();
}

function removeFiltro(element)
{
    let filtro = element.getAttribute('name');
    let filtros = document.querySelectorAll('.filtro_opcoes > div > input[type="checkbox"]');
    filtros.forEach((check) => {
        if (check.getAttribute('name') == filtro)
        {
            check.checked = true;
            checkFiltro(check.parentElement);
        }
    });
}

function abreFiltro(){
    const a_filtro = document.getElementById('filtro').querySelector('div');
    const filtro_img = document.querySelector('#filtro > h1 > img');
    if (a_filtro.id == 'ativo')
    {
        a_filtro.id = '';
        filtro_img.style.rotate = '0deg';
    }
    else
    {
        a_filtro.id = 'ativo';
        filtro_img.style.rotate = '180deg';
    }

}


function criaFiltro(filtro)
{
    /* criar uma div, colocar dentro del aum texto e uma imagem */
    let ativos = document.getElementById('ativos');
    let div = document.createElement('div');
    div.setAttribute('name', filtro);
    div.setAttribute('onclick', 'removeFiltro(this)');
    let img = document.createElement('img');
    img.src = '../Icones/Uncheck.svg';
    let texto = document.createElement('p');
    div.appendChild(img);
    div.appendChild(texto);
    texto.innerText = filtro;
    ativos.appendChild(div);

    const n_ativo = document.getElementById('n_ativo');
    n_ativo.style.display = 'none';
}


function checkFiltro(element)
{
    let input = element.querySelector('input[type="checkbox"]');
    let filtro = input.getAttribute('name');
    if (input.checked)
    {
        input.checked = false;
        element.classList.remove('enabled');
        let ativos = document.getElementById('ativos');
        let divs = ativos.querySelectorAll('div');;
        divs.forEach((div) => {
            if (div.getAttribute('name') == filtro)
            {
                ativos.removeChild(div);
                if(ativos.childElementCount == 1)
                {
                    const n_ativo = document.getElementById('n_ativo');
                    n_ativo.style.display = 'block';
                }
            }
        }); 
    }
    else
    {
        input.checked = true;
        element.classList.add('enabled');
        criaFiltro(filtro);
    }
    mudaFiltro();
}

function mudaFiltro(){
    const produtos = document.querySelectorAll('.caixa_produto');
    const filtros = document.querySelectorAll('#ativos > div');
    const nenhum_produto = document.getElementById('nenhum-produto-encontrado'); 
    nenhum_produto.style.display = 'block';
    produtos.forEach((produto) => {
        const p_filtros = produto.querySelectorAll('.product > div > h3');
        
        produto.style.display = 'none';
        filtros.forEach((filtro) => {      
            if(filtro.style.display != 'none')
            {
                p_filtros.forEach((p_filtro) => {
                    if (filtro.getAttribute('name') == p_filtro.innerText)
                    {
                        produto.style.display = 'flex';
                        nenhum_produto.style.display = 'none';
                    }
                });
            }   
        });
        
    });
    pg_blur.style.height = document.body.scrollHeight + 'px';
}


function telaProduto(produto){
    const produto_grande = document.getElementById('produto_grande');
    produto_grande.classList.add('ativo');
    const produto_grande_h1 = document.querySelector('#pg_info > h1');
    
    let nome_produto = produto.querySelector('div > h1').innerText;
    produto_grande_h1.innerText = nome_produto;

    let descricao_produto = produto.querySelector('div > p').innerText;
    const produto_grande_h2 = document.querySelector('#pg_info > h2');
    produto_grande_h2.innerText = descricao_produto;

    let preco_produto = produto.querySelector('.product_botoes > h1');
    const produto_grande_preco = document.querySelector('#pg_info > h1:nth-child(3)');
    produto_grande_preco.innerText = preco_produto.innerText;

    let filtro_produto = produto.querySelector('p.categoria:nth-child(1)');
    let quantidade_produto = produto.querySelector('p.categoria:nth-child(2)');

    const produto_grande_filtro = document.querySelector('#info_tipo_estoque > p:nth-child(1)');
    produto_grande_filtro.innerText = filtro_produto.innerText;
    const produto_grande_quantidade = document.querySelector('#info_tipo_estoque > p:nth-child(2)');
    produto_grande_quantidade.innerText = quantidade_produto.innerText;

    const pg_info = document.getElementById('pg_info');
    pg_info.style.top = (window.scrollY + 50) + 'px';
    //Fazer aqui o codigo para carregar a pasta da imagem correta tambem.

    let img = produto.querySelector('img');
    const img_grande = document.getElementById('img_grande');
    img_grande.src = img.src;

    /*const imagens_pequenas = document.querySelectorAll('.div_img_pequena > img');
    let cont = 1;
    imagens_pequenas.forEach((img) => {
        img.src = src;
        cont++;
    });*/
}   

document.addEventListener('DOMContentLoaded', function () {

    const cheks = document.querySelectorAll('.filtro_opcoes > div > input[type="checkbox"]');
    cheks.forEach((check) => {
        check.checked = !check.checked;
        checkFiltro(check.parentElement);
    });

    const produtos = document.querySelectorAll('.caixa_produto');
    produtos.forEach((produto) => {
        produto.addEventListener('click', function () {
            setTimeout(telaProduto(produto), 1000);
        });
    });

    const pg_blur = document.getElementById('pg_blur');
    pg_blur.addEventListener('click', function(e){
        produto_grande.classList.remove('ativo');
    });
    pg_blur.style.height = document.body.scrollHeight + 'px';
});