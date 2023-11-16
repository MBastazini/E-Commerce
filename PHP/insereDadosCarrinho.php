<?php 
    //include("sessao.php");
    include("caixa.php");
    function adicionaNoCarrinho($cod_produto, $quantidade){
        $user = CheckUser();

        if ($user == 1)
        {
            $conn = coneccao();

            //compra deve linkar-se com um produto
            $cod_compra = getCodCompra();
            $sql = "INSERT INTO tbl_compra_produto (quantidade, cod_produto, cod_compra) VALUES (:quantidade, :cod_produto, :cod_compra)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            $conn = null;
            $stmt = null;
        }else if ($user == 2)
        {
            if (!isset($_SESSION['visitante']['carrinho'][$cod_produto]))
            {
                $_SESSION['visitante']['carrinho'][$cod_produto] = $quantidade;
            }
        }
    }

    function deletaDoCarrinho($cod_produto){
        $user = CheckUser();

        if ($user == 1)
        {
            $conn = coneccao();

            $cod_compra = getCodCompra();

            //Deleta da tbl_compra_produto
            $sql = "DELETE FROM tbl_compra_produto WHERE cod_compra = :cod_compra AND cod_produto = :cod_produto";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> execute();

            $conn = null;
            $stmt = null;
        }else if ($user = 2){
            unset($_SESSION['visitante']['carrinho'][$cod_produto]);
        }
    }

    function mudaQuantidadeCarrinho($cod_produto, $s){
        $user = CheckUser();

        if ($user == 1)
        {
            $conn = coneccao();

            $cod_compra = getCodCompra();

            //Obtem a quantidade de produtos na compra
            $sql = "SELECT quantidade FROM tbl_compra_produto WHERE cod_compra = :cod_compra AND cod_produto = :cod_produto";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> execute();
            $quantidade = $stmt->fetch(PDO::FETCH_ASSOC);
            $quantidade = $quantidade['quantidade'];

            $sql = "SELECT estoque FROM tbl_produto WHERE cod_produto = :cod_produto";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> execute();
            $estoque = $stmt->fetch(PDO::FETCH_ASSOC);
            $estoque = $estoque['estoque'];

            if ($quantidade + $s == 0)
            {
                deletaDoCarrinho($cod_produto);
            }
            else if ($quantidade + $s > $estoque && $s > 0)
            {
                header('Location: ../Carrinho/index.php#esse-produto-nao-possui-mais-estoque');
                exit();
            }
            else{
                //Atualiza a quantidade de produtos na compra
                $sql = "UPDATE tbl_compra_produto SET quantidade = :quantidade WHERE cod_compra = :cod_compra AND cod_produto = :cod_produto";
                $quantidade += $s;
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
                $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                $stmt -> execute();
            }

            $conn = null;
            $stmt = null;
        } else if ($user = 2){
            $estoque = tblProduto($cod_produto)[0]->getEstoque();
            if ($_SESSION['visitante']['carrinho'][$cod_produto] > $estoque && $s > 0)
            {
                header('Location: ../Carrinho/index.php#esse-produto-nao-possui-mais-estoque');
                exit();
            }

            $_SESSION['visitante']['carrinho'][$cod_produto] += $s;

            if ($_SESSION['visitante']['carrinho'][$cod_produto] == 0)
            {
                deletaDoCarrinho($cod_produto);
            }
            
        }
    }

    function comprar($cod_produto)
    {
        $user = CheckUser();
        if ($user == 1)
        {
            $conn = coneccao();

            //try{
                /* Aqui o usuario ja cria uma compra com status concluida, e gera um pdf das informações da compra (unitaria)
                para o usuario, sem passar por tmpCompra */
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $nome_usuario = $_SESSION['usuario']['nome'];
                $data_hoje = date("Y/m/d");
                $status = 'Concluida';

                $estoque = tblProduto($cod_produto)[0]->getEstoque();
                if ($estoque <= 0)
                {
                    header('Location: ../Produtos/#nao-ha-estoque-suficiente');
                    exit();
                }

                $sql = "INSERT INTO tbl_compra (status, data_compra, cod_usuario) VALUES (:status, :data_compra, :cod_usuario)";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':status', $status, PDO::PARAM_STR);
                $stmt -> bindParam(':data_compra', $data_hoje, PDO::PARAM_STR);
                $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
                $stmt -> execute();

                $cod_compra = $conn->LastInsertId();
                $quantidade = 1;
                $sql = "INSERT INTO tbl_compra_produto VALUES (:quantidade, :cod_produto, :cod_compra)";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
                $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt -> execute();


                CriaHTML(tblCompra(5, '', $cod_compra));
            //}
            //catch(PDOException $e){
            //    echo "<script>alert('Erro ao adicionar produto!');</script>";
            //}
            

            $conn = null;
            $stmt = null;
            
            //header('Location: ../');
        }
        else{
            header('Location: ../Login/');
        }
    }

    function finalizarCarrinho(){
        
        $user = CheckUser();
        if ($user == 1)
        {
            
            $conn = coneccao();

            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $nome_usuario = $_SESSION['usuario']['nome'];
            
            $cod_compra = getCodCompra();
            
            $valido = carrinhoValido();

            if ($valido)
            {

            $compras = tblCompra(1);

            $sql = "SELECT * FROM tbl_compra_produto WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();
            
            
            //Deleta a tmpcompra
            $sql = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();
            
            //Muda o status da compra para 'concluido' e a data para agora
            $data_hoje = date("Y/m/d");
            $status = 'Concluida';
            $sql = "UPDATE tbl_compra SET status = :status, data_compra = :data_compra WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':status', $status, PDO::PARAM_STR);
            $stmt -> bindParam(':data_compra', $data_hoje, PDO::PARAM_STR);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            $conn = null;
            $stmt = null;
            $stmt2 = null;
            
            
            if (isset($compras) && !empty($compras))
            {
                CriaHTML($compras);
            }
            else{
                echo "ERRO";
            }
            
            //header('Location: ../');
            }
            else{
                header('Location: ../Carrinho/index.php#seu-carrinho-nao-e-valido');
                exit();
            }
            
        }
        else{
            header('Location: ../Login/');
        }
    }

    function limparCarrinho(){
        $user = CheckUser();
        if ($user == 1)
        {
            $conn = coneccao();

            //Deleta todas as 'cp' da compra
            $cod_compra = getCodCompra();
            $sql = "DELETE FROM tbl_compra_produto WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            //Deleta o carrinho
            $sql = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            //Deleta a compra
            $sql = "DELETE FROM tbl_compra WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            $conn = null;
            $stmt = null;
        }else if ($user == 2){
            unset($_SESSION['visitante']['carrinho']);
        }
    }



    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $funcao = $_POST['funcao'];
        if($funcao == 'muda+')
        {
            $cod_produto = $_POST['cod_produto'];
            mudaQuantidadeCarrinho($cod_produto, 1);
            header('Location: ../Carrinho/');
        }
        else if ($funcao == 'muda-')
        {
            $cod_produto = $_POST['cod_produto'];
            mudaQuantidadeCarrinho($cod_produto, -1);
            header('Location: ../Carrinho/');
        }
        else if($funcao == 'add' || $funcao == 'add++')
        {
            $cod_produto = $_POST["cod_produto"];
            adicionaNoCarrinho($cod_produto, 1);
            if ($funcao == 'add')
            {
                header('Location: ../Produtos/#produto-adicionado-no-carrinho');
            }
            else if ($funcao == 'add++')
            {
                header('Location: ../#hrefprod');
            }
        }
        else if($funcao == 'ver')
        {
            header('Location: ../Carrinho/');
        }
        else if($funcao == 'finalizar')
        {
            finalizarCarrinho();
            //header('Location: ../');
        }
        else if($funcao == 'comprar')
        {
            $cod_produto = $_POST['cod_produto'];
            comprar($cod_produto);
            header('Location: ../');
        }
        else if ($funcao == 'limpa_c')
        {
            limparCarrinho();
            header('Location: ../Carrinho/#carrinho-limpo');
        }
        else{
            echo "FUNCAO INVALIDA";
        }
    }
?>