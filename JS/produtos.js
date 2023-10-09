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
    img.src = 'Icones/Uncheck.svg';
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
    const produtos = document.querySelectorAll('.product');
    const filtros = document.querySelectorAll('#ativos > div');
    produtos.forEach((produto) => {
        const p_filtros = produto.querySelectorAll('div > h3');
        produto.style.display = 'none';

        filtros.forEach((filtro) => {      
            if(filtro.style.display != 'none')
            {
                p_filtros.forEach((p_filtro) => {
                    if (filtro.getAttribute('name') == p_filtro.innerText)
                    {
                        produto.style.display = 'flex';
                    }
                });
            }   
        });

    });
}
function telaProduto(produto){
    const produto_grande = document.getElementById('produto_grande');
    produto_grande.classList.add('ativo');
    const nome_produto = produto_grande.querySelector('#pg_info > h1');
    const descricao_produto = produto_grande.querySelector('#pg_info > p');
    const preco_produto = produto_grande.querySelector('#pg_info > h2');
    const img_produto = produto_grande.querySelector('#pg_info > img');

    img_produto.src = produto.querySelector('img').src;
    nome_produto.innerText = produto.querySelector('div > h1').innerText;
    descricao_produto.innerText = produto.querySelector('div > p').innerText;
    preco_produto.innerText = produto.querySelector('div > h2').innerText;
}   



document.addEventListener('DOMContentLoaded', function () {
    let url = window.location.href;
    if (url.includes('#'))
    {
        let id = url.split('#')[1];
        const produto = document.getElementById(id);
        if (produto)
        {
            setTimeout(telaProduto(produto), 1000);
        }
    }



    const cheks = document.querySelectorAll('.filtro_opcoes > div > input[type="checkbox"]');
    cheks.forEach((check) => {
        check.checked = !check.checked;
        checkFiltro(check.parentElement);
    });

    const produtos = document.querySelectorAll('.product');
    produtos.forEach((produto) => {
        produto.addEventListener('click', function () {
            setTimeout(telaProduto(produto), 1000);
        });
    });

    const pg_blur = document.getElementById('pg_blur');
    pg_blur.addEventListener('click', function(e){
        produto_grande.classList.remove('ativo');
    });
    
    
});