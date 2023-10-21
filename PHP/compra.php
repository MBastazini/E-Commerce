<?php 
    include("caixa.php");
    $conectado = inicioSessao();
    $conn = coneccao();

    //Esse codigo segue o mapa conceitual dado pelo Prof. José Vieira

    function adicionaCarrinho($cod_produto, $quantidade){
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                //Usuario efetua uma compra
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $data_hoje = date("Y/m/d");
                $new_compra = "INSERT INTO tbl_compra VALUES (:status, :data_compra, :cod_usuario)";
                $conn->executaSQL($new_compra, ['status' => 'Pendente', 'data_compra' => $data_hoje, 'cod_usuario' => $cod_usuario]);

                //compra deve linkar-se com um produto
                $cod_compra = $conn->LastInsertId();
                $new_compra_produto = "INSERT INTO tbl_compra_produto VALUES (:quantidade, :cod_produto, :cod_compra)";
                $conn->executaSQL($new_compra_produto, ['quantidade' => $quantidade, 'cod_produto' => $cod_produto, 'cod_compra' => $cod_compra]);

                //Compra registra uma compraTemporaria (que aparecerá no carrinho)
                $new_compra_temporaria = "INSERT INTO tbl_tmpcompra VALUES (:cod_compra)";
                $conn->executaSQL($new_compra_temporaria, ['cod_compra' => $cod_compra]);
            }
            else if ($_SESSION['visitante']['ativo'])
            {
                if (!isset($_SESSION['visitante']['carrinho'][$cod_produto]))
                {
                    $_SESSION['visitante']['carrinho'][$cod_produto] = $quantidade;
                }
            }
            else{
                header('Location: ../ERRO');
            }
        }else{
            header('Location: ../ERRO');
        }
    }

    function verCarrinho(){
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $sql = "SELECT * FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)
                INNER JOIN tbl_compra_produto ON tbl_tmpcompra.cod_compra = tbl_compra_produto.cod_compra
                INNER JOIN tbl_produto ON tbl_compra_produto.cod_produto = tbl_produto.cod_produto";
                $select = $conn->executaSQL($sql, ['cod_usuario' => $cod_usuario]);
                $resultado = $select->fetch();
                return $resultado;
            }
            else{
                header('Location: ../ERRO');
            }
        }else{
            header('Location: ../ERRO');
        }
    }
    /* Ver carrinho visitante:
    foreach ($_SESSION['visitante']['carrinho'] as $cod_produto => $quantidade){
                    $sql = "SELECT * FROM tbl_produto WHERE cod_produto = :cod_produto";
                    $select = $conn->executaSQL($sql, ['cod_produto' => $cod_produto]);
                    $resultado = $select->fetch();
                } */
    function deletaCarrinho($cod_tmpcompra){
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                //Obtem o codigo da compra por tmpcompra
                $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
                $select = $conn->executaSQL($sql, ['cod_tmpcompra' => $cod_tmpcompra]);
                $cod_compra = $select->fetch();

                //Deleta a compra temporaria
                $sql = "DELETE FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
                $conn->executaSQL($sql, ['cod_tmpcompra' => $cod_tmpcompra]);

                //Deleta a compra
                $sql = "DELETE FROM tbl_compra WHERE cod_compra = :cod_compra";
                $conn->executaSQL($sql, ['cod_compra' => $cod_compra]);            
            }
            else if ($_SESSION['visitante']['ativo'])
            {
                //Quando se chama a função para o visitante, o parametro é o codigo do produto
                unset($_SESSION['visitante']['carrinho'][$cod_tmpcompra]);
            }
            else{
                header('Location: ../ERRO');
            }
        }else{
            header('Location: ../ERRO');
        }
    }

    function mudaCarrinho($cod_tmpcompra, $signal){
        if ($signal == '+')
        {
            $s = 1;
        }
        else if ($signal == '-'){
            $s = -1;
        }
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                

                //Obtem o codigo da compra por tmpcompra
                $sql = "SELECT cod_compra FROM tbl_tmpcompra WHERE cod_tmpcompra = :cod_tmpcompra";
                $select = $conn->executaSQL($sql, ['cod_tmpcompra' => $cod_tmpcompra]);
                $cod_compra = $select->fetch();

                //Obtem a quantidade de produtos na compra
                $sql = "SELECT quantidade FROM tbl_compra_produto WHERE cod_compra = :cod_compra";
                $select = $conn->executaSQL($sql, ['cod_compra' => $cod_compra]);
                $quantidade = $select->fetch();

                if ($quantidade + $s == 0)
                {
                    deletaCarrinho($cod_tmpcompra);
                }
                else{
                    //Atualiza a quantidade de produtos na compra
                    $sql = "UPDATE tbl_compra_produto SET quantidade = :quantidade WHERE cod_compra = :cod_compra";
                    $conn->executaSQL($sql, ['quantidade' => $quantidade + $s, 'cod_compra' => $cod_compra]);
                }
            }
            else if ($_SESSION['visitante']['ativo'])
            {
                $_SESSION['visitante']['carrinho'][$cod_tmpcompra] += $s;
                if ($_SESSION['visitante']['carrinho'][$cod_tmpcompra] == 0)
                {
                    deletaCarrinho($cod_tmpcompra);
                }
            }
            else{
                header('Location: ../ERRO');
            }
        }
        else{
            header('Location: ../ERRO');
        }
    }

    function comprar($cod_produto)
    {
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                /* Aqui o usuario ja cria uma compra com status concluida, e gera um pdf das informações da compra (unitaria)
                para o usuario, sem passar por tmpCompra */
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];

                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                $data_hoje = date("Y/m/d");
                $new_compra = "INSERT INTO tbl_compra VALUES (:status, :data_compra, :cod_usuario)";
                $conn->executaSQL($new_compra, ['status' => 'Concluida', 'data_compra' => $data_hoje, 'cod_usuario' => $cod_usuario]);

                $cod_compra = $conn->LastInsertId();
                $new_compra_produto = "INSERT INTO tbl_compra_produto VALUES (:quantidade, :cod_produto, :cod_compra)";
                $conn->executaSQL($new_compra_produto, ['quantidade' => 1, 'cod_produto' => $cod_produto, 'cod_compra' => $cod_compra]);
            }
            else{
                header('Location: ../Login');
            }
        }
        else{
            header('Location: ../ERRO');
        }
    }

    function finalizarCarrinho(){
        if ($conectado){
            if ($_SESSION['usuario']['ativo']){
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                //Seleciona todos os registros de tmpcompra e define o status da compra como concluida, alem disso apaga os registros de tmpCompra
                $sql = "SELECT * FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)";
                $select = $conn->executaSQL($sql, ['cod_usuario' => $cod_usuario]);
                $resultado = $select->fetch();


                foreach ($resultado as $linha){
                    $sql = "UPDATE tbl_compra SET status = :status WHERE cod_compra = :cod_compra";
                    $conn->executaSQL($sql, ['status' => 'Concluida', 'cod_compra' => $linha['cod_compra']]);
                    $sql = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
                    $conn->executaSQL($sql, ['cod_compra' => $linha['cod_compra']]);
                }
            }
            else{
                header('Location: ../Login');
            }
        }   
        else{
            header('Location: ../ERRO');
        }
    }

    function limparCarrinho(){
        if ($conectado)
        {
            if ($_SESSION['usuario']['ativo'])
            {
                $cod_usuario = $_SESSION['usuario']['cod_usuario'];
                //Seleciona todos os registros de tbmCompra e apaga os registros de tmpCompra
                $sql = "SELECT * FROM tbl_tmpcompra WHERE cod_compra IN (SELECT cod_compra FROM tbl_compra WHERE cod_usuario = :cod_usuario)";
                $select = $conn->executaSQL($sql, ['cod_usuario' => $cod_usuario]);
                $resultado = $select->fetch();

                foreach ($resultado as $linha){
                    $sql = "DELETE FROM tbl_tmpcompra WHERE cod_compra = :cod_compra";
                    $conn->executaSQL($sql, ['cod_compra' => $linha['cod_compra']]);
                    $sql = "DELETE FROM tbl_compra WHERE cod_compra = :cod_compra";
                    $conn->executaSQL($sql, ['cod_compra' => $linha['cod_compra']]);
                }
            }
            else if ($_SESSION['visitante']['ativo'])
            {
                unset($_SESSION['visitante']['carrinho']);
            }
            else{
                header('Location: ../ERRO');
            }
        }else{
            header('Location: ../ERRO');
        }
    }

?>