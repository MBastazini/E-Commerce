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

    <?php 
        barraNavegacao('', '../');
    ?>

    <div id="crud" class="container usuario">

        <?php 
        
        $user = CheckUser();
        if ($user == 1)
        {
            if ($_SESSION['usuario']['adm'])
            {
                echo '<a id="btn_crud_produtos" class="cruds" href="./">Voltar</a>';
                $usuarios = tblUsuario(1);
                foreach($usuarios as $usuario)
                {

                    echo '<div class="elemento" id="';
                    echo'">
                            <div class="info">
                                <div>
                                    <p>Nome</p>
                                    <h1>'.$usuario->getNome().'</h1>
                                </div>
                                
                                <div>
                                    <p>E-mail</p>
                                    <h1>'.$usuario->getEmail().'</h1>
                                </div>
                                <div>
                                    <p>Telefone</p>
                                    <h1>'.$usuario->getTelefone().'</h1>
                                </div>
                                <div>
                                    <p>Senha</p>
                                    <h1>'.$usuario->getSenha().'</h1>
                                </div>
                                <div>
                                    <p>Codigo</p>
                                    <h1>'.$usuario->getCodUsuario().'</h1>
                                </div>
                                
                                <form action="../PHP/insereDadosUsuario.php" method="post">

                                    <input type="hidden" name="cod_usuario" value="'.$usuario->getCodUsuario().'">
                                    <input type="hidden" name="funcao" value="del_user">
                                    <button type="submit" name="excluir" value="1">
                                        <img src="../Icones/delete.svg">
                                        Excluir
                                    </button>

                                </form>

                            </div>
                    </div>';
                }
            }
        }
        else{
            echo "<h1>Você não tem permissão para acessar essa página!</h1>";
        }
        ?>

    </div>

    <?php 
        Footer('../', '#crud');
    ?>
</body>
</html>