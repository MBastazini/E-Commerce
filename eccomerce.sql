CREATE TABLE tbl_produto(
	cod_produto serial PRIMARY KEY,
	nome text not null,
	descricao text not null,
	preco numeric(10,2) not null,
	excluido boolean not null,
	data_exclusao timestamp not null, /* precisa? */
	custo numeric(10,2) not null,
	margem_lucro numeric(10,2) not null, /* é so caucula na hora */
	icms numeric(10,2) not null, 
	categoria varchar(10) not null
	estoque integer not null

	imagem serial,
	FOREIGN KEY (imagem) REFERENCES tbl_imagem_produto(cod_imagem)
);

CREATE TABLE tbl_imagem_produto(
	cod_imagem serial PRIMARY KEY,
	imagem varchar(200) not null,
	nome_img varchar(100) not null
);
ALTER TABLE tbl_produto DROP COLUMN quantidade;
ALTER TABLE tbl_produto ADD COLUMN estoque integer;
UPDATE tbl_produto SET estoque = 10;
ALTER TABLE tbl_produto ALTER COLUMN estoque SET NOT NULL;

ALTER TABLE tbl_produto ADD COLUMN categoria categorias;

CREATE TABLE tbl_token(
	cod_token serial PRIMARY KEY,
	token varchar(100) not null,
	data_criacao TIMESTAMP not null,
	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario)
);
ALTER TABLE tbl_token ADD COLUMN ip_criacao varchar(15);

/*Compra já efetuada*/
CREATE TABLE tbl_compra(
	cod_compra serial PRIMARY KEY,
	status compra_status not null,
	data_compra date,

	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario)
);


CREATE TABLE tbl_compra_produto(
	quantidade numeric (10) not null,
	cod_produto serial,
	FOREIGN KEY (cod_produto) REFERENCES tbl_produto(cod_produto),

	cod_compra serial,
	FOREIGN KEY (cod_compra) REFERENCES tbl_compra(cod_compra)
);


CREATE TABLE tbl_tmpcompra(
	cod_usuario serial,
	FOREIGN KEY (cod_usuario) REFERENCES tbl_usuario(cod_usuario),
	cod_compra serial,
	FOREIGN KEY (cod_compra) REFERENCES tbl_compra(cod_compra),
	PRIMARY KEY (cod_usuario, cod_compra)
);

CREATE TABLE tbl_usuario(
	cod_usuario serial PRIMARY KEY,
	nome varchar(120) not null,
	email varchar(100) not null,
	senha varchar(40) not null,
	telefone varchar(13) not null
);

CREATE TYPE tipo AS ENUM ('Informática', 'Mecânica', 'Eletrônica', 'CTI');
ALTER TABLE tbl_produto ADD COLUMN categoria tipo;
CREATE TYPE compra_status AS ENUM ('Concluida', 'Pendente', 'Cancelada');


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

SELECT p.nome, p.preco, cp.quantidade, c.data_compra, c.status FROM tbl_compra_produto AS cp 
INNER JOIN tbl_produto AS p ON p.cod_produto = cp.cod_produto 
INNER JOIN tbl_compra AS c ON c.cod_compra = cp.cod_compra
WHERE c.status = 'finalizado';

SELECT p.nome, p.preco, cp.quantidade, c.status FROM tbl_compra_produto AS cp
INNER JOIN tbl_produto AS p ON p.cod_produto = cp.cod_produto
INNER JOIN tbl_compra AS c ON c.cod_compra = cp.cod_compra
WHERE c.status = 'comprando' AND cp.cod_usuario = '1';

SELECT * FROM tbl_tmpcompra 
INNER JOIN tbl_compra_produto ON tbl_tmpcompra.cod_compra = tbl_compra_produto.cod_compra
INNER JOIN tbl_produto ON tbl_compra_produto.cod_produto = tbl_produto.cod_produto
INNER JOIN tbl_compra ON tbl_compra.cod_compra = tbl_compra_produto.cod_compra
WHERE tbl_compra.cod_usuario = '1';

SELECT * FROM tbl_tmpcompra 
INNER JOIN tbl_compra ON tbl_tmpcompra.cod_compra = tbl_compra.cod_compra
INNER JOIN tbl_compra_produto ON tbl_compra.cod_compra = tbl_compra_produto.cod_compra
WHERE tbl_compra.cod_usuario = '1' AND tbl_compra_produto.cod_produto = '1';


INSERT INTO tbl_compra (status, data_compra, cod_usuario) VALUES ('comprando', '2023-10-01', '1');

INSERT INTO tbl_compra_produto (quantidade, cod_produto, cod_compra) VALUES ('1', '1', '1');

INSERT INTO tbl_tmpcompra (cod_compra) VALUES ('1');

SELECT p.nome, p.preco, p.cod_produto, cp.quantidade FROM tbl_tmpcompra
INNER JOIN tbl_compra ON tbl_tmpcompra.cod_compra = tbl_compra.cod_compra
INNER JOIN tbl_compra_produto AS cp ON tbl_compra.cod_compra = cp.cod_compra
INNER JOIN tbl_produto AS p ON cp.cod_produto = p.cod_produto
WHERE tbl_compra.cod_usuario = '1';



INSERT INTO tbl_produto (nome, descricao, preco, excluido, custo, margem_lucro, icms, categoria, imagem, estoque) VALUES 
('Chaveiro CPU','Chaveiro com o simbolo de um processador (CPU), representando o curso de informatica.',5.00,false,2.90, 0.00,1.00 ,'Informática', 12, 5),
('Chaveiro ENGINE','Chaveiro com a imagem de uma engrenagem, representando o curso de Mecânica.',5.00,false,2.90, 0.00,1.00 ,'Mecânica', 14, 5),
('Chaveiro LAMPADA','Chaveiro com a imagem de uma lampada, represenando o curso de Eletronica',5.00,false,2.90, 0.00,1.00 ,'Eletrônica', 16, 5),
('Chaveiro CTI','Chaveiro com a logo do CTI',5.00,false,2.90, 0.00,1.00 ,'CTI', 13, 5);

INSERT INTO tbl_produto (nome, descricao, preco, excluido, custo, margem_lucro, icms, imagem, estoque) VALUES 
('Chaveiro lua','Chaveiro com a imagem de uma lua e estrelas',5.00,false,2.90, 0.00,1.00, 17, 5),
('Chaveiro pato','Chaveiro com a imagem de um pato estiloso',5.00,false,2.90, 0.00,1.00, 18, 5),
('Chaveiro cartas','Chaveiro com a imagem de duas cartas de baralho',5.00,false,2.90, 0.00,1.00, 9, 5),
('Chaveiro sol','Chaveiro com a imagem de um sol',5.00,false,2.90, 0.00,1.00, 19, 5),
('Chaveiro gatinho','Chaveiro com a imagem de um gatinho fofinho',5.00,false,2.90, 0.00,1.00, 15, 5);

