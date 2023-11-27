-- create database if not exists `test` default charset utf8 collate utf8_general_ci;
CREATE DATABASE IF NOT EXISTS `crud_ppi` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON crud_ppi.* TO 'user'@'%'; -- concede permissoes para qualquer usuario acessar o banco criado
FLUSH PRIVILEGES; -- atualiza as permissoes
USE `crud_ppi`;
CREATE TABLE `pessoas` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Índices para tabelas despejadas
--

-- Carga de datos de inicial para teste
INSERT INTO `pessoas` (`nome`, `sobrenome`, `email`, `idade`) VALUES
('Ana', 'Silva', 'ana.silva@example.com', 28),
('Bruno', 'Martins', 'bruno.martins@example.com', 35),
('Clara', 'Fernandes', 'clara.fernandes@example.com', 22),
('Diego', 'Santos', 'diego.santos@example.com', 40),
('Eduarda', 'Pereira', 'eduarda.pereira@example.com', 31),
('Felipe', 'Costa', 'felipe.costa@example.com', 26),
('Gabriela', 'Ribeiro', 'gabriela.ribeiro@example.com', 29),
('Hugo', 'Carvalho', 'hugo.carvalho@example.com', 33),
('Isabela', 'Mendes', 'isabela.mendes@example.com', 27),
('João', 'Barbosa', 'joao.barbosa@example.com', 36),
('Larissa', 'Almeida', 'larissa.almeida@example.com', 24),
('Márcio', 'Soares', 'marcio.soares@example.com', 38),
('Natalia', 'Oliveira', 'natalia.oliveira@example.com', 30),
('Otávio', 'Lima', 'otavio.lima@example.com', 32),
('Patricia', 'Gomes', 'patricia.gomes@example.com', 37),
('Rafael', 'Borges', 'rafael.borges@example.com', 34),
('Sofia', 'Dias', 'sofia.dias@example.com', 21),
('Tiago', 'Rocha', 'tiago.rocha@example.com', 39),
('Úrsula', 'Vieira', 'ursula.vieira@example.com', 25),
('Vinícius', 'Morais', 'vinicius.morais@example.com', 41);
