

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
    <h5>

            <?php 
            ini_set ( 'display_errors' , 1); 
            error_reporting (E_ALL);
            include("../PHP/caixa.php");

            
            function getRandomStringBin2hex($length = 16)
            {
                if (function_exists('random_bytes')) {
                    $bytes = random_bytes($length / 2);
                } else {
                    $bytes = openssl_random_pseudo_bytes($length / 2);
                }
                $randomString = bin2hex($bytes);
                return $randomString;
            }

            /*session_start();
            if (isset($_SESSION['esqueci_codigo']))
            {
                $codigo = $_SESSION['esqueci_codigo'];
            }
            else{
                header('./');
            }

            if (isset($_SESSION['esqueci_email']))
            {
                $email = $_SESSION['esqueci_email'];
            }
            else{
                header('./');
            }*/

            $enviado = false;
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (isset($_POST['esqueci']))
                {
                    $esqueci_email = $_POST['email'];
                    //Gera um codigo aleatorio
                    $codigo = getRandomStringBin2hex(6);

                    session_start();
                    $_SESSION['esqueci_email'] = $esqueci_email;
                    $_SESSION['esqueci_codigo'] = $codigo;
                    $mns =  "Enviando e-mail...";
                    enviaemail($esqueci_email, $codigo);
                }
                else if (isset($_POST['enviado']))
                {
                    session_start();

                    $esqueci_codigo = $_SESSION['esqueci_codigo'];
                    unset($_SESSION['esqueci_codigo']);

                    $codigo_enviado = $_POST['codigo'];
                    if ($codigo_enviado == $esqueci_codigo)
                    {
                        $enviado = true;
                    }
                    else{
                        header('Location: ../');
                    }
                }
                else{
                    unset($_SESSION['esqueci_email']);
                    header('Location: ../');
                }
                
            }
            else{
                unset($_SESSION['esqueci_email']);
                header('Location: ../');
            } 
        ?>

    </h5>

    <?php 
    if (!$enviado)
    {
        echo"
        <section class='container' id='esqueci'>
            <form action='' method='post'>    
            <div class='inp'>
                <input type='text' name='codigo' maxlength='40'>
                <p>Digite o codigo enviado ao seu e-mail</p>
            </div>
            <input type='hidden' name='enviado' value='1'>
            <div class='btn'>
                <input type='submit' value='Validar código'>
            </div>
            </form>
        </section>";
    }
    else{
        echo'<section id="nova_Senha" class="container">
            <form action="../PHP/esqueci_AlteraSenha.php" method="post">
                <div class="inp">
                    <input type="password" name="senha" maxlength="40">
                    <p>Digite sua nova senha</p>
                </div>
                <div class="inp">
                    <input type="password" name="novasenha" maxlength="40">
                    <p>Confirme sua nova senha</p>
                </div>
                <div class="btn">
                    <input type="submit" value="Alterar senha">
                </div>
            </form>
        </section>';
    }
    ?>
    
    
</body>
</html>