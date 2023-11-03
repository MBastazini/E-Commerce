<?php 
class Compra_produto{
    private $cod_produto = null;
    private $quantidade = null;
    private $nome = null;
    private $preco = null;

    public function __construct($cod_produto, $quantidade, $nome, $preco){
        $this->cod_produto = $cod_produto;
        $this->quantidade = $quantidade;
        $this->nome = $nome;
        $this->preco = $preco;
    }

    public function getCodProduto(){
        return $this->cod_produto;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getPreco(){
        return $this->preco;
    }
        
}
?>