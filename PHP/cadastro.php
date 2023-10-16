<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start(); 
    $session_id = session_id();       

    include("caixa.php");
    
    $conn = coneccao();
    $email = $_POST['email'];
    $sql_email = "select * from tbl_usuario where email = :email";

    $select = $conn->prepare($sql_email);
    $select->execute(['email' => $email]);
    $resultado = $select->fetch();
    if ($resultado == NULL)
    {
        //Não possui uma conta cadastrada com esse e-mail
        $senha = $_POST['senha'];
        $csenha = $_POST['senha_c'];

        if($senha == $csenha){
            $linha = [ 
                'nome'      => $_POST['nome'],   
                'email'     => $_POST['email'],
                'telefone'  => $_POST['telefone'], 
                'senha'     => $_POST['senha']
            ];


            $sql = " insert into tbl_usuario (nome,email,telefone,senha)  
                        values (:nome,:email,:telefone,:senha) ";

            $inclui = $conn->prepare($sql); 
            $inclui->execute($linha);

            setToken($resultado['cod_usuario']);
            $_SESSION['nome'] = explode(" ", $linha['nome'])[0];
            $_SESSION['conectado'] = true;
            
            $sql_user = "select cod_usuario from tbl_usuario where email = :email and senha = :senha";
            $select2 = $conn->prepare($sql_user);
            $select2->execute(['email' => $linha['email'], 'senha' => $linha['senha']]);
            $resultado2 = $select2->fetch();
            $_SESSION['cod_usuario'] = $resultado2['cod_usuario'];
            $_SESSION['adm'] = false;

            header('Location: ../index.html');
        }
        else{
            header('Location: ../sobre.html');
        }
    }
    else{
        //Esse e-mail já possui conta
        header('Location: ../carrinho.html');
    }

                /*$check = 0;
                
                $cod = "";

                while ($var = $select->fetch() )  
                {
                    $varEmail  = $var['email'];
            
                    if($varEmail == $_POST['email'] ){
                        $cod = $var['cod_usuario'];
                        $check = 1;
                    }
                }

                if($check == 1 ){
                    echo "html com caixa q ja tem conta";
                    sleep(2);
                    header('Location: ../login.html');
                }
                else{

                    


                    
                    
                }
                

                /*
            // Obter senha
            $senha = 'user-input-pass';

            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            }else{
                echo 'Strong password.';
            } */
?>
