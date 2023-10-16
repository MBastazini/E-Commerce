CREATE TABLE tbl_produto(
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
);

CREATE TABLE tbl_compra(
	cod_compra serial PRIMARY KEY,
	status varchar(100),
	data_compra date
);

CREATE TABLE tbl_usuario(
	cod_usuario serial PRIMARY KEY,
	nome varchar(120) not null,
	email varchar(100) not null,
	senha varchar(40) not null,
	telefone varchar(13) not null
);

CREATE TABLE tbl_compra_produto(
	cod_compra_produto serial PRIMARY KEY,
	quantidade numeric (10) not null,
	cod_produto serial,
	FOREIGN KEY (cod_produto) REFERENCES tbl_produto(cod_produto),

	cod_compra serial,
	FOREIGN KEY (cod_compra) REFERENCES tbl_compra(cod_compra)
);

CREATE TABLE tbl_tmpcompra(
	cod_compra serial PRIMARY KEY,
	sessão varchar(100),
	FOREIGN KEY (cod_compra) REFERENCES tbl_compra(cod_compra)
);


INSERT INTO tbl_produto VALUES 
(1,'chaveiro_info','chaveiro de informatica',5.90,false,'5-9-2023','chaveiro1',2.90, 2.00,1.00,'i' ),
(2,'chaveiro_mec','chaveiro de mecanica',5.90,false,'5-9-2023','chaveiro2',2.90, 2.00,1.00,'m' ),
(3,'chaveiro_elet','chaveiro de eletronica',5.90,false,'5-9-2023','chaveiro3',2.90, 2.00,1.00,'e' );

INSERT INTO tbl_usuario VALUES
(0,'TinyWood', 'tinywoodcti@gmail.com', 'LLMMM2023', '5514123456789'),
(2,'Roberto Silva', 'roberto@gmail.com', 'Roberto123',    '5514987654321'),
(3,'Rodolfo Carlos', 'rodolfo@gmail.com', 'Rodolfo123',   '5514918273645');

INSERT INTO tbl_compra VALUES
(1,'comprando','2023-10-01'),
(2,'finalizado','2023-09-29'),
(3,'comprando','2023-09-30' );

INSERT INTO tbl_compra_produto VALUES
(1,5,2),
(2,3,1),
(3,2,3);

INSERT INTO tbl_tmpcompra VALUES
(1,'conectado'),
(2,'desconectado'),
(3,'conectado');

SELECT * FROM tbl_produto WHERE cod_produto = '1';

SELECT * FROM tbl_usuario WHERE cod_usuario = '3';

SELECT prod.cod_produto , prod.nome , usu.cod_usuario FROM tbl_produto AS 
prod INNER JOIN tbl_usuario AS usu ON usu.cod_usuario = prod.cod_produto;

SELECT prod.cod_produto, prod.nome, usu.cod_usuario FROM tbl_produto AS prod
FULL OUTER JOIN tbl_usuario AS usu ON usu.cod_usuario = prod.cod_produto
WHERE prod.cod_produto = '1' OR prod.cod_produto = '2';

SELECT prod.cod_produto, prod.nome, usu.cod_usuario FROM tbl_produto AS prod
FULL JOIN tbl_usuario AS usu ON usu.cod_usuario = prod.cod_produto;

SELECT comp.cod_compra , comp.status , usu.cod_usuario FROM tbl_compra AS 
comp INNER JOIN tbl_usuario AS usu ON usu.cod_usuario = comp.cod_compra;

SELECT comprod.cod_compra_produto ,comprod.quantidade , tmp.cod_compra FROM tbl_compra_produto AS 
comprod INNER JOIN tbl_tmpcompra AS tmp ON tmp.cod_compra = comprod.cod_compra_produto;













