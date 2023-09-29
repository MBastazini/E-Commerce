function checa_botao(input, texto)
{
    if (input.value != '') {
        texto.id = 'input-ativo';
    }
    else{
        texto.id = '';
    }
}



document.addEventListener("DOMContentLoaded", function() {
    const email = document.querySelector('.login > form > .email > input');
    const email_texto = document.querySelector('.login > form > .email > p');

    const senha = document.querySelector('.login > form > .senha > input');
    const senha_texto = document.querySelector('.login > form > .senha > p');

    // eggee
    checa_botao(email, email_texto);    
    email.addEventListener('focus', () => {
        email_texto.id = 'input-ativo';
    });
    
    email.addEventListener('blur', () => {
        checa_botao(email, email_texto);
    });

    // eggee
    checa_botao(senha, senha_texto);
    senha.addEventListener('focus', () => {
        senha_texto.id = 'input-ativo';
    });
    senha.addEventListener('blur', () => {
        checa_botao(senha, senha_texto);
    });
    
});