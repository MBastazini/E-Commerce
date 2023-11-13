<?php   
    require_once('obtemDados.php');
  function barraNavegacao($tela, $src)
  {
    $user = CheckUser();
    $produtos = tblProduto(); //Obtem os produtos para a barra de pesquisa
     echo "<div class='nav_nav"; if ($tela == 'home'){echo" nav_sobe ";}  echo" container'>
        <div class='nav_fundo nf_fixo'></div>
        <a href='".$src."'><img src='".$src."Icones/logo-verde.svg' class='nav_logo' alt='Logo TINYWOOD'></a>


        <div class='nav_div_pesquisa'>
                <div class='nav_pesquisa'>
                    <img src='".$src."Icones/pesquisa_cinza.svg' class='nav_icon'>
                    <input type='text' placeholder='Pesquisar...'>
                </div>
                <div class='nav_p_resultados'>";
                    foreach ($produtos as $produto)
                    {
                        echo "<a href='".$src."Produtos/index.php#".$produto->getCodProduto()."'>";
                        echo "<div>";
                        echo "<p>".$produto->getNome()."</p>";
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
                  usuarioNavegacao($src);   
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
                  <p>Somos uma empresa de referência ambiental, que reutiliza  árvores por meio do licenciamento 
                  urbano para transformar em um adereço estiloso e acessível. Conectado com a natureza em todos os lugares.</p>
                  <div class='footer_logo_info_mais'>
                    <a href='https://mail.google.com/mail/?view=cm&fs=1&to=tinywood@projetoscti.com.br' target='_blank'>
                        <div class='footer_logo_info_mais_botao' value='1'>
                            <img src='".$src."Icones/email.svg'>
                        </div>
                    </a>
                    <a href='https://instagram.com/tiny.wood?igshid=MzRlODBiNWFlZA==' target='_blank'>
                        <div class='footer_logo_info_mais_botao' value='2'>
                            <img src='".$src."Icones/instegrem.svg'>
                        </div>
                    </a>
                    <a href='https://www.youtube.com/channel/UCaNZ0fq69Qrlq9f8W9WydTg' target='_blank'>
                        <div class='footer_logo_info_mais_botao' value='3'>
                            <img src='".$src."Icones/yeutebe.svg'>
                        </div>
                    </a>

                  </div>
              </div>
          </div>

          <div class='copyright'>
              <p>All copyrights to &copy; TinyWood</p>
          </div>
          <div class='footer_info'>
              <div class='footer_div'>
                  <h1>Desenvolvedores</h1>
                  <a href='".$src."Sobre/#leticia'><p>Leticia Garcia | N° 21</p></a>
                  <a href='".$src."Sobre/#luiz'><p>Luiz Felipe | N° 22</p></a>
                  <a href='".$src."Sobre/#mariana'><p>Mariana Senger | N° 23</p></a>
                  <a href='".$src."Sobre/#mateus'><p>Mateus Bastazini | N° 24</p></a>
                  <a href='".$src."Sobre/#matheus'><p>Matheus Trentini | N° 25</p></a>
              </div>
              <div class='footer_div'>
                  <h1>Colégio</h1>
                  <a href='https://cti.feb.unesp.br'><p>CTI - Unesp (Campus Bauru)</p></a>
                  <a href='https://www.bauru.unesp.br'><p>UNESP Bauru</p></a>
              </div>
          </div>
      </footer>";
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

  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';


  function enviaemail($destinatario, $codigo){

    

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
        $mail->Subject = 'Esqueci minha senha - TinyWood';
        $mail->Body    = "Seu código de verificação é: <b>$codigo</b>
        <br><br>
        Se você não solicitou a alteração de senha, ignore este e-mail.";
        $mail->AltBody = 'Seu código de verificação é:' . $codigo;


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

  function CriaHTML(array $compras)
    {
        $html = "<html> <br><br>
                    <b>".
                    sprintf('%3s', 'Id').
                    sprintf('%12s','Data').
                    sprintf('%50s','Nome').
                    sprintf('%10s','$ Total').
                    "</b>
                <br>";


        if (isset($compras)) {
            foreach ($compras as $compra) {
                $cod_compra = sprintf('%03s', $compra -> getCodCompra());

                $cod_usuario = $compra -> getCodUsuario();
                $nome_usuario = tblUsuario(5, $cod_usuario)[0] -> getNome();

                $nome_usuario = sprintf('%50s', $nome_usuario);

                $data_compra = sprintf('%12s', $compra -> getDataCompra());

                $valor_total = sprintf('%10s', $compra -> getValorTotal());

                $html .= $cod_compra . $data_compra . $nome_usuario . $valor_total . "<br>";
                

                $html .= "<b>".
                sprintf('%20s','Prod').
                sprintf('%5s','Qtd').
                sprintf('%10s','$ unit').
                sprintf('%10s','$ sub').
                "</b><br>";


                $produtos = $compra->getCompras();
                foreach($produtos as $produto) {
                    
                    $preco = $produto -> getPreco();
                    $quantidade = $produto -> getQuantidade();
                    $cod_produto = $produto -> getCodProduto();
                    $subtotal = $preco * $quantidade;

                    $nome = sprintf('%20s', $produto -> getNome());
                    $preco = sprintf('%10s', $preco);
                    $quantidade = sprintf('%5s', $quantidade);
                    $subtotal = sprintf('%10s', $subtotal);

                    $html .= $nome . $quantidade . $preco . $subtotal . "<br>";
                }
                
            }  
        }
        $html .= '</html>';
        
        //echo $html;
        CriaPDF('', $html, 'jota.pdf');
    }

  function CriaPDF ( $paramTitulo, $paramHtml, $paramArquivoPDF )
  {
   $arq = false;     
   try {  
    require "fpdf/html_table.php"; 
    // abre classe fpdf estendida com recurso que converte <table> em pdf
  
    $pdf = new PDF();  
    // cria um novo objeto $pdf da classe 'pdf' que estende 'fpdf' em 'html_table.php'
    $pdf->AddPage();  // cria uma pagina vazia
    $pdf->SetFont('helvetica','B',20);       
    $pdf->Write(5,$paramTitulo);    
    $pdf->SetFont('helvetica','',8);     
    $pdf->WriteHTML($paramHtml); // renderiza $html na pagina vazia
    ob_end_clean();    
    // fpdf requer tela vazia, essa instrucao 
    // libera a tela antes do output
    
    // gerando um arquivo 
    $pdf->Output($paramArquivoPDF,'F');
    // gerando um download 
    $pdf->Output('D',$paramArquivoPDF);  // disponibiliza o pdf gerado pra download
    $arq = true;
   } catch (Exception $e) {
     echo $e->getMessage(); // erros da aplicação - gerais
   }
   return $arq;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $funcao = $_POST['funcao'];
        if ($funcao == 'relatorio')
        {
            $valor_f = $_POST['valor_f'];
            $sql_f = $_POST['sql_f'];
            if ($valor_f == 2)
            {
                $compras = tblCompra(2);
                CriaHTML($compras);
            }
            else if ($valor_f == 3){
                $compras = tblCompra(3, $sql_f);
                CriaHTML($compras);
            }
            
        }
    }
?>