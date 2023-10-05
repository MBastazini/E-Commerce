<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    include("caixa.php");

    if (isset($_SESSION['conectado'])) {
    $conec = $_SESSION['conectado'];
    } 
    else{        
        $conec = false;
    }

    if (isset($_SESSION['conectado'])) {
        $conec = $_SESSION['conectado'];
        } 
        else{        
            $conec = false;
        }

    if($conec){
        header('Location: minhaconta.php');
    }
    else{
        header('Location: login.html');
    }

?>