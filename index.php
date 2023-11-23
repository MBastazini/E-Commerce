<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("PHP/caixa.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="icon" type="image/x-icon" href="Icones/logo-bola-verde.svg">
    <title>Tiny Wood</title>
</head>

<body>
    <script src="JS/home.js" defer></script>
    <script src="JS/index.js" defer></script>

    <?php
    barraNavegacao('home', '');
    ?>
    <section id="telaInicio">
        <div class="tela_inicial_flex">
            <div id="gradiente"></div>
            <div class="tela_inicial container">
                <div class="texto_inicial">
                    <h1>Chaveiros</h1>
                    <div class="tela_madeira">
                        <div class="tela_verde_esquerda">
                        </div>
                        <h1 class="hidden">_</h1>
                    </div>
                    <p>Adquira já! Uma lembrança única com um estilo natural,
                        ideal para todos os lugares, <br> Tiny Wood, chaveiros de madeira!
                    </p>
                    <a href="Produtos">
                        <div class="tela_botao">
                            <p>GARANTA O SEU!</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="tela_scroll_down">
            <a href="#infos" class="a">
                <h1>Scrolle para mais</h1>
                <img src="Icones/arrow.svg">
            </a>
        </div>
    </section>
    <section id="infos">
        <div class="infos_c">
            <div class="info_bolinhas">
                <div id="bola_ativa"></div>
                <div style="order: 1;"></div>
                <div></div>
            </div>
            <div class="info01_container hidden">
                <div class="info01_1 inf1_e">
                    <img src="Imagens/tronco.jpg" alt="Imagem01">
                    <div class="info01_1_div">
                        <h1>Finalização</h1>
                        <p>Por fim, o chaveiro Tiny wood está finalizado!
                            Pronto para te conectar com a natureza em todos os momentos!</p>
                    </div>
                </div>
                <div class="info01_1 inf1_c">
                    <img src="Imagens/lixa.jpg" alt="Imagem02">
                    <div class="info01_1_div">
                        <h1>Recorte</h1>
                        <p>
                            A escolha cuidadosa da madeira é crucial para a qualidade do produto,
                            por isso confiamos à Urbanwood, que realiza uma extração ecologicamente sustentável.</p>
                    </div>
                </div>
                <div class="info01_1 inf1_d">
                    <img src="Imagens/folha.jpg" alt="Imagem03">
                    <div class="info01_1_div">
                        <h1>Acabamento</h1>
                        <p>
                            após cortada, a peça de madeira será lixada, uma etapa essencial para realçar a textura e
                            dar seu acabamento,
                            furada, gravada à laser na FabLab com nossos designs e por fim tratadas com óleo mineral.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="info_video container">
            <div id="risco"></div>
            <div class="video_texto">
                <h1>Os chaveiros</h1>
                <p>A madeira é um material naturalmente belo, reflete a perfeição na
                    simplicidade, cada peça com um tom e textura única para você!
                    Oferecemos uma lembrança material acessível que te conecta com a natureza,
                    juntamente de nossas identidades visuais para encantar os nossos chaveiros!
                </p>
            </div>
            <div class="video_v">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/Kz1i3PdUyyc?si=XXZGf6NJxd8r4pWN"
                    title="YouTube video player" frameborder="0" allow="accelerometer; 
                autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>

        </div>
    </section>

    <section class="produtos">
        <div class="titulo t_esquerda hidden">
            <p id='hrefprod'>PRODUTOS</p>
        </div>
        <div class="area_produtos container">
            <p>Passe o mouse por cima para mais informações</p>
            <div class="produtos_container hidden">
                <span id="produto_padding"></span>
                <?php
                $produtos = tblProduto();

                foreach ($produtos as $produto) {
                    $excluido = $produto->getExcluido();
                    if (!$excluido)
                    {
                        $estoque = $produto->getEstoque();
                        if ($estoque > 0)
                        {
                            $cod_produto = $produto->getCodProduto();
                            $nome = $produto->getNome();
                            $preco = $produto->getPreco();
                            $imagem = $produto->getImagem();
    
                            if (estaNoCarrinho($cod_produto)) {
                                $icone = 'Check_branco.svg';
                                $funcao = 'ver';
                            } else {
                                $icone = 'carrinho_branco.svg';
                                $funcao = 'add++';
                            }
                            echo "<div class='produto'> 
                                    <div class='produto_info'>
                                        <div class='produto_texto'>
                                            <p> R$ " . $preco . "</p>
                                            <h1>" . $nome . "</h1>
                                            <h2>$imagem</h2>
                                        </div>
                                        <div class='produto_botao'>
                                            <form action='confirmarCompra.php' method='post'>
                                                <input type='hidden' name='cod_produto' value='" . $cod_produto . "'>
                                                <input type='hidden' name='tipo' value='2'>
                                                <button>
                                                    <img src='Icones/shopping_branco.svg' alt='Carrinho de compras'>
                                                    <p>Comprar</p>
                                                </button>
                                            </form>
                                            <form action='PHP/insereDadosCarrinho.php' method='post'>
                                                <input type='hidden' name='cod_produto' value='" . $cod_produto . "'>
                                                <input type='hidden' name='funcao' value='$funcao'>
                                                <button onclick='addCart()'>
                                                    <img src='Icones/$icone' alt='Carrinho de compras'>
                                                    <p>+ Carrinho</p>
                                                </button>
                                            </form>
                                            <a href='Produtos/index.php#" . $cod_produto . "'>
                                                <div>
                                                    <img src='Icones/sobre_branco.svg' alt='Carrinho de compras'>
                                                    <p>Ver mais</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>";    
                        }
                        
                        }
                        
                }

                ?>
                <span id="produto_padding"></span>
            </div>
        </div>
    </section>
    <section class="ler_mais">
        <div class="titulo t_direita">
            <p>SOBRE NÓS</p>
        </div>
        <div class="sobre container">
            <h1>A TINY WOOD</h1>
            <p>A Tiny Wood é uma empresa LTDA que se dedica à produção de chaveiros de madeira
                feitos artesanalmente. Procedendo nossos recursos,
                procedimentos e resultados aos segmentos do produto final, articulando nossa conformidade com a natureza


            </p>
        </div>
    </section>
    <?php
    Footer('', '#telaInicio');
    ?>
</body>

</html>