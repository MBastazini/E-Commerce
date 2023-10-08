<?php 
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("caixa.php");
   
   $conn = coneccao();

       $linha = [ 'varId' => $_GET['id'] ]; 

       $sql = " update tbl_produto set excluido='true' 
                where cod_produto = :varId
            "; 

       $delete = $conn->prepare($sql); 
       $delete->execute($linha);
   

   header('Location: admconta.php');     

?>