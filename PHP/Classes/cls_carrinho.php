<?php 
class Carrinho{
    private $nome = null;
    private $preco = null;
    private $quantidade = null;
    private $cod_produto = null;
    private $cod_tmpcompra = null;

    public function __construct($nome, $preco, $quantidade, $cod_produto, $cod_tmpcompra){
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->cod_produto = $cod_produto;
        $this->cod_tmpcompra = $cod_tmpcompra;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function getCodProduto(){
        return $this->cod_produto;
    }

    public function getCodTmpCompra(){
        return $this->cod_tmpcompra;
    }
}
?>