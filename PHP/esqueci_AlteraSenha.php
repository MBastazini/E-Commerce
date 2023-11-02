<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include "caixa.php";

    $conn = coneccao();
    session_start();

    if(isset($_SESSION['esqueci_email']))
    {
        $email = $_SESSION['esqueci_email'];
        unset($_SESSION['esqueci_email']);
    }
    else{
        header('Location: ../Login');
    }

    $senha = $_POST['senha'];
    $novasenha = $_POST['novasenha'];
    if ($senha != $novasenha)
    {
        unset($_SESSION['esqueci_email']);
        header('Location: ../Login');
    }

    //echo "NOVASENHA: $novasenha";
    //echo "EMAIL: $email";
    $sql = "UPDATE tbl_usuario SET senha = :senha WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":senha", $novasenha, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt -> execute();
    header("Location: ../Login?erro=3");

    $conn = null;
    $stmt = null;
}
else{
    header('Location: ../Login');
}

?>