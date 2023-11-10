<?php 
/* CREATE TABLE tbl_token(
	cod_token serial PRIMARY KEY,
	token varchar(100) not null,
	data_criacao date not null,
	ip_criacao varchar(15),
	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario)
); */

class Token{
    private $cod_token = null;
    private $token = null;
    private $data_criacao = null;
    private $cod_usuario = null;

    public function __construct($cod_token, $token, $data_criacao, $cod_usuario){
        $this->cod_token = $cod_token;
        $this->token = $token;
        $this->data_criacao = $data_criacao;
        $this->cod_usuario = $cod_usuario;
    }

    public function getCodToken(){
        return $this->cod_token;
    }

    public function getToken(){
        return $this->token;
    }

    public function getDataCriacao(){
        return $this->data_criacao;
    }

    public function getCodUsuario(){
        return $this->cod_usuario;
    }
}
?>