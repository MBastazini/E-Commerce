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
    private $quantidade = null;
    private $margem_lucro = null;
    public function __construct($cod_produto, $nome, $descricao, $preco, $categoria, $custo, $excluido, $icms, $quantidade, $margem_lucro){
        $this->cod_produto = $cod_produto;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->categoria = $categoria;
        $this->custo = $custo;
        $this->excluido = $excluido;
        $this->icms = $icms;
        $this->quantidade = $quantidade;
        $this->margem_lucro = $margem_lucro;
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
        return $this->excluido;
    }

    public function getIcms(){
        return $this->icms;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function setCodProduto($cod_produto){
        $this->cod_produto = $cod_produto;
    }
    
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

    public function setPreco($preco){
        $this->preco = $preco;
    }

    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

    public function setCusto($custo){
        $this->custo = $custo;
    }

    public function setExcluido($excluido){
        $this->excluido = $excluido;
    }

    public function setIcms($icms){
        $this->icms = $icms;
    }

    public function setQuantidade($quantidade){
        $this->quantidade = $quantidade;
    }

    public function getMarginLucro(){
        return $this->margem_lucro;
    }

    public function setMarginLucro($margem_lucro){
        $this->margem_lucro = $margem_lucro;
    }
}

?>