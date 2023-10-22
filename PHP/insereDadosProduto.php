<?php 

include("sessao.php");

function adicionaProduto()
{
    $user = CheckUser();

    if($user == 1)
    {
        $conn = coneccao();
        $linha = [ 
            'nome'          => $_POST['nome'],   
            'descricao'     => $_POST['descricao'],
            'preco'         => $_POST['preco'], 
            'categoria'     => $_POST['categoria'],
            'custo'         => $_POST['custo'],
            'icms'          => $_POST['icms']
        ];
    
        $sql = "INSERT INTO tbl_produto (nome, descricao, preco, categoria, custo, icms) VALUES (:nome, :descricao, :preco, :categoria, :custo, :icms)";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
        $stmt -> bindParam(':descricao', $linha['descricao'], PDO::PARAM_STR);
        $stmt -> bindParam(':preco', $linha['preco'], PDO::PARAM_STR);
        $stmt -> bindParam(':categoria', $linha['categoria'], PDO::PARAM_STR);
        $stmt -> bindParam(':custo', $linha['custo'], PDO::PARAM_STR);
        $stmt -> bindParam(':icms', $linha['icms'], PDO::PARAM_STR);
        $stmt -> execute();
    
        $conn = null;
        $stmt = null;
    }
}

function editaProduto($nome, $descricao, $preco, $categoria, $custo, $icms, $cod_produto)
{
    $user = CheckUser();

    if($user == 1)
    {
        $conn = coneccao();
        $linha = [ 
            'nome'          => $nome,   
            'descricao'     => $descricao,
            'preco'         => $preco, 
            'categoria'     => $categoria,
            'custo'         => $custo,
            'icms'          => $icms,
            'cod_produto'   => $cod_produto
        ];
    
        $sql = "UPDATE tbl_produto SET nome = :nome, descricao = :descricao, preco = :preco, categoria = :categoria, custo = :custo, icms = :icms WHERE cod_produto = :cod_produto";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
        $stmt -> bindParam(':descricao', $linha['descricao'], PDO::PARAM_STR);
        $stmt -> bindParam(':preco', $linha['preco'], PDO::PARAM_STR);
        $stmt -> bindParam(':categoria', $linha['categoria'], PDO::PARAM_STR);
        $stmt -> bindParam(':custo', $linha['custo'], PDO::PARAM_STR);
        $stmt -> bindParam(':icms', $linha['icms'], PDO::PARAM_STR);
        $stmt -> bindParam(':cod_produto', $linha['cod_produto'], PDO::PARAM_INT);
        $stmt -> execute();
    
        $conn = null;
        $stmt = null;
    }
}

function deletaProduto($cod_produto)
{
    $user = CheckUser();

    if($user == 1)
    {
        $conn = coneccao();
        $sql = "DELETE FROM tbl_produto WHERE cod_produto = :cod_produto";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
        $stmt -> execute();
    
        $conn = null;
        $stmt = null;
    }
}
?>