<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    include("caixa.php");
    
    $conn = coneccao();

    $sql1 = "select * from tbl_usuario order by email ";

    $select = $conn->query($sql1);

    $checa = 0;

    while ($var = $select->fetch() )  
    {
        $varEmail  = $var['email'];
 
        if($varEmail == $_POST['email']){
            $checa = 1;
        }
    }

    if($checa == 1){
        echo "html com caixa q ja tem conta";
        sleep(5);
        header('Location: login.html');
    }
    else{

        $linha = [ 
                    'nome'      => $_POST['nome'],   
                    'email'     => $_POST['email'],
                    'telefone'  => $_POST['telefone'], 
                    'senha'     => $_POST['senha']];


        $sql = " insert into tbl_usuario (nome,email,telefone,senha)  
                    values (:nome,:email,:telefone,:senha) ";

        $inclui = $conn->prepare($sql); 
        $inclui->execute($linha);

        $sql2 = "select * from tbl_usuario order by email where email = $varEmail";
        $select2 = $conn->query($sql2);

        $var2 = $select2->fetch();
        
        Cookie('login', $var2['cod_usuario'], 1440);
        sessao($var2['cod_usuario']);

        header('Location: index.html');   
    }
      

?>
