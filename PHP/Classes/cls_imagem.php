<?php 

class Imagem{

    private $cod_imagem = null;
    private $imagem = null;
    private $nome_img = null;

    public function __construct($cod_imagem, $imagem, $nome_img){
        $this->cod_imagem = $cod_imagem;
        $this->imagem = $imagem;
        $this->nome_img = $nome_img;
    }

    public function getCodImagem(){
        return $this->cod_imagem;
    }

    public function getImagem(){
        return $this->imagem;
    }

    public function getNomeImg(){
        return $this->nome_img;
    }
}


?>