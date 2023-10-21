<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("caixa.php");
    $conectado = inicioSessao();
    if ($conectado)
    {
        if ($_SESSION['visitante']['ativo'])
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $conn = coneccao();

                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $sql_email = "select * from tbl_usuario where email = :email";
                $select = executaSQL($sql_email, ['email' => $email]);

                $resultado = $select->fetch();
                if ($resultado == NULL)
                {
                    //Não possui uma conta cadastrada com esse e-mail
                    header('Location: ../Login/index.php?erro=1');
                }
                else{
                    $linha = [
                        'email' => $email,
                        'senha' => $senha
                    ];
                    $sql_senha = "select * from tbl_usuario where email = :email and senha = :senha";
                    $select2 = executaSQL($sql_senha, $linha);
                    $resultado2 = $select2->fetch();
                    if ($resultado2 == NULL)
                    {
                        //Senha incorreta
                        header('Location: ../Login/index.php?erro=2');
                    }
                    else{
                        //Login efetuado com sucesso.

                        /*if (isset($_POST['lembrar']))
                        {
                            setToken($resultado2['cod_usuario']);
                        }*/
                        
                        
                        $_SESSION['usuario']['ativo'] = true;

                        $_SESSION['visitante']['ativo'] = false;


                        setToken($resultado2['cod_usuario']);
                        $_SESSION['usuario']['nome'] = explode(" ", $resultado2['nome'])[0];
                        //echo $_SESSION['conectado'];
                        $_SESSION['usuario']['cod_usuario'] = $resultado2['cod_usuario'];
                        if ($resultado2['cod_usuario'] == 0)
                        {
                            $_SESSION['usuario']['adm'] = true;
                        }
                        else{
                            $_SESSION['usuario']['adm'] = false;
                        }
                        header('Location: ../');
                    }
                }
            }
        }
    }
?>
