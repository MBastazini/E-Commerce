<?php 
/* CREATE TABLE tbl_usuario(
	cod_usuario serial PRIMARY KEY,
	nome varchar(120) not null,
	email varchar(100) not null,
	senha varchar(40) not null,
	telefone varchar(13) not null
); */

class Usuario{
    private $cod_usuario = null;
    private $nome = null;
    private $email = null;
    private $senha = null;
    private $telefone = null;

    public function __construct($cod_usuario, $nome, $email, $senha, $telefone){
        $this->cod_usuario = $cod_usuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
    }

    public function getCodUsuario(){
        return $this->cod_usuario;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getTelefone(){
        return $this->telefone;
    }   

}
?>