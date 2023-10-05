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
}

function telaProduto(){
    const produto_grande = document.getElementById('produto_grande');
    produto_grande.classList.add('ativo');
    
    
}   



document.addEventListener('DOMContentLoaded', function () {
    const cheks = document.querySelectorAll('.filtro_opcoes > div > input[type="checkbox"]');
    cheks.forEach((check) => {
        check.checked = !check.checked;
        checkFiltro(check.parentElement);
    });


    

    const produtos = document.querySelectorAll('.product');
    produtos.forEach((produto) => {
        produto.addEventListener('click', function () {
            setTimeout(telaProduto(), 1000);
        });
    });

    const pg_blur = document.getElementById('pg_blur');
    pg_blur.addEventListener('click', function(e){
        produto_grande.classList.remove('ativo');
    });
    
    
});