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

    function setToken($cod_usuario)
        {
            $user = CheckUser();
            if ($user == 1)
            {
                $conn = coneccao();
            $token = session_id(); //Se falhar o token olhar aqui
            //$ip = $_SERVER['REMOTE_ADDR'];
            $data = date('Y-m-d H:i:s');

            $linha = [
                'cod_usuario' => $cod_usuario,
                'token' => $token,
                //'ip' => $ip,
                'data' => $data
            ];

            $sql = "INSERT INTO tbl_token (cod_usuario, token, data_criacao) VALUES (:cod_usuario, :token, :data)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_usuario', $linha['cod_usuario'], PDO::PARAM_INT);
            $stmt -> bindParam(':token', $linha['token'], PDO::PARAM_STR);
            //$stmt -> bindParam(':ip', $linha['ip'], PDO::PARAM_STR);
            $stmt -> bindParam(':data', $linha['data'], PDO::PARAM_STR);
            $stmt -> execute();

            Cookie('token', $token, 1440); //24 horas
            $_SESSION['token'] = $token;

            $conn = null;
            $stmt = null;
            }
    }

    function deletaToken($id){
        $conn = coneccao();
        $sql = "DELETE FROM tbl_token WHERE cod_token = :id";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();

        $conn = null;
        $stmt = null;
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
                $token = $_SESSION['token'];
                
                $sql = "SELECT * FROM tbl_token WHERE token = :token";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":token", $token, PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt -> fetch(PDO::FETCH_ASSOC);
        
                if ($resultado != NULL)
                {
                    $cod_usuario = $resultado["cod_usuario"];
                    $sql = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":cod_usuario", $cod_usuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $resultado2 = $stmt -> fetch(PDO::FETCH_ASSOC);
        
                    if ($resultado2 != NULL)
                    {
                        $_SESSION['conectado'] = true;
                        $conectado = true;
    
                        $_SESSION['usuario']['ativo'] = true;
                        $_SESSION['visitante']['ativo'] = false;
    
                        $_SESSION['usuario']['nome'] = explode(" ", $resultado2['nome'])[0];
                        $_SESSION['usuario']['cod_usuario'] = $resultado2['cod_usuario'];
    
                        if ($resultado2['cod_usuario'] == 0)
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
                        deletaToken($resultado['cod_token']);
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

        return $_SESSION['conectado'];
      }


?>