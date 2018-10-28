-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 09-Out-2018 às 23:35
-- Versão do servidor: 5.5.34
-- versão do PHP: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `trocajogos`
--
CREATE DATABASE IF NOT EXISTS `trocajogos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `trocajogos`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `console`
--

CREATE TABLE IF NOT EXISTS `console` (
  `id_console` int(11) NOT NULL AUTO_INCREMENT,
  `nome_console` varchar(40) NOT NULL,
  PRIMARY KEY (`id_console`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `console`
--

INSERT INTO `console` (`id_console`, `nome_console`) VALUES
(1, 'ps4'),
(2, 'ps3'),
(3, 'xbox one'),
(4, 'xbox 360'),
(5, 'ps vita'),
(6, 'wii u'),
(7, 'wii'),
(8, 'ds'),
(9, 'pc');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iniciais` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `estado`, `iniciais`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amapá', 'AP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE IF NOT EXISTS `genero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `genero`
--

INSERT INTO `genero` (`id`, `nome`) VALUES
(1, 'Ação'),
(2, 'Aventura'),
(3, 'Terror'),
(4, 'Luta'),
(5, 'Puzzle'),
(6, 'Esportes'),
(7, 'Shooter'),
(8, 'Simulação'),
(9, 'RPG'),
(10, 'Musical'),
(11, 'MMO'),
(12, 'Corrida'),
(13, 'Fitness'),
(14, 'TCG'),
(15, 'Estratégia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

CREATE TABLE IF NOT EXISTS `imagens` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `id_console` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL COMMENT 'Nome do jogo que a imagem pertence',
  `imagem` varchar(100) NOT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id_img`, `id_console`, `nome`, `imagem`) VALUES
