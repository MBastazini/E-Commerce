<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("caixa.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["deletar"];
        deletaToken($id);
    }
    header('Location: ../conta.php')
?>