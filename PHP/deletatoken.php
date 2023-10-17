<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("caixa.php");

    $conn = coneccao();

    $deleta = $_POST['deletar'];

    $sql = "DELETE FROM tbl_token WHERE cod_token = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $deleta]);

    header('Location: ../conta.php')
?>