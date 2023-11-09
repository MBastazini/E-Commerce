<?php 

include("sessao.php");

    function adcionaImagem(){
        //Adiciona a imagem no BD:
        $conn = coneccao();
        $nome = explode(".", $_FILES["fileToUpload"]["name"])[0];
        $caminho_img = "Imagens/Produtos/" . $_FILES["fileToUpload"]["name"];

        $sql = "INSERT INTO tbl_imagem_produto (nome_img, imagem) VALUES (:nome, :imagem)";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam(':imagem', $caminho_img, PDO::PARAM_STR);
        $stmt -> execute();

        $stmt = null;
        $conn = null;

        //Adiciona a imagem
        $targer_dir = "/home/projetoscti/www/projetoscti14/Imagens/Produtos/";
        //Mudar aqui para o nome do arquivo no pc do cara.
        $targer_file = $targer_dir . $_FILES["fileToUpload"]["name"];
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($targer_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                header('Location: ../Conta/crudImagens.php#arquivo-nao-e-uma-imagem');
                exit();
            }
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            $uploadOk = 0;
            header('Location: ../Conta/crudImagens.php#arquivo-muito-grande');
            exit();    
        }


        // Allow certain file formats
        if($imageFileType != "jpg") {
            $uploadOk = 0;
            header('Location: ../Conta/crudImagens.php#formato-de-arquivo-nao-suportado-(Apenas-JPG)');
            exit();
        }


        // if everything is ok, try to upload file
        //Caminho do file (com nome certo)
        
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targer_file)) {
                echo "The file ". basename( $targer_file). " has been uploaded.";
                header('Location: ../Conta/crudImagens.php#imagem-adicionada-com-sucesso');
            } else {
                header('Location: ../Conta/crudImagens.php#houve-um-erro-ao-fazer-upload-do-arquivo');
                exit();
            }

        } else {
            header('Location: ../Conta/crudImagens.php#a-imagem-nao-foi-enviada');
        }

    }

    function deletaImagem(){
        $conn = coneccao();
        $cod_imagem = $_POST['cod_imagem'];
        $sql = "DELETE FROM tbl_imagem_produto WHERE cod_imagem = :cod_imagem";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':cod_imagem', $cod_imagem, PDO::PARAM_INT);
        $stmt -> execute();

        $stmt = null;
        $conn = null;
        
        header('Location: ../Conta/crudImagens.php#imagem-deletada-com-sucesso-(lembre-de-a-deletar-manualmente-no-servidor)');
    }
    function adicionaProduto()
    {
        $user = CheckUser();

        if($user == 1)
        {
            if ($_SESSION['usuario']['adm'])
            {
                $conn = coneccao();
                if ($_POST['categoria'] == 'NONE')
                {
                    $categoria = NULL;
                }
                else{
                    $categoria = $_POST['categoria'];
                }

                if ($_POST['quantidade'] <= 0)
                {
                    $estoque = $_POST['quantidade'] = 0;
                }
                else{
                    $estoque = $_POST['quantidade'];
                }

                $excluido = isset($_POST['excluido']) && $_POST['excluido'] == 1;
                $margem_lucro = ($_POST['preco'] - $_POST['custo']) / $_POST['custo'];
                $linha = [ 
                    'nome'          => $_POST['nome_produto'],   
                    'descricao'     => $_POST['descricao'],
                    'preco'         => $_POST['preco'], 
                    'categoria'     => $categoria,
                    'custo'         => $_POST['custo'],
                    'icms'          => $_POST['icms'],
                    'estoque'       => $estoque,
                    'excluido'      => $excluido,
                    'margem_lucro'  => $margem_lucro,
                    'imagem'        => $_POST['imagens']

                ];
                
                //try{
                    $sql = "INSERT INTO tbl_produto (nome, descricao, preco, categoria, custo, icms, estoque, excluido, margem_lucro, imagem) 
                    VALUES (:nome, :descricao, :preco, :categoria, :custo, :icms, :estoque, :excluido, :margem_lucro, :imagem)";
                    $stmt = $conn->prepare($sql);
                    $stmt -> bindParam(':nome', $linha['nome'], PDO::PARAM_STR);
                    $stmt -> bindParam(':descricao', $linha['descricao'], PDO::PARAM_STR);
                    $stmt -> bindParam(':preco', $linha['preco'], PDO::PARAM_STR);
                    $stmt -> bindParam(':categoria', $linha['categoria'], PDO::PARAM_STR);
                    $stmt -> bindParam(':custo', $linha['custo'], PDO::PARAM_STR);
                    $stmt -> bindParam(':icms', $linha['icms'], PDO::PARAM_STR);
                    $stmt -> bindParam(':estoque', $linha['estoque'], PDO::PARAM_INT);
                    $stmt -> bindParam(':excluido', $linha['excluido'], PDO::PARAM_INT);
                    $stmt -> bindParam(':margem_lucro', $linha['margem_lucro'], PDO::PARAM_STR);
                    $stmt -> bindParam(':imagem', $linha['imagem'], PDO::PARAM_STR);
                    $stmt -> execute();
                //}
                //catch(PDOException $e){
                //    $mensagem = $e->getMessage();
                //    str_replace(" ", "-", $mensagem);
                //    Header('Location: ../Conta/crudProdutos.php#erro-PDO');
                //}
                

            
                $conn = null;
                $stmt = null;
            }
        }
    }

    function editaProduto()
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
            $excluido = isset($_POST['excluido']) && $_POST['excluido'] == 1;
            echo $excluido;
            if ($_POST['quantidade'] <= 0)
            {
                $quantidade = $_POST['quantidade'] = 0;
            }
            else{
                $quantidade = $_POST['quantidade'];
            }

            $linha = [
                'nome'          => $_POST['nome_produto'],   
                'descricao'     => $_POST['descricao'],
                'preco'         => $_POST['preco'], 
                'categoria'     => $categoria,
                'custo'         => $_POST['custo'],
                'icms'          => $_POST['icms'],
                'cod_produto'   => $_POST['cod_produto'],
                'quantidade'    => $quantidade,
                'excluido'      => $excluido,
                'margem_lucro'  => $margem_lucro
            ];
            
            try{
                $sql = "UPDATE tbl_produto SET nome = :nome, descricao = :descricao, 
                preco = :preco, categoria = :categoria, custo = :custo, icms = :icms, 
                quantidade = :quantidade, margem_lucro = :margem_lucro, excluido = :excluido
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
                $stmt -> bindParam(':excluido', $linha['excluido'], PDO::PARAM_INT);
                $stmt -> execute();
            }
            catch(PDOException $e){
                echo "<script>alert('Erro ao editar produto!');</script>";
            }

            $conn = null;
            $stmt = null;


        }
    }

    function restauraProduto($cod_produto)
    {
        $user = CheckUser();

        if($user == 1)
        {
            $conn = coneccao();
            try{
                $sql = "UPDATE tbl_produto SET excluido = false WHERE cod_produto = :cod_produto";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                $stmt -> execute();
            }
            catch(PDOException $e){
                $mensagem = $e->getMessage();
                str_replace(" ", "-", $mensagem);
                Header('Location: ../Conta/crudProdutos.php#' . $mensagem);
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
                $sql = "UPDATE tbl_produto SET excluido = true WHERE cod_produto = :cod_produto";
                $stmt = $conn->prepare($sql);
                $stmt -> bindParam(':cod_produto', $cod_produto, PDO::PARAM_INT);
                $stmt -> execute();
            }
            catch(PDOException $e){
                $mensagem = $e->getMessage();
                str_replace(" ", "-", $mensagem);
                Header('Location: ../Conta/crudProdutos.php#' . $mensagem);
                $cod_produto = 0;
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
                    //header("location: ../Conta/crudProdutos.php#produto-adicionado-com-sucesso");
                }
                else if($funcao == 'edit')
                {
                    editaProduto();
                    header("location: ../Conta/crudProdutos.php#produto-editado-com-sucesso");
                }
                else if($funcao == 'del')
                {
                    deletaProduto($_POST['cod_produto']);
                    header("location: ../Conta/crudProdutos.php#produto-excluido-com-sucesso");
                }
                else if ($funcao == 'res')
                {
                    restauraProduto($_POST['cod_produto']);
                    header("location: ../Conta/crudProdutos.php#produto-restaurado-com-sucesso");
                }
                else if ($funcao == 'add_img'){
                    adcionaImagem();
                }
                else if ($funcao == 'del_img'){
                    deletaImagem();
                }
                else{
                    header("location: ../Conta/crudProdutos.php");
                }
            }  
        }
        else{
            header("location: ../");
        }
    }
?>