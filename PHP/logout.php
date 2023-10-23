<?php
    session_start();
    //Apagando o token do banco de dados
    include("sessao.php");
    $conn = coneccao();
    $token = $_SESSION['token'];
    $sql = "DELETE FROM tbl_token WHERE token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":token", $token, PDO::PARAM_STR);
    $stmt->execute();

    $conn = null;
    $stmt = null;


    $_SESSION['conectado'] = false; //Talvez desnecessario, o de baixo tbm
    $_SESSION['adm'] = false;
    $_SESSION['token'] = null;
    $_SESSION['cod_usuario'] = null;

    $_SESSION = array(); //Limpa o array de sessão (acho que ja faz todos os outros acima)
    setcookie('token', null, time() - 1, '/projetoscti14'); //necessario para o logout (o unset não funciona)
    unset($_COOKIE['token']); //Não parece estar funcionando...


    session_destroy();
          
    header('Location: ../');     

?>