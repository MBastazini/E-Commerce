<?php 

include "caixa.php";

$conn = coneccao();
echo  "
   <form method='post' action=''>
   <input type='email' name='email' maxlength='100'>
   <input type='submit'>
   </form>
";


if(isset($_POST)){
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      echo"aaaa";
      enviaemail($email);
      echo "bbbb";

   }
}



?>