<?php
    session_start();
    $_SESSION['conectado'] = false;
    $_SESSION['adm'] = false;
    echo"caixa com texto bonitinho de até logo";
    sleep(2);
    header('Location: index.html');        
        

?>