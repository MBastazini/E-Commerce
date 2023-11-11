    // Obtém todas as opções
    var options = document.querySelectorAll('.filtro div p');
    var form = document.querySelector('#relatorios > form');
    // Adiciona um event listener a cada opção
    options.forEach(function (option) {
        option.addEventListener('click', function () {
            // Remove a classe 'enabled' de todas as opções
            options.forEach(function (opt) {
                opt.classList.remove('enabled');
            });

            // Adiciona a classe 'enabled' à opção clicada
            option.classList.add('enabled');
            form.setAttribute("action", "?tipo=" + option.getAttribute('name'));

            // Esconde todas as divs
            var divs = document.querySelectorAll('#opcoes > div:not(.filtro)');
            divs.forEach(function (div) {
                div.classList.add('hidden');
            });

            // Exibe a div correspondente à opção selecionada
            var selectedDiv = document.querySelector(`div[name="${option.getAttribute('name')}"]`);
            selectedDiv.classList.remove('hidden');
        });
    });