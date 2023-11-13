<?php 
    require_once('Classes/cls_token.php');
    require_once('Classes/cls_carrinho.php');
    require_once('Classes/cls_compra.php');
    require_once('Classes/cls_produto.php');
    require_once('Classes/cls_usuario.php');
    require_once("Classes/cls_compra_produto.php");
    require_once("Classes/cls_imagem.php");
    include('sessao.php');



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

    function tblImagem(){
        if (!(isset($imagens)))
        {
            $imagens = array();
    
            $conn = coneccao();
    
            $sql = "SELECT * FROM tbl_imagem_produto ORDER BY cod_imagem";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $imagens[] = new Imagem($row['cod_imagem'], $row['imagem'], $row['nome_img']);
            }
    
            $conn = null;
            $stmt = null;
        }
        
        return $imagens;
    }
    function tblProduto($cod_produto = 0){
        if (!(isset($produtos)))
        {
            $produtos = array();
    
            $conn = coneccao();

            $where = ' ';
            if ($cod_produto != 0)
            {
                $sql = 'SELECT * FROM tbl_produto INNER JOIN
                tbl_imagem_produto ON tbl_produto.imagem = tbl_imagem_produto.cod_imagem
                WHERE cod_produto = :cod_produto
                ORDER BY (CASE WHEN excluido = true THEN 1 ELSE 0 END), cod_produto;';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);

            }
            else{
                $sql = "SELECT * FROM tbl_produto INNER JOIN
                tbl_imagem_produto ON tbl_produto.imagem = tbl_imagem_produto.cod_imagem
                ORDER BY (CASE WHEN excluido = true THEN 1 ELSE 0 END), cod_produto;";
                $stmt = $conn->prepare($sql);
            }
            

            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $produtos[] = new Produto($row['cod_produto'], $row['nome'], $row['descricao'], 
                $row['preco'], $row['categoria'], $row['custo'], $row['excluido'], $row['icms'], 
                $row['estoque'], $row['margem_lucro'], $row['imagem']);
            }

            $conn = null;
            $stmt = null;
        }
        

        return $produtos;
    }

    function tblCompra($tipo = 0, $sql = '')
    {
        if (!(isset($compras)))
        {
            $user = CheckUser();
            $compras = array();

            if($user == 1){
                $conn = coneccao();
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];

                if ($tipo == 0)
                {
                    $sql = 'SELECT * FROM tbl_compra WHERE cod_usuario = :cod_usuario AND status = \'Concluida\' ORDER BY cod_compra';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);

                } 
                else if ($tipo == 1)
                {
                    $sql = 'SELECT c.cod_compra, c.status, c.data_compra FROM tbl_tmpcompra AS tmp
                    INNER JOIN tbl_compra AS c ON tmp.cod_compra = c.cod_compra
                    WHERE c.cod_usuario = :cod_usuario AND c.status = \'Pendente\' ORDER BY c.cod_compra';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_STR);

                    
                }  
                else if ($tipo == 2)
                {
                    $sql = 'SELECT * FROM tbl_compra WHERE status = \'Concluida\' ORDER BY cod_compra';
                    $stmt = $conn->prepare($sql);
                }
                else{
                    $stmt = $conn->prepare($sql);
                    
                }
                
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $compra = new Compra($row['cod_compra'], $row['status'], $row['data_compra'], $row['cod_usuario']);
                    $sql2 = 'SELECT * FROM tbl_compra_produto AS cp
                    INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
                    WHERE cp.cod_compra = :cod_compra ORDER BY cp.cod_compra';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bindParam(':cod_compra', $row['cod_compra'], PDO::PARAM_INT);
                    $stmt2->execute();

                    $valor_total = 0;
                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                        $compra->createCompra($row2['cod_produto'], $row2['quantidade'], $row2['nome'], $row2['preco']);
                        $valor_total += $row2['preco'] * $row2['quantidade'];
                    }
                    $compra->setValor_total($valor_total);
                    $compras[] = $compra;
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
        
                $sql = "SELECT * FROM tbl_token WHERE cod_usuario = :cod_usuario ORDER BY cod_token";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->execute();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tokens[] = new Token($row['cod_token'], $row['token'], $row['data_criacao'], $row['cod_usuario']);
                }
        
                $conn = null;
                $stmt = null;
            }
        }
        
        return $tokens;
    }

    function tblUsuario($tipo = 0, $c_u = 0)
    {
        
        if(!(isset($usuario)))
        {
            $usuario = array();
            $user = CheckUser();

            if ($user == 1)
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $conn = coneccao();
                
                if ($tipo == 0)
                {   
                    $sql = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario ORDER BY cod_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":cod_usuario", $cod_usuario, PDO::PARAM_INT);
                }
                else if ($tipo == 5)
                {
                    $sql = "SELECT * FROM tbl_usuario WHERE cod_usuario = :cod_usuario ORDER BY cod_usuario";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":cod_usuario", $c_u, PDO::PARAM_INT);
                }
                else
                {
                    $sql = "SELECT * FROM tbl_usuario ORDER BY cod_usuario";
                    $stmt = $conn->prepare($sql);
                }
                
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
        
                $cod_compra = getCodCompra();
                //Talvez nem precise do usuario
                $sql = "SELECT p.nome, p.preco, cp.quantidade, p.cod_produto, ip.imagem FROM tbl_compra_produto AS cp
                INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
                INNER JOIN tbl_compra AS c ON cp.cod_compra = c.cod_compra
                INNER JOIN tbl_imagem_produto AS ip ON p.imagem = ip.cod_imagem
                WHERE c.cod_usuario = :cod_usuario AND c.cod_compra = :cod_compra
                AND p.excluido = false ORDER BY p.cod_produto";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt->execute();
        
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $carrinho[] = new Carrinho($row['nome'], $row['preco'], $row['quantidade'], $row['cod_produto'], $row['imagem']);
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
        
                        $sql = "SELECT p.nome, p.preco, ip.imagem FROM tbl_produto AS p
                        INNER JOIN tbl_imagem_produto AS ip ON p.imagem = ip.cod_imagem
                        WHERE cod_produto = :cod_produto";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                        $stmt->execute();
                        $resultado = $stmt->fetch();
        
                        $carrinho[] = new Carrinho($resultado['nome'], $resultado['preco'], $quantidade, $cod_produto, $resultado['imagem']);
        
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

            $sql = 'SELECT SUM(p.preco*cp.quantidade) FROM tbl_tmpcompra AS tmp
            INNER JOIN tbl_compra AS c ON tmp.cod_compra = c.cod_compra
            INNER JOIN tbl_compra_produto AS cp ON c.cod_compra = cp.cod_compra
            INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
            WHERE c.cod_usuario = :cod_usuario';
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

    function carrinhoValido() //Checa se o carrinho atual possui estoque para ser comprado
    {
        $user = CheckUser();
        if ($user == 1)
        {
            $carrinho = tblCarrinho();
            foreach ($carrinho as $c)
            {
                $cod_produto = $c->getCodProduto();
                $quantidade = $c->getQuantidade();
                $produto = tblProduto($cod_produto)[0];
                if ($quantidade > $produto->getEstoque())
                {
                    return false;
                }
            }
            return true;
        }
        else if($user == 2){
            foreach($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade)
            {
                $produto = tblProduto($cod_produto)[0];
                if ($quantidade > $produto->getEstoque())
                {
                    return false;
                }
            }
            return true;
        }
    }


    
    
?>