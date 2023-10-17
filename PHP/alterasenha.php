<?php

include "caixa.php";

$conn = coneccao();

$email = $_GET['email'];
echo $email;

echo"
<form action='updatesenha.php' method='post'>
    <input type='text' value='$email' name='email'>
    <input type='text' name='novasenha' placeholder='digite a nova senha...'>
    <input type='submit'>
</form>
";


?>