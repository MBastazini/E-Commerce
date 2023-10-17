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
    if (isset($_COOKIE['token'])) {
        $check_token = "SELECT * FROM tbl_token WHERE token = :token";
        $sel_token = $conn->prepare($check_token);
        $sel_token->execute(['token' => $_COOKIE['token']]);
        $res_token = $res_token->fetch();

        if ($res_token != NULL)
        {
          $check_user = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
          $sel_user = $conn->prepare($check_user);
          $sel_user->execute(['cod_usuario' => $res_token['cod_usuario']]);
          $res_user = $sel_user->fetch();

          if ($res_user != NULL)
          {
              session_start();
              $_SESSION['conectado'] = true;
              if ($resultado2 != NULL)
              {
                $_SESSION['nome'] = explode(" ", $res_user['nome'])[0];
              }
              else{
                $_SESSION['nome'] = "Usuário";
              }
              $_SESSION['cod_usuario'] = $res_user['cod_usuario'];
              if ($resultado['cod_usuario'] == 0)
              {
                  $_SESSION['adm'] = true;
              }
              else{
                  $_SESSION['adm'] = false;
              }

              }
              else{
                  session_start();
                  $_SESSION['conectado'] = false;
              }
        }
        else{
          unset($_COOKIE['token']);
          session_start();
          $_SESSION['conectado'] = false;
        }
        
    } 
    else{
        session_start();
        $_SESSION['conectado'] = false;
    }
    
    return $_SESSION['conectado'];
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

  function setToken($cod_usuario)
  {
    $conn = coneccao();
    $token = rand(100000000, 999999999);
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date('Y-m-d');

    $linha = [
        'cod_usuario' => $cod_usuario,
        'token' => $token,
        'ip' => $ip,
        'data' => $data
    ];

    $sql = "INSERT INTO tbl_token (cod_usuario, token, ip_criacao, data_criacao) VALUES (:cod_usuario, :token, :ip, :data)";
    $insert = $conn->prepare($sql);
    $insert->execute($linha);
    Cookie('token', $token, 1440); //24 horas
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

  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';


  function enviaemail($destinatario/*, $senha*/){

    

     $mail = new PHPMailer(true);

     try {
        //Server settings
        $mail->SMTPDebug = 2; //Habilita o debug do SMTP
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.projetoscti.com.br';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tinywood@projetoscti.com.br';                     //SMTP username
        $mail->Password   = 'Tiny#wood2023';    
        $mail->SMTPSecure = 'tls'; 
        $mail->Port       = 587;     
        $mail-> SMTPOptions = array (
          'ssl' => array (
          'verificar_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true )); //Permite que o PHPMailer aceite certificados SSL não confiáveis                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     
        //Recipients
        $mail->setFrom('tinywood@projetoscti.com.br');
        $mail->addAddress($destinatario, 'Usuário');     
        $mail->addReplyTo('tinywood@projetoscti.com.br');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Caso envie para outra página com alteração de usuario: 
        $mail->isHTML(true);                                  
        $mail->Subject = 'Esqueci minha senha para o ecommerce tinywood';
        $mail->Body    = "<a href=http://200.145.153.91/luizsilva/Testes/PHP/alterasenha.php?email=".$destinatario.">Clique aqui para mudar sua senha</a>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


        $enviado = $mail->send();

        if ($enviado) {
          echo "E-mail enviado com sucesso!";
        } else {
          echo "Não foi possível enviar o e-mail.";
          echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
        }

        //Execeções da biblioteca PHPMailer e do PHP(Instaciamento da classe exception)
      } catch (Exception $e) {
        echo $e->errorMessage(); //mensagens de erro do PHPMailer 
      } catch (\Exception $e) {
        echo $e->getMessage(); //mensagens de erro do PHP
      }

  }



  

?>