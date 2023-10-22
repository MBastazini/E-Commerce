<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("caixa.php");

    $conectado = inicioSessao();
    if ($conectado)
    {
        if($_SESSION['visitante']['ativo'])
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $conn = coneccao();
                $email = $_POST['email'];
                $sql_email = "select * from tbl_usuario where email = :email";
                $select = executaSQL($sql_email, ['email' => $email]);
                $resultado = $select->fetch();

                //Guarda os valores preenchiods para o usuario não ter que redigita-los.
                Cookie('nome_tmp', $_POST['nome'], 1);
                Cookie('email_tmp', $_POST['email'], 1);
                Cookie('telefone_tmp', $_POST['telefone'], 1);

                if ($resultado == NULL)
                {
                    //Não possui uma conta cadastrada com esse e-mail
                    $senha = $_POST['senha'];
                    $csenha = $_POST['senha_c'];

                    if($senha == $csenha){
                        
                    }
                    else{
                        //Senhas não conferem
                        header('Location: ../Cadastro/index.php?erro=1');
                    }
                }
                else{
                    //Esse e-mail já possui conta
                    header('Location: ../Cadastro/index.php?erro=2');
                }
            }
            //Pagina de erro, no else
        }
        //Se não estiver ativo, é sinal de que ha algum usuario conectado, ou ocorreu um erro
        //Em ambos os casos tambem redireciona-se para a pagina de erro.
    }
    //se não for true, há algum erro (em todos esses cados podemos redirecionar para uma pagina de erro)
?>
