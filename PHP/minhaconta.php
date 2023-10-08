<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    include("caixa.php");

    


    echo "
        <!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <title>Minha Conta</title>
        </head>
        <body>
        <form action='logout.php' method='post'>
        <input class='botao' type='submit' name='L1' value='LOGOUT'>
        </form>
        </body>
        </html>
    ";
   
    
    
    
    
?>
