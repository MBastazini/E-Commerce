<?php

include "caixa.php";

$conn = coneccao();

$email = $_GET['email'];



echo"
<form action='' method='post'>
    <input type='text' name='novasenha' placeholder='digite a nova senha...'>
    <input type='submit'>
</form>
";


if(isset($_POST)){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $novasenha = $_POST['novasenha'];
        echo"$novasenha";
       $sql2 = "update tbl_usuario set senha = $novasenha where email = $email";
       $atualiza = $conn->prepare($sql2);
       $atualiza->execute();
    }
 }
?>