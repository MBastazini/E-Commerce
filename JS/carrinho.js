function novoProduto(id, nome, quantidade, preco) {
    var produto_compra = document.createElement('a');
    produto_compra.classList.add('compra_efetuada');
    produto_compra.href = `#${id}`;

    //Atenção: Usar o id do produto para o href
    const Produto1 = document.getElementById(`${id}`);
    Produto1.style.scrollMargin = '500px';

    produto_compra.onclick = function() {
        var produto = document.getElementById(`${id}`);
        produto.style.backgroundColor = 'rgba(150, 195, 121, 0.6)';
        produto.style.transform = 'scale(1.03)';
        setTimeout(function() {
            produto.style.backgroundColor = '#D4EBC6';
            produto.style.transform = 'scale(1)';
        }, 300);
    }

    var nomeElement = document.createElement("p");
    nomeElement.innerText = nome;
    
    var quantidadeElement = document.createElement("p");
    quantidadeElement.innerText = quantidade + 'x';
    
    var precoElement = document.createElement("h1");
    precoElement.innerText = "R$ " + preco;

    produto_compra.appendChild(quantidadeElement);
    produto_compra.appendChild(nomeElement);
    produto_compra.appendChild(precoElement);

    const aba_produto_compras = document.getElementById('compras_efetuadas');
    aba_produto_compras.appendChild(produto_compra);
    novoValorTotal();
}


//Pegar anotação no notion spbre formatação na moeda 'REAL'.
// Função para extrair os dados de cada elemento e chamar novoProduto
function adicionarProdutosDaTabela() {
    // Obtém todos os elementos com a classe "produto_compra"
    var elementosProdutos = document.querySelectorAll('.produto_compra');
    
    // Itera sobre os elementos
    elementosProdutos.forEach(function(elemento) {
        // Extrai os dados do elemento atual
        var id = elemento.id;
        var nomeProduto = elemento.querySelector('p').innerText;
        var quantidadeProduto = elemento.querySelector('#quantidade').innerText;
        var precoProduto = elemento.querySelector('h1').innerText;
        
        // Remove o "R$" do preço e converte para número
        precoProduto = parseFloat(precoProduto.replace('R$ ', '').replace(',', '.'));
        quantidadeProduto = parseInt(quantidadeProduto);
        precoProduto = precoProduto * quantidadeProduto;
        // Chama a função novoProduto para adicionar o produto à tabela
        //Arredondar preço produto para duas casas decimais
        precoProduto = precoProduto.toFixed(2);
        novoProduto(id, nomeProduto, quantidadeProduto, precoProduto);
    });
}

// Exemplo de chamada da função adicionarProdutosDaTabela
function novoValorTotal()
{
    const total = document.getElementById('total');
    var valor_total = 0;

    const compras_efetuadas = document.querySelectorAll('.compra_efetuada > h1');
    compras_efetuadas.forEach(element => {
        var texto_valor = element.innerText;
        texto_valor = texto_valor.replace('R$ ', ''); // Remove 'R$ '
        texto_valor = texto_valor.replace(',', '.');  // Substitui a vírgula por um ponto
        valor_total += (parseFloat(texto_valor));
        valor_total = valor_total.toFixed(2);
    });
    total.innerText = `R$ ${valor_total}`;
}


document.addEventListener("DOMContentLoaded", function() {
    adicionarProdutosDaTabela();

    const produtos_compra = document.querySelector('#produtos_compra');
    const compra_total = document.querySelector('#compra_total');
    produtos_compra.style.maxHeight = `${compra_total.offsetHeight - 100}px`;
});