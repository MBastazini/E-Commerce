const select = document.querySelector('.inp.file > select');
const imagem_produto_form = document.querySelector('#crud_produto_img > img');
select.addEventListener('change', function () {
    let selectedOption = this.options[this.selectedIndex];
    let nameAttribute = selectedOption.getAttribute('name');
    
    imagem_produto_form.src = "../" + nameAttribute;
    imagem_produto_form.style.display = 'block';
});

document.addEventListener('DOMContentLoaded', function () {

    let selectedOption = select.options[select.selectedIndex];
    let nameAttribute = selectedOption.getAttribute('name');

    if (imagem_produto_form.getAttribute('src') == "#")
    {

        imagem_produto_form.src = "../" + nameAttribute;
    }
});