<?php    
  function barraNavegacao($tela, $src)
  {
     echo "<div class='nav_nav"; if ($tela == 'home'){echo" nav_sobe ";}  echo" container'>
        <div class='nav_fundo nf_fixo'></div>
        <a href='".$src."'><img src='".$src."Icones/logo-verde.svg' class='nav_logo' alt='Logo TINYWOOD'></a>


        <div class='nav_div_pesquisa'>
                <div class='nav_pesquisa'>
                    <img src='".$src."Icones/pesquisa_cinza.svg' class='nav_icon'>
                    <input type='text' placeholder='Pesquisar...'>
                </div>
                <div class='nav_p_resultados'>";
                    $conn = coneccao();
                    $sql = 'select * from tbl_produto';
                    $produtos = $conn->query($sql);
                    $a = 1;
                    while ($produto = $produtos->fetch())
                    {
                        echo "<a href='".$src."Produtos/index.php#".$produto['cod_produto']."'>";
                        echo "<div>";
                        echo "<p>".$produto['nome']."</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                echo"
                </div>
        </div>
        
        <img src='".$src."Icones/menu-hamburguer.svg' class='nav_tres_risco' alt='Mais opções'>
        <div class='nav_elementos'>
            <div class='nav_risco'></div>

            <a href='$src'>
              <div class='nav_home' id='"; if($tela == 'home') {echo "nav_botao_ativo";} echo"'>
                  <img class='nav_icon' src='".$src."Icones/home_"; echo ($tela == 'home') ? "branco" : "preto"; echo".svg'>
                  <p>HOME</p>
              </div>
            </a>
            <a href='".$src."Produtos'>
                <div class='nav_produtos' id='"; if($tela == 'produtos') {echo "nav_botao_ativo";} echo"'>
                    <img class='nav_icon' src='".$src."Icones/shopping_"; echo ($tela == 'produtos') ? "branco" : "preto"; echo".svg'>
                    <p>PRODUTOS</p>
                </div>
            </a>
            <a href='".$src."Sobre'>   
                <div class='nav_sobre' id='"; if($tela == 'sobre') {echo "nav_botao_ativo";} echo"'>
                    <img class='nav_icon' src='".$src."Icones/sobre_"; echo ($tela == 'sobre') ? "branco" : "preto"; echo".svg'>
                    <p>SOBRE</p>
                </div>
            </a>

            <a href='".$src."Carrinho'>
                <div class='nav_info_lateral' id='"; if($tela == 'carrinho') {echo "nav_botao_ativo";} echo"'>
                    <img class='nav_icon2' src='".$src."Icones/carrinho_"; echo ($tela == 'carrinho') ? "branco" : "preto"; echo".svg'>
                    <p>CARRINHO</p>
                </div>
            </a>
            <a href='PHP/usuario.php'>";
                  $a = '../';
                  if ($tela == 'home') {$a = '';}
                  usuarioNavegacao($a);   
            echo"</a>
        </div>
    </div>";
  }

  function Footer($src, $href)
  {
          echo "<footer>
          <div class='tela_scroll_down up'>
              <a href='".$href."' class='a'> 
                  <h1>Voltar ao topo</h1> 
                  <img src='".$src."Icones/arrow.svg'>
              </a>
          </div>
          <div id='f_1'></div>
          <div id='f_2'></div>
          <div id='f_3'></div>
          <div id='f_4'></div>
          <div id='f_5'></div>

          <div class='footer_logo'>
              <img src='".$src."Icones/logo-bola-branco.svg' alt='Logo da Tiny Wood'>
              <div class='footer_logo_info'>
                  <h1>TINY WOOD</h1>
                  <p>Alguimas informaçoes pq eu vi num lugar e 
                      vou colocar
                  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vo
                  luptate quidem distinctio rerum assumenda quae aut, dicta c</p>
                  <div class='footer_logo_info_mais'>
                      <div class='footer_logo_info_mais_botao' value='1'></div>
                      <div class='footer_logo_info_mais_botao' value='2'></div>
                      <div class='footer_logo_info_mais_botao' value='3'></div>

                  </div>
              </div>
          </div>

          <div class='copyright'>
              <p>All copyrights to &copy; TinyWood</p>
          </div>
          <div class='footer_info'>
              <div class='footer_div'>
                  <h1>Desenvolvedores</h1>
                  <a href='sobre.html#leticia'><p>Leticia Garcia | N° 21</p></a>
                  <a href='sobre.html#luiz'><p>Luiz Felipe | N° 22</p></a>
                  <a href='sobre.html#mariana'><p>Mariana Senger | N° 23</p></a>
                  <a href='sobre.html#mateus'><p>Mateus Bastazini | N° 24</p></a>
                  <a href='sobre.html#matheus'><p>Matheus Trentini | N° 25</p></a>
              </div>
              <div class='footer_div'>
                  <h1>Contato</h1>
                  <a><p>E-mail</p></a>
                  <a><p>Telefone</p></a>
                  <a><p>sla1</p></a>
                  <a><p>sla2</p></a>
              </div>
              <div class='footer_div'>
                  <h1>Contato</h1>
                  <a><p>E-mail</p></a>
                  <a><p>Telefone</p></a>
                  <a><p>sla1</p></a>
                  <a><p>sla2</p></a>
              </div>
          </div>
      </footer>";
  }



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
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    //echo $_SESSION['conectado'];
    if (isset($_SESSION['conectado']))
    {
        $conectado = $_SESSION['conectado'];
    }
    else{
        $conectado = false;
    }
    //echo $conectado;

    $conn = coneccao();
    if (!$conectado) //não funciona como todo o resto AAAAAA
    {
        if (isset($_COOKIE['token'])) {
            $_SESSION['token'] = $_COOKIE['token'];
            $check_token = "SELECT * FROM tbl_token WHERE token = :token";
            $res_token = executaSQL($check_token, ['token' => $_COOKIE['token']]);
            $res_token = $sel_token->fetch();
    
            if ($res_token != NULL)
            {
              $check_user = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
              $res_user = executaSQL($check_user, ['cod_usuario' => $res_token['cod_usuario']]);
              $res_user = $sel_user->fetch();
    
                if ($res_user != NULL)
                {
                    $_SESSION['conectado'] = true;
                    $conectado = true;

                    $_SESSION['usuario']['ativo'] = true;
                    $_SESSION['visitante']['ativo'] = false;

                    $_SESSION['usuario']['nome'] = explode(" ", $res_user['nome'])[0];
                    $_SESSION['usuario']['cod_usuario'] = $res_user['cod_usuario'];

                    if ($res_user['cod_usuario'] == 0)
                    {
                        $_SESSION['usuario']['adm'] = true;
                    }
                    else{
                        $_SESSION['usuario']['adm'] = false;
                    }
    
                }
                else{
                    //Há um codigo de usuario no token, mas esse usuario foi excluido, então o token é excluido
                    $_SESSION['conectado'] = false;
                    $conectado = false;
                    deletaToken($res_token['cod_token']);
                }
            }
            else{
                //Tinha o cookie mas o token foi excluido, apagando assim o cookie existente.
                setcookie('token', null, time() - 1, '/projetoscti14');
                unset($_COOKIE['token']); //acho que isso aq n funciona
                $_SESSION['conectado'] = false; 
                $conectado = false;
                //Esse conectado será usado posteriormente, se ele ainda estiver como false, significa que não foi
                //possivel recuperar uma sessão pelo token, e então ele abre a sessão de visitante.
            }
            
        } 
        else{
            $_SESSION['conectado'] = false; 
            $conectado = false;
        }  
        
    }

    //depois de ter passado por todo o codigo acima, o $conectado só retornará false se o usuario for usar a sessão de visitante
    if (!$conectado){
        $_SESSION['conectado'] = true;
        $_SESSION['usuario']['ativo'] = false;
        $_SESSION['visitante']['ativo'] = true;
    }
    //echo "SESSAO: "; echo ($_SESSION['conectado']) ? "true" : "false"; echo "<br>";
    return $_SESSION['conectado'];
  }

  function Cookie($nome, $valor, $min) 
  {
      setcookie($nome, $valor, time() + $min * 60, '/projetoscti14'); 
  }

  function setToken($cod_usuario)
  {
    $conn = coneccao();
    $token = session_id(); //Se falhar o token olhar aqui
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date('Y-m-d');

    $linha = [
        'cod_usuario' => $cod_usuario,
        'token' => $token,
        'ip' => $ip,
        'data' => $data
    ];

    $sql = "INSERT INTO tbl_token (cod_usuario, token, ip_criacao, data_criacao) VALUES (:cod_usuario, :token, :ip, :data)";
    executaSQL($sql, $linha);
    Cookie('token', $token, 1440); //24 horas
    $_SESSION['token'] = $token;
  }

  function usuarioNavegacao($src)
  {
    $conectado = inicioSessao();

    if ($conectado)
    {
      if ($_SESSION['usuario']['ativo'])
      {
        if ($_SESSION['usuario']['adm'])
        {
            echo "<a href='".$src."Conta'>
            <div class='nav_info_lateral logged_adm'>
                <img class='nav_icon2' src='".$src."Icones/User-adm.svg'>
                <p> Administrador </p>
            </div>";
        }
        else{
            echo "<a href='".$src."Conta'>
            <div class='nav_info_lateral logged'>
                <img class='nav_icon2' src='".$src."Icones/User-branco.svg'>
                <p>". $_SESSION['usuario']['nome'] ."</p>
            </div>";
        }
      } else if($_SESSION['visitante']['ativo'])
      {
        echo "<a href='".$src."Login'>
        <div class='nav_info_lateral'>
            <img class='nav_icon2' src='".$src."Icones/login_preto.svg'>
            <p>LOGIN</p>
        </div>
        </a>";
      }
    }

    //Se a sessão de usuario e visitante esta fechada, há algo de errado no codigo, o mesmo vale para
    //se $conectado for false.
  }

    function deletaToken($id){
        $conn = coneccao();
        $sql = "DELETE FROM tbl_token WHERE cod_token = :id";
        executaSQL($sql, ['id' => $id]);
    }
  function executaSQL($sql, $linha)
  {
        $conn = coneccao();
        $insert = $conn->prepare($sql);
        $insert->execute($linha);
        return $insert;
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


  function gerapdf($html){
    require('FPDF/fpdf.php');

    class pdf extends FPDF
        {
        protected $B = 0;
        protected $I = 0;
        protected $U = 0;
        protected $HREF = '';

        function WriteHTML($html)
        {
            // HTML parser
            $html = str_replace("\n",' ',$html);
            $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    // Text
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    else
                        $this->Write(5,$e);
                }
                else
                {
                    // Tag
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        // Extract attributes
                        $a2 = explode(' ',$e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag,$attr);
                    }
                }
            }
        }

        function OpenTag($tag, $attr)
        {
            // Opening tag
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,true);
            if($tag=='A')
                $this->HREF = $attr['HREF'];
            if($tag=='BR')
                $this->Ln(5);
        }

        function CloseTag($tag)
        {
            // Closing tag
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF = '';
        }

        function SetStyle($tag, $enable)
        {
            // Modify style and select corresponding font
            $this->$tag += ($enable ? 1 : -1);
            $style = '';
            foreach(array('B', 'I', 'U') as $s)
            {
                if($this->$s>0)
                    $style .= $s;
            }
            $this->SetFont('',$style);
        }

        function PutLink($URL, $txt)
        {
            // Put a hyperlink
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }
        }
        
    $pdf = new pdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',20);
    //$pdf->SetLeftMargin(45);
    $pdf->SetFontSize(12);
    $pdf->WriteHTML($html);
    $pdf->Output();
  }
    

  

?>