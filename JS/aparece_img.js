const file_input = document.getElementById('fileToUpload');
const imagem_produto = document.querySelector('#form_img > div > img');

file_input.addEventListener('change', function () {
    //checa se a imagem é válida e é .jpg (se não for emite um alert())
    const file = this.files[0];
    const reader = new FileReader();
    const imageType = /image.*/;
    if (!file.type.match(imageType)) {
        alert('Formato de imagem inválido!');
        return;
    }
    if (file.type != 'image/jpeg') {
        alert('Imagem deve ser um .jpg!');
        return;
    }
    reader.addEventListener('load', function () {
        imagem_produto.src = this.result;
        imagem_produto.style.display = 'block';
    });
    reader.readAsDataURL(file);
});


document.addEventListener('DOMContentLoaded', function () {
    if (imagem_produto.getAttribute('src') == "#")
    {
        imagem_produto.style.display = 'none';
    }

    if (imagem_produto_form.getAttribute('src') == "#")
    {
        imagem_produto_form.style.display = 'none';
    }
});