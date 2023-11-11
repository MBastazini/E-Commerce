<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">
    <title>Tiny Wood</title>
</head>
<body>
    <script src="../JS/conta.js" defer></script>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/login.js" defer></script>
    <script src="../JS/compras.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    <section class="container" id="conta">
        <h1>Sua conta</h1>
        <h2>
            <?php 
            $user = CheckUser();
            if($user == 1)
            {
                $usuario = tblUsuario();
                $nome = $usuario[0] -> getNome();
                echo $nome;
            }
            else{
                header('Location: ../');
            }
            ?>
        </h2>
        <form action="../PHP/insereDadosUsuario.php" method="post" id="conta_form">
            <div class="edit_btn">
                <p>Editar informações</p>
                <img src="../Icones/edit.svg">
            </div>

            <div class="info_conta">
                <?php 
                $user = CheckUser();
                if($user == 1) {
                    $email = $usuario[0] -> getEmail();
                    $telefone = $usuario[0] -> getTelefone();
                    $senha = $usuario[0] -> getSenha();
                    $cod_usuario = $usuario[0] -> getCodUsuario();
                    echo"<div class='inp disabled'>
                    <input type='text' value='". $nome ."' disabled name='nome'>
                    <p>Nome</p>
                    </div>";

                    echo"<div class='inp disabled'>
                    <input type='email' value='". $email ."' disabled name='email'>
                    <p>E-Mail</p>
                    </div>";

                    echo"<div class='inp disabled'>
                    <input type='tel' value='". $telefone ."' disabled name='telefone'>
                    <p>Telefone</p>
                    </div>";

                    echo"<div class='inp disabled'>
                    <input type='password' value='". $senha ."' disabled name='senha'>
                    <p>Senha</p>
                    </div>";

                    echo"<input type='hidden' value='". $cod_usuario ."' name='codigo'>";   
                }   
                else{
                    header('Location: ../');
                }
                    
                ?>
            </div>
            <input type="hidden" name="funcao" value="edit">
            <input type="submit" value="Salvar alterações" id="btn_submit">
        </form>
        <a href="../PHP/logout.php">
            <div class="edit_btn" id="logout">
                <p>LOGOUT</p>
                <img src="../Icones/logout_branco.svg">
            </div>
        </a>
        
        <?php 

        if($user == 1)
        {
            if ($_SESSION['usuario']['adm'])
            {
                echo "<div id='administrador'>
                <h1 id='area-adm'>| Opções de administrador</h1>
                <div id='area_adm'>
                    <a href='crudProdutos.php'>
                        <div class='edit_btn' id='CRUD'>
                            <p>Tabela de produtos</p>
                            <img src='../Icones/config.svg'>
                        </div>
                    </a>
                    <a href='crudUsuarios.php'>
                        <div class='edit_btn' id='CRUD'>
                            <p>Tabela de usuarios</p>
                            <img src='../Icones/config.svg'>
                        </div>
                    </a>
                    <a href='relatorios.php'>
                        <div class='edit_btn' id='CRUD'>
                            <p>Relatorios de vendas</p>
                            <img src='../Icones/report.svg'>
                        </div>
                    </a>
                </div>
                <h1 id='area-adm'>|</h1>
                </div>";
            }
        }
        
        ?>

        <h1>Informações de compras efetuadas</h1>
        <div id="info_c_h">
            <p>Mais</p>
            <p>Código</p>
            <p>Status</p>
            <p>Data efetuada</p>
            <p>Valor total</p>
        </div>
        <div id="info_compra">
            
        <?php 
        
        $compras = tblCompra();
        foreach ($compras as $compra)
        {
            $cod_compra = $compra -> getCodCompra();
            $status = $compra -> getStatus();
            $data_compra = $compra -> getDataCompra();
            $valor_total = $compra -> getValorTotal();
            echo"
            <div class='compra'>
                <img src='../Icones/Down_preto.svg'>
                <p>". $cod_compra ."</p>
                <p>". $status ."</p>
                <p>". $data_compra ."</p>
                <p>R$ ". $valor_total ."</p>
                <div>
                    <div id='info_c_h' class='inside'>
                        <p>Nome</p>
                        <p>Preco</p>
                        <p>Quantidade</p>
                        <p>Codigo</p>
                    </div>
                    <div id='info_compra' class='inside'>
                        ";
                            $produtos = $compra->getCompras();
                            foreach($produtos as $produto)
                            {
                                $nome = $produto -> getNome();
                                $preco = $produto -> getPreco();
                                $quantidade = $produto -> getQuantidade();
                                $cod_produto = $produto -> getCodProduto();
                                echo" 
                                <div>
                                    <p>". $nome ."</p>
                                    <p>". $preco ."</p>
                                    <p>". $quantidade ."</p>
                                    <p>". $cod_produto ."</p>
                                </div>";
                            }
                            
                        echo"
                    </div>
                </div>
            </div>";   
        }
        

        ?>
        </div>
        <h1>Sessões ativas</h1>
        <div id="info_c_h" class="token">
            <p>Data da criação</p>
            <p>Deletar / Apagar sessão</p>
        </div>
        <div id="info_compra" class="token">    
            <?php 
            $tokens = tblToken();
            foreach ($tokens as $token)
            {
                $data_criacao = $token -> getDataCriacao();
                $cod_token = $token -> getCodToken();
                echo"
                <div> 
                <p>". $data_criacao ."</p>
                <form action='../PHP/insereDadosUsuario.php' method='post' id='form-token'>
                    <input type='hidden' name='funcao' value='deltoken'>
                    <button type='submit' name='id' value='". $cod_token ."'>
                        <p>DELETAR</p>
                    </button>
                </form>
                </div>";   
            }
                     
            ?>
        </div>
    </section>

    <?php 
        Footer('../', '#conta');
    ?>
    
    <!--<footer>
        <div class="tela_scroll_down up">
            <a href="#telaInicio" class="a"> 
                <h1>Voltar ao topo</h1> 
                <img src="../Icones/arrow.svg">
            </a>
        </div>
        <div id="f_1"></div>
        <div id="f_2"></div>
        <div id="f_3"></div>
        <div id="f_4"></div>
        <div id="f_5"></div>

        <div class="footer_logo">
            <img src="../Icones/logo-bola-branco.svg" alt="Logo da Tiny Wood">
            <div class="footer_logo_info">
                <h1>TINY WOOD</h1>
                <p>Alguimas informaçoes pq eu vi num lugar e 
                    vou colocar
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vo
                luptate quidem distinctio rerum assumenda quae aut, dicta c</p>
                <div class="footer_logo_info_mais">
                    <div class="footer_logo_info_mais_botao" value="1"></div>
                    <div class="footer_logo_info_mais_botao" value="2"></div>
                    <div class="footer_logo_info_mais_botao" value="3"></div>

                </div>
            </div>
        </div>

        <div class="copyright">
            <p>All copyrights to &copy; TinyWood</p>
        </div>
        <div class="footer_info">
            <div class="footer_div">
                <h1>Desenvolvedores</h1>
                <a href="sobre.html#leticia"><p>Leticia Garcia | N° 21</p></a>
                <a href="sobre.html#luiz"><p>Luiz Felipe | N° 22</p></a>
                <a href="sobre.html#mariana"><p>Mariana Senger | N° 23</p></a>
                <a href="sobre.html#mateus"><p>Mateus Bastazini | N° 24</p></a>
                <a href="sobre.html#matheus"><p>Matheus Trentini | N° 25</p></a>
            </div>
            <div class="footer_div">
                <h1>Contato</h1>
                <a><p>E-mail</p></a>
                <a><p>Telefone</p></a>
                <a><p>sla1</p></a>
                <a><p>sla2</p></a>
            </div>
            <div class="footer_div">
                <h1>Contato</h1>
                <a><p>E-mail</p></a>
                <a><p>Telefone</p></a>
                <a><p>sla1</p></a>
                <a><p>sla2</p></a>
            </div>
        </div>
    </footer> -->
    </body>
</html>