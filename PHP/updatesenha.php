<?php

include "caixa.php";

$conn = coneccao();

    $email=$_POST['email'];
    $novasenha=$_POST['novasenha'];
    $linha = [
        'senha' => $novasenha,
        'email' => $email
    ];
    echo $linha['senha'];
    echo $linha['email'];
    $sql= "update tbl_usuario set senha = :senha where email=:email";
    $update = $conn->prepare($sql);
    $update->execute($linha);
    echo "SShreguirehuigerjo";

?>