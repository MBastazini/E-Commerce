<?php 

include "caixa.php";

$conn = coneccao();

echo "<form name='formSenha' method='post' action=''>
       Email<br>
       <input type='text' name='email' size=30 '>
       <input type='submit' value='Enviar'>
      </form>";

if ($_POST)  {
   
   echo "<br>Recuperando a senha...";    
   $NovaSenha = GeraSenha();
   $email = $_POST['email'];
   echo "<br>Senha gerada: $NovaSenha";

   if (EnviaEmail ( $email, "Recuperacao de Senha",  "<html><body>Sua nova senha: <b>$NovaSenha</b></body></html>", "Suporte" ))  {

      if (ExecutaSQL($conn, "update usuarios set senha='$NovaSenha' where usuario='$email'" )) 
          {      
           echo "<br>Alterada com sucesso";   
          } 
          
       
   } else echo "<br>Erro ao enviar email";
}

?>