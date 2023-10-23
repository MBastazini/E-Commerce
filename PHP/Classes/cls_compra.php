<?php 
/*CREATE TABLE tbl_compra(
	cod_compra serial PRIMARY KEY,
	status compra_status not null,
	data_compra date,

	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario)
);*/

class Compra{
    private $cod_compra = null;
    private $status = null;
    private $data_compra = null;
    private $cod_usuario = null;
    private $nome = null;
    private $quantidade = null;
    private $preco = null;
    public function __construct($cod_compra, $status, $data_compra, $cod_usuario, $nome, $quantidade, $preco){
        $this->cod_compra = $cod_compra;
        $this->status = $status;
        $this->data_compra = $data_compra;
        $this->cod_usuario = $cod_usuario;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
    }

    public function getCodCompra(){
        return $this->cod_compra;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getDataCompra(){
        return $this->data_compra;
    }
    
    public function getCodUsuario(){
        return $this->cod_usuario;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function getPreco(){
        return $this->preco;
    }
}
?>