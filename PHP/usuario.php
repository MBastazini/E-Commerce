<?php 
    //Eu acho que nem uso mais esse arquivo
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

    if (isset($_SESSION['adm'])) {
        $adm = $_SESSION['adm'];
    } 
    else{        
        $adm = false;
    }

    if($conec){
        if($adm){
            header('Location: admconta.php');
        }
        else{
            header('Location: minhaconta.php');
        }
    }
    else{
        header('Location: ../login.html');
    }

?>