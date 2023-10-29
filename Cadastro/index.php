<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");
    
    
    if (isset($_GET['erro']))
    {
        $erro = $_GET['erro'];
    }
    else{
        $erro = 0;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">

    <title>Cadastro - Tiny Wood</title>
</head>
<body>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/login.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    <section class="container sec_login" id="topo">
        <div class="cadastro tela_log_cad">
            <h1>CADASTRAR-SE</h1>
            <?php 
            if ($erro == 1)
            {
                echo "<p>Senhas não conhecidem! </p>";
            }
            else if ($erro == 2)
            {
                echo "<p>Esse e-mail já possui conta! </p>";
            }
            ?>

            <form action='../PHP/insereDadosUsuario.php' method='post'>
                <input type='hidden' name='funcao' value='cadastro'>
                <div class="nome inp">
                    <?php 
                     echo "<input type='text' name='nome' maxlength='80'>";
                    ?>
                    <p>Nome</p>
                </div>
                <div class="email inp">
                    <?php 
                        echo "<input type='email' name='email' maxlength='100'>";
                    ?>
                    <p>E-mail</p>
                </div>
                <div class="telefone inp">
                    <?php 
                        echo "<input type='tel' name='telefone' maxlength='13'>";
                    ?>
                    <p>Telefone</p>
                </div>
                <div class="senha inp">
                    <input type="password" name="senha" maxlength="40">
                    <p>Senha</p>
                </div>
                <div class="senha_c inp">
                    <input type="password" name="senha_c" maxlength="40">
                    <p>Confirmar senha</p>
                </div>
                <div class="lembrarme">
                    <input type="radio" name="lembrar" id="lembrar" value='1'>
                    <p>Lembrar-me</p>
                </div>
                <div class="btn">
                    <input type="submit" value="CADASTRE-SE">
                </div>
            </form>
                <div class="troca_log_cad">
                    <a href="../Login">
                    <p id="black_text">Já possuí uma conta?</p>
                    <p>Faça o login.</p>
                </a>
                </div>
        </div>
    </section>
    <?php 
        Footer('../', '#topo');
    ?>
</body>
</html>