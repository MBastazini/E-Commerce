<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        
    $session_id = session_id();
    
    include("PHP/caixa.php");
    
    $conn = coneccao();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_email = "select * from tbl_usuario where email = :email";

    $select = $conn->prepare($sql_email);
    $select->execute(['email' => $email]);
    $resultado = $select->fetch();
    if ($resultado == NULL)
    {
        header('Location: ../Login/index.php?erro=1');
    }
    else{
        $linha = [
            'email' => $email,
            'senha' => $senha
        ];
        $sql_senha = "select * from tbl_usuario where email = :email and senha = :senha";
        $select2 = $conn->prepare($sql_senha);
        $select2->execute($linha);
        $resultado2 = $select2->fetch();
        if ($resultado2 == NULL)
        {
            header('Location: ../Login/index.php?erro=2');
        }
        else{
            //Login efetuado com sucesso.

            if (isset($_POST['lembrar']))
            {
                setToken($resultado2['cod_usuario']);
            }
            $_SESSION['nome'] = explode(" ", $resultado2['nome'])[0];
            $_SESSION['conectado'] = true;
            echo $_SESSION['conectado'];
            $_SESSION['cod_usuario'] = $resultado2['cod_usuario'];
            if ($resultado2['cod_usuario'] == 0)
            {
                $_SESSION['adm'] = true;
            }
            else{
                $_SESSION['adm'] = false;
            }
            //header('Location: ../');
        }
    }
    /*$check = 0;

    while ($var = $select->fetch() )  
    {
        $varEmail  = $var['email'];
        $varSenha = $var['senha'];
        $varCod = $var['cod_usuario'];

        if($varEmail == $email AND $varSenha != $senha){
            $check = 1;
        }

        if($varEmail == $email AND $varSenha == $senha){
            $check = 2;
            $varEmail = $var['email'];
            $varSenha = $var['senha'];

            

            echo "Caixa com confirmacao de login......";
            header('Location: ../index.html'); 
            break;
        }
    }

    if($check == 0){
        echo "html com caixa q NAO tem conta......";
        header('Location: ../cadastro.html');
    }
    
    if($check == 1){
        echo "html com caixa senha incorreta";
        header('Location: ../login.html');
    }*/
?>
