function checa_botao(input, texto)
{
    if (input.value != '') {
        texto.id = 'input-ativo-blur';
    }
    else{
        texto.id = '';
    }
}


function adicionarEventos(inputElement, textoElement) {
    checa_botao(inputElement, textoElement);
    inputElement.addEventListener('focus', () => {
      textoElement.id = 'input-ativo';
    });
    /* Usar o codigo abaixo se achar necessario.
     Ele faz com que, se um texto for adicionado sem que o usuario chege a dar um input 
     (de forma automatica pelo navegador, por exemplo) o texto suba mesmo assim.
     Porem, usando ele, quando se digita um texto e apaga tudo, sem perder o focus, o texto desce
     Use por sua propria escolha.
     
     inputElement.addEventListener('input', () => {
       checa_botao(inputElement, textoElement);
     }); */
    inputElement.addEventListener('blur', () => {
      checa_botao(inputElement, textoElement);
    });
  }

document.addEventListener("DOMContentLoaded", function() {
    
    const email = document.querySelector('.tela_log_cad > form > .email > input');
    const email_texto = document.querySelector('.tela_log_cad > form > .email > p');

    const senha = document.querySelector('.tela_log_cad > form > .senha > input');
    const senha_texto = document.querySelector('.tela_log_cad > form > .senha > p');

    const nome = document.querySelector('.tela_log_cad > form > .nome > input');
    const nome_texto = document.querySelector('.tela_log_cad > form > .nome > p');

    const telefone = document.querySelector('.tela_log_cad > form > .telefone > input');
    const telefone_texto = document.querySelector('.tela_log_cad > form > .telefone > p');

    const senha_c = document.querySelector('.tela_log_cad > form > .senha_c > input');
    const senha_c_texto = document.querySelector('.tela_log_cad > form > .senha_c > p');
      
      const elementos = [
        { input: email, texto: email_texto },
        { input: senha, texto: senha_texto },
        { input: nome, texto: nome_texto },
        { input: telefone, texto: telefone_texto },
        { input: senha_c, texto: senha_c_texto }
      ]
      
      elementos.forEach(({ input, texto }) => {
        adicionarEventos(input, texto);
      });
      
    
});