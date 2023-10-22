<?php 

    function coneccao()
    {
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }
        return $conn;
    }
    function CheckUser()
    {
        $conectado = inicioSessao();
        if ($conectado)
        {
            if($_SESSION['usuario']['ativo'])
            {
                return 1;
            }
            else if ($_SESSION['visitante']['ativo'])
            {
                return 2;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
    function Cookie($nome, $valor, $min) 
    {
        setcookie($nome, $valor, time() + $min * 60, '/projetoscti14'); 
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
    

        if (!$conectado)
        {
            if (isset($_COOKIE['token'])) {
                try{
                    $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
                    password=721526"); 
                }
                catch(PDOException $e){
                    echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
                }

                $_SESSION['token'] = $_COOKIE['token'];
                $check_token = "SELECT * FROM tbl_token WHERE token = :token";
                $check_token -> bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
                $check_token -> execute();
                $res_token = $check_token->fetch();
        
                if ($res_token != NULL)
                {
                    $check_user = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
                    $check_user -> bindParam(':cod_usuario', $res_token['cod_usuario'], PDO::PARAM_INT);
                    $check_user -> execute();
                    $res_user = $check_user->fetch();
        
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
                    setcookie('token', '', time() - 1, '/projetoscti14');
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

        $conn = null;
        $check_token = null;
        $res_token = null;
        $check_user = null;
        $res_user = null;

        return $_SESSION['conectado'];
      }


?>