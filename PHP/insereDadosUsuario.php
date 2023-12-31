<?php 
//include("sessao.php"); -> insereDadosCarrinho já faz.
include("insereDadosCarrinho.php");

    function novoUsuario()
    {
        
        $user = CheckUser();

        if($user == 2)
        {
            $conn = coneccao();
            $linha = [ 
                'nome'      => $_POST['nome'],   
                'email'     => $_POST['email'],
                'telefone'  => $_POST['telefone'], 
                'senha'     => $_POST['senha']
            ];
        
            try{
                $sql = "INSERT INTO tbl_usuario (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
                $stmt -> bindParam(':email', $linha['email'], PDO::PARAM_STR);
                $stmt -> bindParam(':telefone', $linha['telefone'], PDO::PARAM_STR);
                $stmt -> bindParam(':senha', $linha['senha'], PDO::PARAM_STR);
                $stmt -> execute();
            
            
                
                
                $_SESSION['usuario']['ativo'] = true;
                $cod_usuario = $conn -> LastInsertId();
                $_SESSION['usuario']['cod_usuario'] = $cod_usuario;

                if(isset($_POST['lembrar']))
                {
                    setToken($cod_usuario);
                }
                $_SESSION['usuario']['adm'] = false;
            
            
                //Pega todas as compras feitas enquanto o usuário estava como visitante e as coloca no seu nome.
                if (isset($_SESSION['visitante']['carrinho']))
                {
                    foreach ($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade){
                        adicionaNoCarrinho($cod_produto, $quantidade);
                    }
                }
                
            
                $_SESSION['visitante']['ativo'] = false;
            
                $_SESSION['usuario']['nome'] = explode(" ", $linha['nome'])[0];
            
                
                header('Location: ../');
            }
            catch(PDOException $e){
                echo "<script>alert('Erro ao adicionar usuário!');</script>";
            }
            

            $conn = null;
            $stmt = null;
        }
    }

    function editaUsuario()
    {
        $user = CheckUser();
        if ($user == 1)
        {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $senha = $_POST['senha'];

            $conn = coneccao();
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];

            try{
                $sql = "UPDATE tbl_usuario SET nome = :nome, email = :email, telefone = :telefone, senha = :senha WHERE cod_usuario = :cod_usuario";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                $stmt -> bindParam(':telefone', $telefone, PDO::PARAM_STR);
                $stmt -> bindParam(':senha', $senha, PDO::PARAM_STR);
                $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt -> execute();

                $_SESSION['usuario']['nome'] = explode(" ", $nome)[0];
            }
            catch(PDOException $e){
                echo "<script>alert('Erro ao editar usuário!');</script>";
            }
            

            $conn = null;
            $stmt = null;
        }
    }

    function deletaUsuario($cod_usuario)
    {
        $user = CheckUser();
        if ($user == 1)
        {
            if ($_SESSION['usuario']['adm'])
            {
                $conn = coneccao();
                try{
                    $sql = "DELETE FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                    $stmt -> execute();
                }
                catch(PDOException $e){
                    echo "<script>alert('Erro ao deletar usuário!');</script>";
                }
                

                $conn = null;
                $stmt = null;
            }
            
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $funcao = $_POST['funcao'];
        if($funcao == 'cadastro')
        {
            $user = CheckUser();
            if ($user == 2)
            {
                $conn = coneccao();
                $email = $_POST['email'];
                $sql = "SELECT * FROM tbl_usuario WHERE email = :email";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                $stmt -> execute();
                $resultado = $stmt->fetch();

                $conn = null;
                $stmt = null;

                if ($resultado == NULL)
                {
                    //Não possui uma conta cadastrada com esse e-mail
                    $senha = $_POST['senha'];
                    $csenha = $_POST['senha_c'];

                    if($senha == $csenha){
                        novoUsuario();
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
            else{
                header('Location: ../');
            }
                 
        }
        else if($funcao == 'login')
        {
            $user = CheckUser();
            if ($user == 2)
            {
                $conn = coneccao();

                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $sql = "SELECT * FROM tbl_usuario WHERE email = :email";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                $stmt -> execute();

                $resultado = $stmt->fetch();
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
                    $sql = "SELECT * FROM tbl_usuario WHERE email = :email AND senha = :senha";
                    $stmt = $conn->prepare($sql);
                    $stmt -> bindParam(':email', $linha['email'], PDO::PARAM_STR);
                    $stmt -> bindParam(':senha', $linha['senha'], PDO::PARAM_STR);
                    $stmt -> execute();
                    $resultado = $stmt->fetch();
                    if ($resultado == NULL)
                    {
                        //Senha incorreta
                        header('Location: ../Login/index.php?erro=2');
                    }
                    else{
                        //Login efetuado com sucesso.

                        
                        
                        
                        $_SESSION['usuario']['ativo'] = true;

                        //setToken($resultado['cod_usuario']);
                        //header('Location: ../ERRO');
                        
                        if (isset($_POST['lembrar']))
                        {
                            setToken($resultado['cod_usuario']);
                        }
                        $_SESSION['usuario']['nome'] = explode(" ", $resultado['nome'])[0];
                        //echo $_SESSION['conectado'];
                        $_SESSION['usuario']['cod_usuario'] = $resultado['cod_usuario'];
                        if ($resultado['cod_usuario'] == 0)
                        {
                            $_SESSION['usuario']['adm'] = true;
                        }
                        else{
                            $_SESSION['usuario']['adm'] = false;
                        }

                        foreach ($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade){
                            adicionaNoCarrinho($cod_produto, $quantidade);
                        }
                        
                        $_SESSION['visitante']['ativo'] = false;
 
                        header('Location: ../');
                    }
                }
            }
            else{
                header('Location: ../');
            }
        } 
        else if ($funcao == 'edit')
        {
            editaUsuario();
            header('Location: ../Conta'); 
        }
        else if ($funcao == 'deltoken')
        {
            $id = $_POST['id'];
            deletaToken($id);
            header('Location: ../Conta');
        }
        else if ($funcao == 'del_user')
        {
            $cod_usuario = $_POST['cod_usuario'];
            deletaUsuario($cod_usuario);
            header('Location: ../Conta/crudUsuarios.php#usuario-excluido');
        }
        
    }
?>