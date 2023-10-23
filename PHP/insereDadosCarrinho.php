<?php 
    //include("sessao.php");
    include("caixa.php");
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

        if ($user == 1)
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

            //Deleta da tbl_compra_produto
            $sql = "DELETE FROM tbl_compra_produto WHERE cod_compra = :cod_compra";
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
        }else if ($user = 2){
            //Quando se chama a função para o visitante, o parametro é o codigo do produto
            unset($_SESSION['visitante']['carrinho'][$cod_tmpcompra]);
        }
    }

    function mudaCarrinho($cod_tmpcompra, $s){
        $user = CheckUser();

        if ($user == 1)
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
            $nome_usuario = $_SESSION['usuario']['nome'];
            $data_hoje = date("Y/m/d");
            $status = 'Concluida';
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

            $sql = "SELECT * FROM tbl_produto WHERE cod_produto = :cod_produto";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
            $stmt -> execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            $preco = $produto['preco'];
            $nome = $produto['nome'];

            $conn = null;
            $stmt = null;
            $html= "
                        <h1>TINYWOOD - Viva CTI 2023<h1><br><br>

                        <h1>Compra finalizada</h1><br>
                        <h2>Nome: $nome_usuario</h2><br>
                        <h2>Codigo do usuario: $cod_usuario</h2><br>
                        <br>
                        <br>
                        <h1>Compras efetuadas:</h1><br>
                        <h1> Produto | Quantidade | Preço </h1><br><br>
                        <h2>".$nome." ||| 1 ||| R$ ".$preco ."</h2><br>
                        <br>
                        <h1>Valor total da compra: R$ ". $preco ."</h1>
            ";
            gerapdf($html);
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

            //Obtem o codigo da compra por tmpcompra
            $cod_usuario = $_SESSION['usuario']['cod_usuario'];
            $nome_usuario = $_SESSION['usuario']['nome'];
            $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)";
            $stmt = $conn->prepare($sql);
            $stmt -> bindParam(':cod_usuario', $cod_usuario, PDO::PARAM_INT);
            $stmt -> execute();
            
            $html= "
                        <h1>TINYWOOD - Viva CTI 2023<h1><br><br>

                        <h1>Compra finalizada</h1><br>
                        <h2>Nome: $nome_usuario</h2><br>
                        <h2>Codigo do usuario: $cod_usuario</h2><br>
                        <br>
                        <br>
                        <h1>Compras efetuadas:</h1><br>
                        <h1> Produto | Quantidade | Preço </h1><br><br>
                    ";

            $valor_total = 0;
            while($compra = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $cod_compra = $compra['cod_compra'];
                $status = 'Concluida';
                //Atualiza o status da compra
                $sql2 = "UPDATE tbl_compra SET status = :status WHERE cod_compra = :cod_compra";
                $stmt2 = $conn->prepare($sql2);
                $stmt2 -> bindParam(':status', $status, PDO::PARAM_STR);
                $stmt2 -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt2 -> execute();
                //Deleta a compra temporaria
                $sql2 = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
                $stmt2 = $conn->prepare($sql2);
                $stmt2 -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt2 -> execute(); 

                //Obtem nome, quantidade e preço dessa compra (quantidade é FK de tbl_compra_produto)
                
                $sql2 = "SELECT p.nome, p.preco, cp.quantidade FROM tbl_compra AS c
                INNER JOIN tbl_compra_produto AS cp ON c.cod_compra = cp.cod_compra
                INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
                WHERE c.cod_compra = :cod_compra";
                $stmt2 = $conn->prepare($sql2);
                $stmt2 -> bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
                $stmt2 -> execute();
                $compra = $stmt2->fetch(PDO::FETCH_ASSOC);
                $nome = $compra['nome'];
                $preco = $compra['preco'];
                $quantidade = $compra['quantidade'];
                $valor_total += $preco * $quantidade;
                    $html .= "
                            <h2>$nome ||| $quantidade ||| $preco </h2><br>
                        ";
            }

            $conn = null;
            $stmt = null;
            $stmt2 = null;
            
            $html .= "
                        <br>
                        <h1>Valor total da compra: R$ ". $valor_total ."</h1>
                        ";
            gerapdf($html);
            //header('Location: ../');
        }
        else{
            header('Location: ../Login/');
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



    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
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
        else if($funcao == 'comprar')
        {
            $cod_produto = $_POST['cod_produto'];
            comprar($cod_produto);
        }
    }
?>