<?php 
/* CREATE TABLE tbl_produto(
	cod_produto serial PRIMARY KEY,
	nome text not null,
	descricao text not null,
	preco numeric(10,2) not null,
	excluido boolean not null,
	data_exclusao timestamp not null,
	codigovisual varchar(50) not null,
	custo numeric(10,2) not null,
	margem_lucro numeric(10,2) not null,
	icms numeric(10,2) not null,
	imagem varchar not null,
	categoria varchar(10) not null
); */
class Produto{
    private $cod_produto = null;
    private $nome = null;
    private $descricao = null;
    private $preco = null;
    private $categoria = null;
    private $custo = null;
    private $excluido = null;
    private $icms = null;
    private $estoque = null;
    private $margem_lucro = null;
    private $imagem = null;
    
    public function __construct($cod_produto, $nome, $descricao, $preco, 
    $categoria, $custo, $excluido, $icms, $estoque, $margem_lucro, $imagem){
        $this->cod_produto = $cod_produto;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->categoria = $categoria;
        $this->custo = $custo;
        $this->excluido = $excluido;
        $this->icms = $icms;
        $this->estoque = $estoque;
        $this->margem_lucro = $margem_lucro;
        $this->imagem = $imagem;
    }

    public function getCodProduto(){
        return $this->cod_produto;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function getCategoria(){
        return $this->categoria;
    }   

    public function getCusto(){
        return $this->custo;
    }

    public function getExcluido(){
        if ($this->excluido == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getIcms(){
        return $this->icms;
    }

    public function getEstoque(){
        return $this->estoque;
    }

    public function getImagem(){
        return $this->imagem;
    }
    
    public function setEstoque($estoque){
        $this->estoque = $estoque;
    }

    public function getMarginLucro(){
        return $this->margem_lucro;
    }
}

?>