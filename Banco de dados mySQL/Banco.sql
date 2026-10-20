CREATE DATABASE mixtudo 
DEFAULT CHARACTER SET utf8;
USE mixtudo;

-- Usuarios
CREATE TABLE usuarios (
  id        INT(11)      NOT NULL AUTO_INCREMENT,
  nome      VARCHAR(100) NOT NULL,
  email     VARCHAR(100) NOT NULL UNIQUE,
  senha     VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO usuarios (nome, email, senha)
VALUES ('Dono', 'admin@mixtudo.com', MD5('admin123'));

-- Categorias
CREATE TABLE categorias (
  id   INT(11)      NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO categorias (nome) VALUES
  ('Material Escolar'),
  ('Brinquedos'),
  ('Utilidades Domésticas'),
  ('Eletrônicos'),
  ('Decoração'),
  ('Acessórios');

-- Produtos
CREATE TABLE produtos (
  id           INT(11)       NOT NULL AUTO_INCREMENT,
  nome         VARCHAR(150)  NOT NULL,
  categoria_id INT(11)       DEFAULT NULL,
  preco        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  estoque      INT(11)       NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (categoria_id) 
  REFERENCES categorias(id) ON DELETE SET NULL #Mantém o registro e define o produto como NULL
);

-- Clientes
CREATE TABLE clientes (
  id       INT(11)      NOT NULL AUTO_INCREMENT,
  nome     VARCHAR(150) NOT NULL,
  telefone VARCHAR(20)  DEFAULT NULL,
  email    VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

-- Vendas
CREATE TABLE vendas (
  id          INT(11)       NOT NULL AUTO_INCREMENT,
  cliente_id  INT(11)       DEFAULT NULL,
  data_venda  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP, #Registra data e hora da venda
  valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (id),
  FOREIGN KEY (cliente_id) 
  REFERENCES clientes(id) ON DELETE SET NULL
);

-- Itens da Venda
CREATE TABLE itens_venda (
  id             INT(11)       NOT NULL AUTO_INCREMENT,
  venda_id       INT(11)       NOT NULL,
  produto_id     INT(11)       DEFAULT NULL,
  quantidade     INT(11)       NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (venda_id)   REFERENCES vendas(id)   ON DELETE CASCADE, # Apaga os itens da venda automaticamente
  FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE SET NULL
);
