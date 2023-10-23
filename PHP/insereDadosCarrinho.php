<?php 
    include("sessao.php");

    function adicionaCarrinho($cod_produto, $quantidade){
        $user = CheckUser();

        if ($user == 1)
        {
            $conn = coneccao();

            //Usuario efetua uma compra
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $data_hoje = date("Y/m/d");
            $status = 'Pendente';
            $sql = "INSERT INTO tbl_compra (status, data_compra, cod_usuario) VALUES (:status, :data_compra, :cod_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':status', $status, PDO::PARAM_STR);
            $stmt -> bindParam(':data_compra', $data_hoje, PDO::PARAM_STR);
            $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt -> execute();

            //compra deve linkar-se com um produto
            $cod_compra = $conn->LastInsertId();
            $sql = "INSERT INTO tbl_compra_produto (quantidade, cod_produto, cod_compra) VALUES (:quantidade, :cod_produto, :cod_compra)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            //Compra registra uma compraTemporaria (que aparecerá no carrinho)
            $sql = "INSERT INTO tbl_tmpcompra (cod_compra) VALUES (:cod_compra)";
            $stmt = $conn->prepare($sql);
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

    function deletaCarrinho($cod_tmpcompra){
        $user = CheckUser();

        if ($user = 1)
        {
            $conn = coneccao();

            //Obtem o codigo da compra por tmpcompra
            $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_tmpcompra', $cod_tmpcompra, PDO::PARAM_INT);
            $stmt -> execute();
            $cod_compra = $stmt->fetch(PDO::FETCH_ASSOC);
            $cod_compra = $cod_compra['cod_compra'];

            //Deleta a compra temporaria
            $sql = "DELETE FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_tmpcompra', $cod_tmpcompra, PDO::PARAM_INT);
            $stmt -> execute();

            //Deleta a compra
            $sql = "DELETE FROM tbl_compra WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();

            $conn = null;
            $stmt = null;
        }else if ($user = 2){
            //Quando se chama a função para o visitante, o parametro é o codigo do produto
            unset($_SESSION['visitante']['carrinho'][$cod_tmpcompra]);
        }
    }

    function mudaCarrinho($cod_tmpcompra, $s){
        $User = CheckUser();

        if ($user = 1)
        {
            $conn = coneccao();

            //Obtem o codigo da compra por tmpcompra
            $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_tmpcompra', $cod_tmpcompra, PDO::PARAM_INT);
            $stmt -> execute();
            $cod_compra = $stmt->fetch(PDO::FETCH_ASSOC);
            $cod_compra = $cod_compra['cod_compra'];

            //Obtem a quantidade de produtos na compra
            $sql = "SELECT quantidade FROM tbl_compra_produto WHERE cod_compra = :cod_compra";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
            $stmt -> execute();
            $quantidade = $stmt->fetch(PDO::FETCH_ASSOC);
            $quantidade = $quantidade['quantidade'];

            if ($quantidade + $s == 0)
            {
                deletaCarrinho($cod_tmpcompra);
            }
            else{
                //Atualiza a quantidade de produtos na compra
                $sql = "UPDATE tbl_compra_produto SET quantidade = :quantidade WHERE cod_compra = :cod_compra";
                $quantidade += $s;
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
                $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt -> execute();
            }

            $conn = null;
            $stmt = null;
        } else if ($user = 2){
            $_SESSION['visitante']['carrinho'][$cod_tmpcompra] += $s;
            if ($_SESSION['visitante']['carrinho'][$cod_tmpcompra] == 0)
            {
                deletaCarrinho($cod_tmpcompra);
            }
        }
    }

    function comprar($cod_produto)
    {
        $user = CheckUser();
        if ($user == 1)
        {
            $conn = coneccao();

            /* Aqui o usuario ja cria uma compra com status concluida, e gera um pdf das informações da compra (unitaria)
            para o usuario, sem passar por tmpCompra */
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $data_hoje = date("Y/m/d");
            $status = 'Concluida';
            $sql = "INSERT INTO tbl_compra VALUES (:status, :data_compra, :cod_usuario)";
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

            $conn = null;
            $stmt = null;
        }
    }

    function finalizarCarrinho(){
        $user = CheckUser();
        if ($user == 1)
        {
            $conn = coneccao();

            //Obtem o codigo da compra por tmpcompra
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt -> execute();
            
            while($compra = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $cod_compra = $compra['cod_compra'];
                $status = 'Concluida';
                //Atualiza o status da compra
                $sql = "UPDATE tbl_compra SET status = :status WHERE cod_compra = :cod_compra";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':status', $status, PDO::PARAM_STR);
                $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt -> execute();

                //Deleta a compra temporaria
                $sql = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt -> execute();
            }

            $conn = null;
            $stmt = null;
        }
    }

    function limparCarrinho(){
        $user = CheckUser();
        if ($user == 1)
        {
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $conn = coneccao();

            //Seleciona todos os registros de tbmCompra e apaga os registros de tmpCompra
            $sql = "SELECT * FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt -> execute();

            while($linha = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $cod_tmpcompra = $linha['cod_tmpcompra'];
                deletaCarrinho($cod_tmpcompra);
            }

            $conn = null;
            $stmt = null;
        }else if ($user == 2){
            unset($_SESSION['visitante']['carrinho']);
        }
    }



    if($_SERVER['RESQUEST_METHOD'] == 'POST')
    {
        $funcao = $_POST['funcao'];
        if($funcao == 'muda+')
        {
            $cod_tmpcompra = $_POST['cod_tmpcompra'];
            mudaCarrinho($cod_tmpcompra, 1);
            header('Location: ../Carrinho/');
        }
        else if ($funcao == 'muda-')
        {
            $cod_tmpcompra = $_POST['cod_tmpcompra'];
            mudaCarrinho($cod_tmpcompra, -1);
            header('Location: ../Carrinho/');
        }
        else if($funcao == 'add' || $funcao == 'add++')
        {
            $cod_produto = $_POST["cod_produto"];
            adicionaCarrinho($cod_produto, 1);
            if ($funcao == 'add')
            {
                header('Location: ../Produtos/#'.$cod_produto);
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
        }
    }
?>