(1, 0, 'Padrão', 'jogoPadrao.jpg'),
(2, 9, 'Battlefield 3', '25c1356ead809d6e7f6ed40119dc1c64.jpg'),
(3, 1, 'Hobbit Lego', '14f321abf19c56e88f0ff78744ed2bc5.jpg'),
(4, 4, 'Resident Evil 4', 'b464b6102ec62aa59576ea24b1c11d80.png'),
(6, 1, 'hobbit Infamous Second Son', 'fcc7e6b7b062370ae24efb825f1d9ae3.jpg'),
(7, 6, 'God of War 3', '3cad448bebf9f9e3c4a5fa58a01d3fde.jpg'),
(8, 7, 'Mario & Sonic at the Olympic Winter Games', 'e6d8a89d680065210101e9e30e9c2b9c.png.png'),
(9, 9, 'Rainbow Six', '9c5ced2723520bf307e922b659611bd2.jpg'),
(10, 9, 'Rainbow Six', '21e4be25b8ca51eeb644925abdccc25a.jpg'),
(11, 9, 'Rainbow Six', 'c562582d80967cccd5fe468c0f7a4ac5.jpg'),
(12, 9, 'Rainbow Six', '55a28f1b0b2c2e05e9ab7d4bd7703c53.jpg'),
(13, 9, 'Rainbow Six', 'c8539bd601036967d639bcb7a134f243.jpg'),
(14, 1, 'Hobbit 3', '0c94dcbbdde77bb1fc4298519f80f2d9.png'),
(15, 1, 'Hobbit 3', '8d07303a67d6e9618f5eb036eb16f009.png'),
(16, 3, 'Pes 17', '1a1360efb671d8735d92f6561498ee45.jpg'),
(17, 3, 'Pes 17', '1c6245208c975dc2b536c2e1edb5ef39.jpg'),
(18, 5, 'Pes 17', 'b67554b4642a2eef1e934f64b2ab34d7.jpg'),
(19, 5, 'Pes 17', 'a1adabe7407bdbec634986167c26f091.jpg'),
(20, 5, 'Pes 17', '200bf668347299533f351f3d3b38c36d.jpg'),
(21, 8, 'TENNIS', '4b46f79064788733b1aef49a74f4987f.jpg'),
(22, 8, 'TENNIS', '1e3304252b3ebf073f73d0dc62391c57.jpg'),
(23, 8, 'TENNIS', '40db8a1cb41ce1f6478a936b6ab2d272.jpg'),
(24, 8, 'TENNIS', '4e2f2f1baf90a9eda9a78fa0f8125387.jpg'),
(25, 8, 'TENNIS', 'bf7aaf5642b811836f461810cd1389b7.jpg'),
(26, 2, 'SONIC', '3cad448bebf9f9e3c4a5fa58a01d3fde.jpg'),
(27, 5, 'Rainbow Six Siege', '037c225989946c870074c0a4067be3bb.jpg'),
(28, 1, 'Mario & Sonic', 'b9f9d8b7b9aef9bafe2a67e959f52dc4.png'),
(29, 1, 'Mario & Sonic', 'a5241413c99a186a7b3d1f9c94336b9d.png'),
(30, 1, 'Mario & Sonic', '1c846b9509207e21aa39e1314d0db301.png'),
(31, 4, 'Resident Evil 6', '8a5934a9d8d1daff650305a08e7b83aa.jpg'),
(32, 4, 'Resident Evil 5', '421b63636b44787b98ff62202ab24e05.jpg'),
(33, 5, 'God of war Collection', '117cc031f52c590c0f5b1ddc9a9b9205.jpg'),
(34, 5, 'God of war Collection', 'dcfb409050557a774e64359448c40158.jpg'),
(35, 1, 'Call of Duty WWII', 'd9ad032e9d787a82a27d49bb3b1a3d1f.png'),
(36, 1, 'Call of Duty WWII', 'd43f08b42a70c4c72985d2b73f2762e3.png'),
(37, 1, 'Call of Duty WWII', '5cf8603271d332b45e44e4b618ad6f78.png'),
(38, 1, 'Call of Duty WWII', '9589bc16ede1d8641c058b8c54a566e7.png'),
(39, 6, 'Call of Duty WWII', '32e18caad36d67220a2a0e1bddfb6d6e.png'),
(40, 3, 'Battlefield 4', '8a153b90f8dd2c5f26005e5970def155.jpg'),
(41, 9, 'Battlefield 4', 'cd24ec07b46d477173821a1799d7733c.jpg'),
(42, 3, 'Jogo Novo', '4529424b1a51c3419adf92ff1a50a760.jpg'),
(43, 3, 'Teste Cadastro', '43d58f183fcfe2bfb4566b66f6ca8871.jpg'),
(44, 7, 'Monopoly', 'cd5f3bb7d0286f56424e7acfd2b1eaa8.jpg'),
(45, 9, 'Monopoly', '9dc800d9c74b676dd424cf91d7a57e1f.jpg'),
(46, 5, 'Monopoly', 'dba301a6834a7cf6d657b794bcd426b1.jpg'),
(47, 5, 'The knight', '2ae659bab1fca75782d5414f485253c3.jpg'),
(48, 5, 'The knight', '96fba7970c97275a28db5e2a410210b5.jpg'),
(49, 6, 'The knight II', '321bd6cce8e4b11c9987a791c6075ed0.jpg'),
(50, 1, 'God of War 4 Day one Edition', '2411c26d5368985e8112a8983ca021a2.jpg'),
(51, 5, 'Sonic 4', '264c44eb374cc90cf090e47658fb35db.jpg'),
(52, 4, 'Hobbit 4', 'bca27e0af7a740128aba58d9cce8365b.jpg'),
(53, 3, 'The last of them', '53f15b190c3d253667e79f7c9b13191c.jpg'),
(54, 8, 'Sonic Adventures', 'b455c25761212347a7ff052eeeeeba1f.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogocategoria`
--

CREATE TABLE IF NOT EXISTS `jogocategoria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `jogo_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `jogo_id` (`jogo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=192 ;

--
-- Extraindo dados da tabela `jogocategoria`
--

INSERT INTO `jogocategoria` (`ID`, `jogo_id`, `categoria_id`) VALUES
(76, 32, 2),
(77, 32, 6),
(78, 32, 12),
(79, 33, 2),
(80, 33, 6),
(81, 33, 15),
(105, 34, 8),
(106, 34, 13),
(113, 38, 15),
(114, 38, 8),
(139, 10, 5),
(144, 38, 10),
(145, 30, 3),
(146, 30, 7),
(147, 30, 15),
(148, 54, 3),
(149, 54, 4),
(150, 54, 9),
(151, 54, 10),
(152, 55, 3),
(153, 55, 4),
(154, 55, 9),
(155, 55, 10),
(161, 63, 3),
(167, 63, 1),
(168, 63, 2),
(169, 66, 2),
(170, 66, 15),
(171, 55, 2),
(172, 55, 13),
(175, 66, 12),
(177, 69, 2),
(178, 69, 3),
(179, 69, 8),
(185, 76, 3),
(188, 79, 1),
(189, 79, 2),
(190, 79, 3),
(191, 79, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE IF NOT EXISTS `jogos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n_jogo` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Nome do Jogo',
  `img_jogo` int(11) DEFAULT NULL COMMENT 'Imagem do jogo',
  `id_console` int(11) DEFAULT NULL,
  `id_gamer` int(11) DEFAULT NULL,
  `jogoTroca` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `idJogoTroca` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `descricao` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `informacao` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_imagem` (`img_jogo`),
  KEY `fk_console` (`id_console`),
  KEY `fk_user` (`id_gamer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `n_jogo`, `img_jogo`, `id_console`, `id_gamer`, `jogoTroca`, `idJogoTroca`, `data`, `descricao`, `informacao`, `status`) VALUES
(8, 'hobbit Lego', 3, 1, 1, NULL, NULL, '2017-02-25', 'teste', 'teste', 1),
(9, 'Battlefield', 2, 9, 1, NULL, NULL, '2017-02-27', 'A melhor edição do BF', 'Está tudo ok', 1),
(10, 'resident evil', 4, 4, 1, NULL, NULL, '2017-03-28', 'Jogão. Slk ', 'Está quebrado!', 1),
(11, 'infamous Second', 6, 1, 1, NULL, NULL, '2018-01-22', 'Não gostei muito muito. Por isso quero trocar', 'Novinho em folha', 1),
(12, 'hobbit', 3, 1, 1, NULL, NULL, '2018-01-25', 'hgfhgfchgf', 'ghgjhjhgjhgjhgjhgjhgjhg', 1),
(30, 'God of war Collection', 34, 5, 10, NULL, NULL, '2018-02-22', 'Coleção GOW I & II - Clássico', 'Está novo. Ainda na capa original', 1),
(32, 'Mario & Sonic', 28, 1, 10, NULL, NULL, NULL, 'Pronto', '', 1),
(33, 'Mario & Sonic', 28, 1, 10, NULL, NULL, NULL, 'Pronto', 'Okay', 1),
(34, 'The second son - Limited Edition II', 6, 1, 10, NULL, NULL, '2018-02-22', 'rafafae', 'faefafae', 1),
(38, 'Monopoly II', 44, 7, 10, NULL, NULL, '2018-03-16', 'Jogo clássico para os amantes do monopólio. Aqui você pode praticar suas estratégias de negócio e suas habilidades no setor financeiros.', 'Já possuo esse jogo há 4 anos', 1),
(54, 'The knight', 47, 5, 10, NULL, NULL, '2018-04-28', 'Ta né', '', 1),
(55, 'The knight', 48, 5, 10, NULL, NULL, '2018-04-28', 'Ta né', '', 1),
(63, 'Resident Evil 6 Edition Limited', 31, 4, 10, NULL, NULL, '2018-05-01', 'Edição Limitada', 'Nunca usei', 1),
(66, 'God of War 4', 50, 1, 10, NULL, NULL, '2018-05-01', 'Melhor jogo do ano', 'Está fechado ainda', 1),
(69, 'Resident Evil 4', 4, 4, 21, NULL, NULL, '2018-09-03', 'teste 2', 'teste 2', 1),
(76, 'teste', 43, 3, 13, NULL, NULL, '2018-09-03', 'teste', 'tete', 1),
(79, 'resident evil 6', 31, 4, 13, NULL, NULL, '2018-09-04', 'teste', 'teste', 1);

--
-- Acionadores `jogos`
--
DROP TRIGGER IF EXISTS `jogo_categoria_troca_delete`;
DELIMITER //
CREATE TRIGGER `jogo_categoria_troca_delete` AFTER DELETE ON `jogos`
 FOR EACH ROW BEGIN
    DELETE FROM trocas WHERE (`jogoum` = OLD.id OR `jogodois` = OLD.id);
	DELETE FROM jogocategoria WHERE jogo_id = OLD.id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logradouro`
--

CREATE TABLE IF NOT EXISTS `logradouro` (
  `id_logradouro` int(11) NOT NULL AUTO_INCREMENT,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(11) NOT NULL,
  `complemento` varchar(200) NOT NULL,
  PRIMARY KEY (`id_logradouro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `logradouro`
--

INSERT INTO `logradouro` (`id_logradouro`, `rua`, `numero`, `cidade`, `estado`, `complemento`) VALUES
(1, 'Rua Afonso Arino de Melo Franco ', '173', 'Itaquaquecetuba', 'SP', 'Condomínio'),
(2, 'Rua Paraíso', '200', 'Friburgo', 'RJ', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_from` int(11) NOT NULL,
  `cod_to` int(11) NOT NULL,
  `mensagem` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `datahora` datetime NOT NULL,
  `lido` varchar(10) NOT NULL DEFAULT 'nao',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `cod_from`, `cod_to`, `mensagem`, `datahora`, `lido`) VALUES
(1, 10, 1, 'oi', '2018-08-06 01:27:30', 'nao');

-- --------------------------------------------------------

--
-- Estrutura da tabela `trocas`
--

CREATE TABLE IF NOT EXISTS `trocas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUm` int(11) NOT NULL COMMENT 'Dono do jogo desejado',
  `idDois` int(11) NOT NULL COMMENT 'Dono do jogo da troca',
  `jogoum` int(11) NOT NULL COMMENT 'Recebe o id do jogo desejado',
  `jogodois` int(11) NOT NULL COMMENT 'Recebe o id do meu jogo',
  `valor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1',
  `mensagem` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 - pendente / 1 - aceita / 2 - recusada / 3 - finalizada',
  `by_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `trocas`
--

INSERT INTO `trocas` (`id`, `idUm`, `idDois`, `jogoum`, `jogodois`, `valor`, `tipo`, `mensagem`, `status`, `by_user`) VALUES
(2, 1, 10, 10, 32, '0', 1, 'Teste', '0', 10),
(3, 10, 13, 38, 76, '50,00', 0, 'Teste com usuário Hyuga', '0', 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nomeUser` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `emailTJ` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `console` int(11) DEFAULT NULL,
  `celular` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `cep` varchar(50) DEFAULT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `tipousuario` char(1) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `logfirst` datetime DEFAULT NULL,
  `logusuario` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nomeUser`, `emailTJ`, `senha`, `console`, `celular`, `telefone`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `complemento`, `tipousuario`, `status`, `logfirst`, `logusuario`) VALUES
(1, 'Rafael Alves Cardoso ', 'rafa@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.6t3.W1jn.NEZqKJz4HnJHemDp3zNGI6', 0, '(11) 98662-6236', '(11) 4645-4525', '0', 'Afonso Arino de Melo Franco', 173, NULL, 'Itaquaquecetuba', 'Acre', '', '1', NULL, NULL, NULL),
(2, 'Maria Santos', 'user@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.IxHayEh1hyPRbWR7dVcrLlwCC7qA9HS', 0, '(11) 44555-8866', '(11) 4546-4545', '08597694', 'Paraíso', 147, NULL, 'Poá', 'Amapá', 'Rua sem saída', '0', NULL, NULL, NULL),
(3, 'João', 'joao@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.0JmmtD/.rK.9CyF/P4Ox0yrYfv40LCm', 0, '(11) 98662-6222', '(11) 4585-8585', '0', 'Teste', 147, NULL, 'Suzano', 'Alagoas', '', '1', NULL, NULL, NULL),
(4, 'Rafa', 'nick@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.0JmmtD/.rK.9CyF/P4Ox0yrYfv40LCm', 0, '(11) 95252-5252', '(11) 4645-4225', '0', 'Estrada São Bento', 15, NULL, 'Itaquaquecetuba', 'Acre', '', '0', NULL, NULL, NULL),
(5, 'Rafael', 'rafael-hyuga@hotmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.FgyzDtl7dFCvsRacIge9vbXDVZ6hjkK', 0, '(22) 2222-22222', '', '0', '', 0, NULL, '', '', '', '0', NULL, NULL, NULL),
(6, 'Rafael', 'rafael-hyug@hotmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.3LZCUnz7ep7EM9FXF4fF23rY8ejq0lG', 0, '(11) 1111-11111', '', '0', 'Rua Afonso Arinos de Melo Franco', 173, NULL, 'Itaquaquecetuba', 'SP', 'Condomínio', '0', NULL, NULL, NULL),
(7, 'Juca dos Santos', 'juca@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.KYu4AyDWgRl6qZtTzBOYtCUzAmrrfxy', 3, '(12) 6333-33333', '(33) 3333-3333', '0', '', 0, NULL, '', '', '', '0', NULL, NULL, NULL),
(8, 'Rafael Teste', 'rafael@teste.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.AxrYcjoLCofZf8zfwW/eer4C.Qo8zAe', 6, '(25) 5555-55555', '(33) 3333-3333', '0', '', 0, NULL, '', '', '', '0', NULL, NULL, NULL),
(9, 'Samara Teixeira', 'samara_teixeira@uol.com.br', '$2a$08$Cf1f11ePArKlBJomM0F6a.v1/X6FqyAXX0fAaW14N0G8KjpnGkdZe', 7, '(11) 9525-23637', '(11) 4645-2523', '41940', 'Avenida Anita Garibaldi', 50, NULL, 'Salvador', 'BA', 'Favela', '0', NULL, NULL, NULL),
(10, 'Dorivan', 'dorivan@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.8hkDBVwbjEj4M.X8f8Mif742BLRbCGO', 6, '(15) 0323-23232', '(15) 2323-2323', '40323', 'Travessa Anita Ferreira', 1000, NULL, 'Salvador', 'BA', '', '1', NULL, NULL, NULL),
(11, 'Tatiane Silva', 'tatiane@outlook.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.EBwZg8QdLie5cRwp.I3QnfuoGEnAnxa', 3, '(11) 1111-11111', '', '0', '', 0, NULL, '', '', '', '0', NULL, NULL, NULL),
(12, 'Ricardo Santos', 'ricardo_santos@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.KYu4AyDWgRl6qZtTzBOYtCUzAmrrfxy', 4, '(11) 5422-25545', '(11) 2255-8866', '8597', 'Rua Afonso Arinos de Melo Franco', 10, NULL, 'Itaquaquecetuba', 'SP', '', '0', NULL, NULL, NULL),
(13, 'Rafah Alves', 'hyuga@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.8hkDBVwbjEj4M.X8f8Mif742BLRbCGO', 1, '(11) 2545-8565', '(11) 1245-4545', '08597694', 'Rua Diná Silveira de Queiróz', 21, 'Jd Moraes', 'Itaquaquecetuba', 'SP', 'Fim de rua', '0', NULL, NULL, '2018-09-04 23:58:00'),
(14, 'Rafah Alves', 'rafael@gmail.com', '123456789', 5, '(11) 9866-25535', '', '0', '', 0, NULL, '', '', '', '0', NULL, NULL, NULL),
(15, 'Joaozinho Santos', 'joaozinho@gmail.com', 'joao123456', 8, '(01) 2545-54545', '', '25903', 'Rua Projetada Três', 20, NULL, 'Magé', 'RJ', '', '0', NULL, NULL, NULL),
(16, 'Denilson Amarau', 'denilson@gmail.com.br', '$2a$08$Cf1f11ePArKlBJomM0F6a.8hkDBVwbjEj4M.X8f8Mif742BLRbCGO', 9, '(23) 6656-56151', '(11) 2154-5454', '32604', 'Rua José Alves Pinto', 1, NULL, 'Betim', 'MG', '', '0', NULL, NULL, NULL),
(17, 'Teste', 'teste@gmail.com', '125458', 2, '114458-9568', '1254587545', '11201', 'teste', 10, NULL, 'Suzano', 'SP', 'sem saida', NULL, 'sim', '2018-08-04 15:24:00', '0000-00-00 00:00:00'),
(18, 'Teste', 'teste@gmail.com', '125458', 2, '114458-9568', '1254587545', '08567694', 'teste', 10, NULL, 'Suzano', 'SP', 'sem saida', NULL, 'sim', '2018-08-04 15:50:00', '0000-00-00 00:00:00'),
(19, 'Maria Santos', 'maria@gmail.com.br', '$2a$08$Cf1f11ePArKlBJomM0F6a.TKtun4hGXrvfOMQ.9Pw4L9GaKaJV9Ny', 9, '(11) 1111-11111', '(22) 2222-2222', '08597696', 'Viela Dois', 1000, NULL, 'Itaquaquecetuba', 'SP', '', NULL, 'sim', '2018-08-04 13:18:00', '0000-00-00 00:00:00'),
(20, 'Suzana Tereza', 'suzana@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.8hkDBVwbjEj4M.X8f8Mif742BLRbCGO', 6, '(01) 2111-11111', '(22) 2222-2222', '08597694', 'Rua Afonso Arinos de Melo Franco', 120, NULL, 'Itaquaquecetuba', 'SP', '', NULL, 'sim', '2018-08-04 13:19:00', '0000-00-00 00:00:00'),
(21, 'Pedro Silva Siqueira', 'pedrosilva@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.8hkDBVwbjEj4M.X8f8Mif742BLRbCGO', 8, '(12) 3456-92511', '(22) 2222-2222', '08597694', 'Rua Afonso Arinos de Melo Franco', 10, NULL, 'Itaquaquecetuba', 'SP', '', '0', 'sim', '2018-08-04 13:24:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `fk_console` FOREIGN KEY (`id_console`) REFERENCES `console` (`id_console`),
  ADD CONSTRAINT `fk_imagem` FOREIGN KEY (`img_jogo`) REFERENCES `imagens` (`id_img`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_gamer`) REFERENCES `usuarios` (`id_user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
