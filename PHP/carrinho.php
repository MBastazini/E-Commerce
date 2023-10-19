<?php  
    include("caixa.php");
    function adicionaCarrinho($cod_produto, $cod_usuario)
    {
        //Obtem a quantidade de dados em tbl_compra e quarda na variavel $codigo
        $conn = coneccao();
        $sql = "select count(*) from tbl_compra";
        $select = $conn->prepare($sql);
        $select->execute();
        $codigo = $select->fetch();

        //Insere uma nova compra na tbm_compra com o codigo da compra sendo o numero de dados + 1
        $linha = [
            'cod_compra' => $codigo[0] + 1,
            'status' => 'comprando',
            'data_compra' => NULL,
        ];
        $sql = "insert into tbl_compra (cod_compra, status, data_compra) values (:cod_compra, :status, :data_compra)";
        $insert = $conn->prepare($sql);
        $insert->execute($linha);

        //Insere um dado na tbl_compra_produto usando o codigo da compra e o codigo do produto
        $linha = [
            'cod_compra' => $codigo[0] + 1,
            'cod_produto' => $cod_produto,
            'cod_usuario' => $cod_usuario,
            'quantidade' => 1,
        ];
        $sql = "insert into tbl_compra_produto (cod_compra, cod_produto, cod_usuario, quantidade) values (:cod_compra, :cod_produto, :cod_usuario, :quantidade)";
        $insert = $conn->prepare($sql);
        $insert->execute($linha);


    }

    function mudaCarrinho($cod_compra_produto, $signal)
    {
        //Estudar melhor.
        if ($signal == '+')
        {
            $s = 1;
        }
        else if ($signal == '-'){
            $s = -1;
        }

        $conn = coneccao();
        $sql = "select quantidade from tbl_compra_produto where cod_compra_produto = :cod_compra_produto";
        $select = $conn->prepare($sql);
        $select->execute(['cod_compra_produto' => $cod_compra_produto]);
        $quantidade = $select->fetch();

        $nova_quantidade = $quantidade[0] + $s;

        if ($nova_quantidade == 0)
        {
            deletaCarrinho($cod_compra_produto);
        }
        else{
            $sql = "update tbl_compra_produto set quantidade = :quantidade where cod_compra_produto = :cod_compra_produto";
            $update = $conn->prepare($sql);
            $update->execute(['quantidade' => $nova_quantidade, 'cod_compra_produto' => $cod_compra_produto]);

            
            header('Location: ../Carrinho');
        }
    }

    function deletaCarrinho($cod_compra_produto)
    {   
        //O cod_compra e cod_compra_produto supostamente sempre é o mesmo, mas para não correr riscos fazemos uma seleção.
        $conn = coneccao();
        $sql = "select cod_compra from tbl_compra_produto where cod_compra_produto = :cod_compra_produto";
        $select = $conn->prepare($sql);
        $select->execute(['cod_compra_produto' => $cod_compra_produto]);
        $cod_compra = $select->fetch();

        $sql = "delete from tbl_compra_produto where cod_compra_produto = :cod_compra_produto";
        $delete = $conn->prepare($sql);
        $delete->execute(['cod_compra_produto' => $cod_compra_produto]);

        $sql = "delete from tbl_compra where cod_compra = :cod_compra";
        $delete = $conn->prepare($sql);
        $delete->execute(['cod_compra' => $cod_compra[0]]);

        header('Location: ../Carrinho');
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $funcao = $_POST["funcao"];
        $cod_compra_produto = $_POST["cod_compra_produto"];
        if ($funcao == 'muda+')
        {
            mudaCarrinho($cod_compra_produto, '+');
        }
        else if ($funcao == 'muda-')
        {
            mudaCarrinho($cod_compra_produto, '-');
        }
    }
?>