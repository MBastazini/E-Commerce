<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");

    if (!$_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['enviado']))
        {
            $enviado = true;
        }
        else{
            $enviado = false;
        }

        if ((!isset($_POST['codigo'])) || (!isset($_POST['email'])))
        {
            header('Location: ./');
        }
    }
    $codigo = $_POST['codigo'];
    $email = $_POST['email'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../index.css">
        <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">
        <title>Esqueci a senha - Tiny Wood</title>
    </head>
<body>
    <script src="../JS/login.js" defer></script>
    <?php 
    
    if (!$enviado)
    {
        echo"<form action='' method='post'>
            <section class='container' id='esqueci'>
            <div class='inp'>
                <input type='text' name='codigo' maxlength='40'>
                <p>Digite o codigo enviado ao seu e-mail</p>
            </div>
            <div class='btn'>
                <input type='submit' value='Validar código'>
            </div>
            </section>
        </form>";
    }

    ?>
    
    <section id="nova_Senha" class="container">
        <form action="#">
            <div class="inp">
                <input type="password" name="senha" maxlength="40">
                <p>Digite sua nova senha</p>
            </div>
            <div class="inp">
                <input type="password" name="senha" maxlength="40">
                <p>Confirme sua nova senha</p>
            </div>
            <div class="btn">
                <input type="submit" value="Alterar senha">
            </div>
        </form>
    </section>
</body>
</html>