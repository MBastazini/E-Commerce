<?php 
    require_once('Classes/cls_token.php');
    require_once('Classes/cls_carrinho.php');
    require_once('Classes/cls_compra.php');
    require_once('Classes/cls_produto.php');
    require_once('Classes/cls_usuario.php');

    include("sessao.php");


    function getCodCompra(){
        $user = CheckUser();
        if ($user == 1)
        {
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];

            $conn = coneccao();

            //Checa se há alguma compra no carrinho
            $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_usuario = :cod_usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch();

            //Se não houver
            if ($resultado == null)
            {
                //Cria uma nova compra
                $sql = "INSERT INTO tbl_compra (status, data_compra, cod_usuario) VALUES ('Pendente', null, :cod_usuario)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();

                //Pega o código da compra criada
                $codCompra = $conn->lastInsertId();

                //Cria uma nova linha na tabela de carrinho temporário
                $sql = "INSERT INTO tbl_tmpcompra (cod_compra, cod_usuario) VALUES (:cod_compra, :cod_usuario)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_compra', $codCompra, PDO::PARAM_INT);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();
            }
            else{
                $codCompra = $resultado['cod_compra'];
            }

            $conn = null;
            $stmt = null;
        
            return $codCompra;
        }
    }
    function tblProduto(){
        if (!(isset($produtos)))
        {
            $produtos = array();
    
            $conn = coneccao();

            $sql = "SELECT * FROM tbl_produto";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $produtos[] = new Produto($row['cod_produto'], $row['nome'], $row['descricao'], 
                $row['preco'], $row['categoria'], $row['custo'], $row['excluido'], $row['icms'], $row['quantidade']);
            }

            $conn = null;
            $stmt = null;
        }
        

        return $produtos;
    }

    function tblCompra()
    {
        if (!(isset($compras)))
        {
            $user = CheckUser();
            $compras = array();

            if($user == 1){
                $conn = coneccao();
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];

                $sql = 'SELECT * FROM tbl_compra WHERE cod_usuario = :cod_usuario';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $compra = new Compra($row['cod_compra'], $row['status'], $row['data_compra'], $row['cod_usuario']);
                    $sql2 = 'SELECT p.cod_produto, cp.quantidade, p.nome, p.preco FROM tbl_compra_produto AS cp
                    INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
                    WHERE cp.cod_compra = :cod_compra';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bindParam(':cod_compra', $row['cod_compra'], PDO::PARAM_INT);
                    $stmt2->execute();
                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                        $compra->createCompra($row2['cod_produto'], $row2['quantidade'], $row2['nome'], $row2['preco']);
                    }
                }
        
                $conn = null;
                $stmt = null;
            }
        }
        
        return $compras;
    }

    function tblToken()
    {
        if (!(isset($tokens)))
        {
            $tokens = array();
        
            $user = CheckUser();
            if ($user == 1)
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];

                $conn = coneccao();
        
                $sql = "SELECT * FROM tbl_token WHERE cod_usuario = :cod_usuario";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tokens[] = new Token($row['cod_token'], $row['token'], $row['data_criacao'], $row['ip_criacao'], $row['cod_usuario']);
                }
        
                $conn = null;
                $stmt = null;
            }
        }
        
        return $tokens;
    }

    function tblUsuario()
    {
        
        if(!(isset($usuario)))
        {
            $usuario = array();
            $user = CheckUser();

            if ($user == 1)
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $conn = coneccao();
        
                $sql = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":cod_usuario", $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $usuario[] = new Usuario($row['cod_usuario'], $row['nome'], $row['email'], $row['senha'], $row['telefone']);
                }
        
                $conn = null;
                $stmt = null;
            }
        }
        
        return $usuario;
    }

    function tblCarrinho()
    {
        if (!(isset($carrinho))){
            $carrinho = array();
    
            $user = CheckUser();
            if ($user == 1)
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];

                $conn = coneccao();
        
                $sql = "SELECT p.nome, p.preco, p.cod_produto, cp.quantidade, tmp.cod_tmpcompra FROM tbl_tmpcompra AS tmp
                INNER JOIN tbl_compra ON tmp.cod_compra = tbl_compra.cod_compra
                INNER JOIN tbl_compra_produto AS cp ON tbl_compra.cod_compra = cp.cod_compra
                INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
                WHERE tbl_compra.cod_usuario = :cod_usuario";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $carrinho[] = new Carrinho($row['nome'], $row['preco'], $row['quantidade'], $row['cod_produto'], $row['cod_tmpcompra']);
                }
        
                $conn = null;
                $stmt = null;
            }
            else if($user == 2)
            {
                if (isset($_SESSION['visitante']['carrinho']))
                {
                    foreach ($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade){
                        $conn = coneccao();
        
                        $sql = "SELECT nome, preco FROM tbl_produto WHERE cod_produto = :cod_produto";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                        $stmt->execute();
                        $resultado = $stmt->fetch();
        
                        $carrinho[] = new Carrinho($resultado['nome'], $resultado['preco'], $quantidade, $cod_produto, $cod_produto);
        
                        $conn = null;
                        $stmt = null;
                        $resultado = null;
                    }
                }
            }
        }
        
        return $carrinho;
    } 

    function getValorTotal()
    {
        $user = CheckUser();
        if ($user == 1)
        {
            $soma = 0;

            $cod_usuario = $_SESSION['usuario']['cod_usuario'];

            $conn = coneccao();

            $sql = 'SELECT SUM(preco*quantidade) FROM tbl_tmpcompra AS tmp
            INNER JOIN tbl_compra ON tmp.cod_compra = tbl_compra.cod_compra
            INNER JOIN tbl_compra_produto AS cp ON tbl_compra.cod_compra = cp.cod_compra
            INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
            WHERE tbl_compra.cod_usuario = :cod_usuario';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $soma = $resultado['sum'];

            $conn = null;
            $stmt = null;

            return $soma;
        }
        else if ($user == 2)
        {
            $soma = 0;
            if (isset($_SESSION['visitante']['carrinho']))
            {
                foreach ($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade){
                    $conn = coneccao();
    
                    $sql = "SELECT preco FROM tbl_produto WHERE cod_produto = :cod_produto";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
    
                    $soma += $resultado['preco'] * $quantidade;
    
                    $conn = null;
                    $stmt = null;
                    $resultado = null;
                }
            }
            return $soma;
        }
        
    }
    
    function estaNoCarrinho($cod_produto){
        $carrinhos = tblCarrinho();
        $estaNoCarrinho = false;
        foreach ($carrinhos as $carrinho){
            if ($carrinho->getCodProduto() == $cod_produto){
                $estaNoCarrinho = true;
            }
        }
        return $estaNoCarrinho;
    }
?>