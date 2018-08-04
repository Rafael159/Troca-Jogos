-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 11-Mar-2017 às 01:16
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'Ação'),
(2, 'Drama'),
(3, 'Terror'),
(4, 'Luta');

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
-- Estrutura da tabela `imagens`
--

CREATE TABLE IF NOT EXISTS `imagens` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `id_console` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL COMMENT 'Nome do jogo que a imagem pertence',
  `imagem` varchar(100) NOT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id_img`, `id_console`, `nome`, `imagem`) VALUES
(1, 0, 'Padrão', 'jogoPadrao.jpg'),
(2, 9, 'Battlefield 3', '25c1356ead809d6e7f6ed40119dc1c64.jpg'),
(3, 1, 'Hobbit Lego', '14f321abf19c56e88f0ff78744ed2bc5.jpg'),
(4, 4, 'Resident Evil 4', 'b464b6102ec62aa59576ea24b1c11d80.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogocategoria`
--

CREATE TABLE IF NOT EXISTS `jogocategoria` (
  `jogo_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`jogo_id`,`categoria_id`),
  KEY `fk_catego` (`categoria_id`),
  KEY `fk_jogo` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jogocategoria`
--

INSERT INTO `jogocategoria` (`jogo_id`, `categoria_id`) VALUES
(8, 1),
(8, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `n_jogo`, `img_jogo`, `id_console`, `id_gamer`, `jogoTroca`, `idJogoTroca`, `data`, `descricao`, `informacao`, `status`) VALUES
(8, 'hobbit lego', 3, 1, 3, NULL, NULL, '2017-02-25', 'teste', 'teste', 1),
(9, 'Battlefield', 2, 9, 1, NULL, NULL, '2017-02-27', 'A melhor edição do BF', 'Está tudo ok', 1);

--
-- Acionadores `jogos`
--
DROP TRIGGER IF EXISTS `deletaTroca`;
DELIMITER //
CREATE TRIGGER `deletaTroca` AFTER DELETE ON `jogos`
 FOR EACH ROW BEGIN
    DELETE FROM trocas WHERE (`jogoum` = OLD.id OR `jogodois` = OLD.id);
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
-- Estrutura da tabela `trocas`
--

CREATE TABLE IF NOT EXISTS `trocas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUm` int(11) NOT NULL COMMENT 'Dono do jogo desejado',
  `idDois` int(11) NOT NULL COMMENT 'Dono do jogo da troca',
  `jogoum` int(11) NOT NULL COMMENT 'Rebece o id do jogo desejado',
  `jogodois` int(11) NOT NULL COMMENT 'Recebe o id do meu jogo',
  `valor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1',
  `mensagem` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `trocas`
--

INSERT INTO `trocas` (`id`, `idUm`, `idDois`, `jogoum`, `jogodois`, `valor`, `tipo`, `mensagem`, `status`) VALUES
(20, 3, 1, 8, 9, '12', 0, 'teste', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nomeUser` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `emailTJ` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `data` date NOT NULL,
  `celular` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '0',
  `id_console` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nomeUser`, `emailTJ`, `senha`, `data`, `celular`, `telefone`, `rua`, `numero`, `cidade`, `estado`, `complemento`, `status`, `id_console`) VALUES
(1, 'Rafael', 'rafa@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.6t3.W1jn.NEZqKJz4HnJHemDp3zNGI6', '2016-12-13', '(11) 98662-6236', '(11) 4645-4525', 'Afonso Arino de Melo Franco', 173, 'Itaquaquecetuba', 'Acre', '', '0', 0),
(2, 'Maria Santos', 'user@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.IxHayEh1hyPRbWR7dVcrLlwCC7qA9HS', '2016-12-13', '(11) 44555-8866', '(11) 4546-4545', 'Paraíso', 147, 'Poá', 'Amapá', 'Rua sem saída', '0', 0),
(3, 'João', 'joao@gmail.com', '$2a$08$Cf1f11ePArKlBJomM0F6a.IxHayEh1hyPRbWR7dVcrLlwCC7qA9HS', '2017-01-18', '(11) 98662-6222', '(11) 4585-8585', 'Teste', 147, 'Suzano', 'Alagoas', '', '0', 0);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `jogocategoria`
--
ALTER TABLE `jogocategoria`
  ADD CONSTRAINT `fk_catego` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `fk_jogo` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`);

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
