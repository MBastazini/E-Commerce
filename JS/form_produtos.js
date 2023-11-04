const file_input = document.getElementById('fileToUpload');
const imagem_produto = document.querySelector('.inp.file > img');

file_input.addEventListener('change', function () {
    const file = this.files[0];
    const reader = new FileReader();
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
});