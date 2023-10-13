<?php 
  function coneccao ($para = "")  
  {
    if ($para == "") {
        $para="pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
                 password=721526";
    }

    $Conn = new PDO($para);

    if (!$Conn) {  
        echo "Nao foi possivel conectar";
    } else { return $Conn; }
  }
  
  function inicioSessao(){
    if (isset($_COOKIE['sessao'])) {
        session_id($_COOKIE['sessao']);
        
    } 
    session_start();
    
  }


  function Login ($login, $senha, &$adm)  
  {
   $adm = ($login == 'tinywoodcti@gmail.com' and $senha == 'LLMMM2023');
   return true; 
  }

  function Cookie($nome, $valor, $min) 
  {
      setcookie($nome, $valor, time() + $min * 60, '/projetoscti14'); 
  }

  function usuarioNavegacao()
  {
    $conectado = false;
    if (isset($_SESSION['conectado'])){
        $conectado = $_SESSION['conectado'];
    }

    if ($conectado)
    {
      if ($_SESSION['adm'])
      {
        echo "<a href='PHP/usuario.php'>
        <div class='nav_info_lateral logged_adm'>
            <img class='nav_icon2' src='Icones/User-adm.svg'>
            <p> Administrador </p>
        </div>";
      }
      else{
        echo "<a href='PHP/usuario.php'>
        <div class='nav_info_lateral logged'>
            <img class='nav_icon2' src='Icones/User-branco.svg'>
            <p>". $_SESSION['nome'] ."</p>
        </div>";
      }   
    }
    else{
        echo "<a href='PHP/usuario.php'>
        <div class='nav_info_lateral'>
            <img class='nav_icon2' src='Icones/login_preto.svg'>
            <p>LOGIN</p>
        </div>
    </a>";
    }
  }






  function EnviaEmail ( $pEmailDestino, $pAssunto, $pHtml, $pRemetente )   
  {
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
   
   require "PHPMailer/PHPMailerAutoload.php";
      
   try {
  
   //cria instancia de phpmailer
   echo "<br>Tentando enviar para ".$pEmailDestino."...";
   $mail = new PHPMailer(); 
   $mail->IsSMTP();  
   
   // servidor smtp
   //$mail->SMTPDebug = SMTP::DEBUG_SERVER;   // use se tiver problemas, ele lista toda a transacao com o servidor
   $mail->Host = "smtp....";
   $mail->SMTPAuth = true;      // requer autenticacao com o servidor                         
   $mail->SMTPSecure = 'tls';                            
       
   $mail-> SMTPOptions = array (
     'ssl' => array (
     'verificar_peer' => false,
     'verify_peer_name' => false,
     'allow_self_signed' => true ) );
       
   $mail->Port = 587;      
      
   $mail->Username = "...@..."; 
   $mail->Password = "..."; 
   $mail->From = "...@..."; 
   $mail->FromName = "Suporte de senhas"; 
   
   $mail->AddAddress($pEmailDestino, "Usuario"); 
   $mail->IsHTML(true); 
   $mail->Subject = "Nova Senha !"; 
   $mail->Body = $pHtml;
   $enviado = $mail->Send(); 
       
   if (!$enviado) {
      echo "<br>Erro: " . $mail->ErrorInfo;
   } else {
      echo "<br><b>Enviado!</b>";
   }
   return $enviado;         
       
   } catch (phpmailerException $e) {
     echo $e->errorMessage(); // erros do phpmailer
   } catch (Exception $e) {
     echo $e->getMessage(); // erros da aplicação - gerais
   }       
   
  }




  function ExecutaSQL( $paramConn, $paramSQL ) 
  {
   $linhas = $paramConn->exec($paramSQL);
   
   if ($linhas > 0) { 
       return TRUE; 
   } else { 
       echo "<br><b>Erro SQL:</b>".$paramConn->errorInfo()."<br>";
       return FALSE; 
   }  
  }   
  



  
  function GeraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
  {
  //$lmin = 'abcdefghijklmnopqrstuvwxyz';
  $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num = '1234567890';
  $simb = '!@#$%*-';
  $retorno = '';
  $caracteres = '';
  
  //$caracteres .= $lmin;
  if ($maiusculas) $caracteres .= $lmai;
  if ($numeros) $caracteres .= $num;
  if ($simbolos) $caracteres .= $simb;
  
  $len = strlen($caracteres);
  for ($n = 1; $n <= $tamanho; $n++) {
  $rand = mt_rand(1, $len);
  $retorno .= $caracteres[$rand-1];
  }
  return $retorno;
  }

  

?>