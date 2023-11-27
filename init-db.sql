-- create database if not exists `test` default charset utf8 collate utf8_general_ci;
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON crud_ppi.* TO 'user'@'%'; -- concede permissoes para qualquer usuario acessar o banco criado
FLUSH PRIVILEGES; -- atualiza as permissoes
USE `database`;
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

-