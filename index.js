

/* MAIN ==========================================================================================









*/
document.addEventListener("DOMContentLoaded", function() {
    const resultados = document.querySelector('.nav_p_resultados');
    const pesquisa_input = document.querySelector('.nav_pesquisa input');   
    const pesquisa = document.querySelector('.nav_pesquisa');
    const pesquisa_img = document.querySelector('.nav_pesquisa img');     

    pesquisa_input.addEventListener('focus', () => {
        resultados.style.display = 'flex'; // Exemplo: definindo a cor de fundo para lightgray
        pesquisa.style.border = '2px solid #52381A';
        pesquisa_img.style.transform = 'translateX(0%)'
        pesquisa_img.style.opacity = '1';
        pesquisa_input.style.transform = 'translateX(0%)'
    });

    pesquisa_input.addEventListener('blur', () => {
        resultados.style.display = 'none'; // Remover o estilo quando o campo perde foco
        pesquisa.style.border = '2px solid #D4EBC6';
        pesquisa_img.style.transform = 'translateX(-30px)'
        pesquisa_input.style.transform = 'translateX(-30px)'
        pesquisa_img.style.opacity = '0';
    });

    pesquisa_input.addEventListener('input', () => {
        const value = pesquisa_input.value.toLowerCase();
        const p_resultados = document.querySelectorAll('.nav_p_resultados p');
        
        if (value === '') {
            // Se o valor estiver vazio, esconda todos os resultados
            p_resultados.forEach(p_resultado => {
                p_resultado.style.display = 'none';
                //Adicionar aqui o codigo pra sumir com a div de resultados
            });
        } else {
            // Caso contrário, filtre os resultados com base no valor inserido
            p_resultados.forEach(p_resultado => {
                if (p_resultado.innerText.toLowerCase().includes(value)) {
                    p_resultado.style.display = 'block';
                } else {
                    p_resultado.style.display = 'none';
                }
            });
        }
    });

    
   

});