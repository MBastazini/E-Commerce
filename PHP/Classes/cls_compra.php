<?php 
/*CREATE TABLE tbl_compra(
	cod_compra serial PRIMARY KEY,
	status compra_status not null,
	data_compra date,

	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario)
);*/
require_once("cls_compra_produto.php");

class Compra{
    private $cod_compra = null;
    private $status = null;
    private $data_compra = null;
    private $valor_total = null;
    private $cod_usuario = null;

    private $compras = array();
    public function __construct($cod_compra, $status, $data_compra, $cod_usuario){
        $this->cod_compra = $cod_compra;
        $this->status = $status;
        $this->data_compra = $data_compra;
        $this->cod_usuario = $cod_usuario;
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


    public function createCompra($cod_produto, $quantidade, $nome, $preco){
        $compra_produto = new Compra_produto($cod_produto, $quantidade, $nome, $preco);
        array_push($this->compras, $compra_produto);
    }

    public function getCompras(){
        return $this->compras;
    }

    public function getValorTotal(){
        return $this->valor_total;
    }

    public function setValor_total($valor_total){
        $this->valor_total = $valor_total;
    }

    public function getCodUsuario(){
        return $this->cod_usuario;
    }
}
?>