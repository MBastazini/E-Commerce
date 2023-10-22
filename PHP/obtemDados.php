<?php 
    require_once('Classes/cls_token.php');
    require_once('Classes/cls_carrinho.php');
    require_once('Classes/cls_compra.php');
    require_once('Classes/cls_produto.php');
    require_once('Classes/cls_usuario.php');

    function tblCompra()
    {
        $cod_usuario = null; //preencher dps
        $compras = array();
    
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }

        $sql = "SELECT * FROM tbl_compra WHERE cod_usuario = :cod_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $compras[] = new Compra($row['cod_compra'], $row['status'], $row['data_compra'], $row['cod_usuario']);
        }

        $conn = null;
        $stmt = null;

        return $compras;
    }

    function tblToken()
    {
        $cod_usuario = null; //preencher dps
        $tokens = array();
    
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }

        $sql = "SELECT * FROM tbl_token WHERE cod_usuario = :cod_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $tokens[] = new Token($row['cod_token'], $row['token'], $row['cod_usuario']);
        }

        $conn = null;
        $stmt = null;

        return $tokens;
    }

    function tblProduto($cod_produto)
    {
        $produto = null;
    
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }

        $sql = "SELECT * FROM tbl_produto WHERE cod_produto = :cod_produto";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $produto = new Produto($row['cod_produto'], $row['nome'], $row['preco'], $row['quantidade'], $row['cod_usuario']);
        }

        $conn = null;
        $stmt = null;

        return $produto;
    }

    function tblUsuario()
    {
        $cod_usuario = null; //preencher dps
        $usuarios = array();
    
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }

        $sql = "SELECT * FROM tbl_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $usuarios[] = new Usuario($row['cod_usuario'], $row['nome'], $row['email'], $row['senha'], $row['telefone']);
        }

        $conn = null;
        $stmt = null;

        return $usuarios;
    }

    function tblCarrinho()
    {
        $cod_usuario = null; //preencher dps
        $carrinhos = array();
    
        try{
            $conn = new PDO("pgsql:host=pgsql.projetoscti.com.br ; dbname=projetoscti26 ; user=projetoscti26 ; 
            password=721526"); 
        }
        catch(PDOException $e){
            echo "Erro ao conectar com o banco de dados. ".$e->getMessage();
        }

        $sql = "SELECT p.nome, p.preco, p.cod_produto, cp.quantidade FROM tbl_tmpcompra
        INNER JOIN tbl_compra ON tbl_tmpcompra.cod_compra = tbl_compra.cod_compra
        INNER JOIN tbl_compra_produto AS cp ON tbl_compra.cod_compra = cp.cod_compra
        INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
        WHERE tbl_compra.cod_usuario = :cod_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $carrinhos[] = new Carrinho($row['nome'], $row['preco'], $row['quantidade'], $row['cod_produto']);
        }

        $conn = null;
        $stmt = null;

        return $carrinhos;
    }

    function tblOfflineCarrinho()
    {
        $carrinhos = array();
        foreach 
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