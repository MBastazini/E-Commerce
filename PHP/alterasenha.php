<?php

include "caixa.php";

$conn = coneccao();
$email = $_GET['email'];
$sql = "select senha from tbl_usuario where email = $email";

$senha=$conn->prepare($sql);
$sen = $senha->execute();


echo"
<form action='' method='post'>
    <input type='text' value='$sen' name='novasenha'>
    <input type='submit'>
</form>
";


if(isset($_POST)){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $novasenha = $_POST['novasenha'];

       $sql2 = "update tbl_usuario set senha= $novasenha where email=$email";
    }
 }
?>