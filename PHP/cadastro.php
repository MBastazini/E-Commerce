<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    include("caixa.php");
    
    $conn = coneccao();

    $sql1 = "select * from tbl_usuario order by email ";

    $select = $conn->query($sql1);

    $check = 0;
    $senha = $_POST['senha'];
    $csenha = $_POST['senha_c'];
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
        header('Location: login.html');
    }
    else{
        if($senha == $csenha){
            $linha = [ 
                'nome'      => $_POST['nome'],   
                'email'     => $_POST['email'],
                'telefone'  => $_POST['telefone'], 
                'senha'     => $_POST['senha']];


            $sql = " insert into tbl_usuario (nome,email,telefone,senha)  
                        values (:nome,:email,:telefone,:senha) ";

            $inclui = $conn->prepare($sql); 
            $inclui->execute($linha);

            Cookie('login', $cod, 1440);
            $_SESSION['conectado'] = sessao($cod);

            header('Location: index.html');
        }
        else{
            echo "caixa com erro de senha";
            header('Location: cadastro.html');
        }
           
    }
      

?>
