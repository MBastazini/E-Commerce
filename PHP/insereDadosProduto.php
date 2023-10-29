<?php 

include("sessao.php");

    function adicionaProduto()
    {
        $user = CheckUser();

        if($user == 1)
        {
            $conn = coneccao();
            if ($_POST['categoria'] == '')
            {
                $categoria = NULL;
            }
            else{
                $categoria = $_POST['categoria'];
            }
            $margem_lucro = ($_POST['preco'] - $_POST['custo']) / $_POST['custo'];
            $linha = [ 
                'nome'          => $_POST['nome_produto'],   
                'descricao'     => $_POST['descricao'],
                'preco'         => $_POST['preco'], 
                'categoria'     => $categoria,
                'custo'         => $_POST['custo'],
                'icms'          => $_POST['icms'],
                'quantidade'    => $_POST['quantidade'],
                'excluido'      => $_POST['excluido'],
                'margem_lucro'  => $margem_lucro

            ];
            
            try{
                $sql = "INSERT INTO tbl_produto (nome, descricao, preco, categoria, custo, icms, quantidade, excluido, margem_lucro) 
                VALUES (:nome, :descricao, :preco, :categoria, :custo, :icms, :quantidade, :excluido, :margem_lucro)";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
                $stmt -> bindParam(':descricao', $linha['descricao'], PDO::PARAM_STR);
                $stmt -> bindParam(':preco', $linha['preco'], PDO::PARAM_STR);
                $stmt -> bindParam(':categoria', $linha['categoria'], PDO::PARAM_STR);
                $stmt -> bindParam(':custo', $linha['custo'], PDO::PARAM_STR);
                $stmt -> bindParam(':icms', $linha['icms'], PDO::PARAM_STR);
                $stmt -> bindParam(':quantidade', $linha['quantidade'], PDO::PARAM_INT);
                $stmt -> bindParam(':excluido', $linha['excluido'], PDO::PARAM_INT);
                $stmt -> bindParam(':margem_lucro', $linha['margem_lucro'], PDO::PARAM_STR);
                $stmt -> execute();
            }
                catch(PDOException $e){
                echo "<script>alert('Erro ao adicionar produto!');</script>";
            }
            
        
            $conn = null;
            $stmt = null;
        }
    }

    function editaProduto()
    {
        
        $user = CheckUser();

        if($user == 1)
        {
            $conn = coneccao();
            $margem_lucro = ($_POST['preco'] - $_POST['custo']) / $_POST['custo'];
            $linha = [
                'nome'          => $_POST['nome_produto'],   
                'descricao'     => $_POST['descricao'],
                'preco'         => $_POST['preco'], 
                'categoria'     => $_POST['categoria'],
                'custo'         => $_POST['custo'],
                'icms'          => $_POST['icms'],
                'cod_produto'   => $_POST['cod_produto'],
                'quantidade'   => $_POST['quantidade'],
                'margem_lucro'  => $margem_lucro
            ];
        
            try{
                $sql = "UPDATE tbl_produto SET nome = :nome, descricao = :descricao, 
                preco = :preco, categoria = :categoria, custo = :custo, icms = :icms, 
                quantidade = :quantidade, margem_lucro = :margem_lucro
                WHERE cod_produto = :cod_produto";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
                $stmt -> bindParam(':descricao', $linha['descricao'], PDO::PARAM_STR);
                $stmt -> bindParam(':preco', $linha['preco'], PDO::PARAM_STR);
                $stmt -> bindParam(':categoria', $linha['categoria'], PDO::PARAM_STR);
                $stmt -> bindParam(':custo', $linha['custo'], PDO::PARAM_STR);
                $stmt -> bindParam(':icms', $linha['icms'], PDO::PARAM_STR);
                $stmt -> bindParam(':cod_produto', $linha['cod_produto'], PDO::PARAM_INT);
                $stmt -> bindParam(':quantidade', $linha['quantidade'], PDO::PARAM_INT);
                $stmt -> bindParam(':margem_lucro', $linha['margem_lucro'], PDO::PARAM_STR);
                $stmt -> execute();
            }
            catch(PDOException $e){
                echo "<script>alert('Erro ao editar produto!');</script>";
            }
            
        
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
            try{
                $sql = "DELETE FROM tbl_produto WHERE cod_produto = :cod_produto";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                $stmt -> execute();
            }
            catch(PDOException $e){
                echo "<script>alert('Erro ao deletar produto!');</script>";
            }
            
        
            $conn = null;
            $stmt = null;
        }
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = CheckUser();
        if ($user == 1) //ADM
        {
            if($_SESSION['usuario']['adm'])
            {
                $funcao = $_POST['funcao'];
                if($funcao == 'add')
                {
                    adicionaProduto();
                    header("location: ../Conta/crudProdutos.php");
                }
                else if($funcao == 'edit')
                {
                    editaProduto();
                    header("location: ../Conta/crudProdutos.php");
                }
                else if($funcao == 'del')
                {
                    deletaProduto($_POST['cod_produto']);
                    header("location: ../Conta/crudProdutos.php");
                }
            }  
        }
        else{
            header("location: ../");
        }
    }
?>