-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 16-Dez-2015 às 01:31
-- Versão do servidor: 10.1.9-MariaDB
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeigniter_guestbook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamentos`
--

CREATE TABLE IF NOT EXISTS `lancamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `natureza` char(1) NOT NULL,
  `valor` double NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Extraindo dados da tabela `lancamentos`
--

INSERT INTO `lancamentos` (`id`, `natureza`, `valor`, `descricao`, `idUsuario`) VALUES
(76, 'R', 3000, 'Receitas janeiro 2016', 73),
(77, 'D', 1000, 'Despesas Janeiro 2016', 73);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mural`
--

CREATE TABLE IF NOT EXISTS `mural` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_autor` int(11) NOT NULL,
  `mensagem` varchar(140) NOT NULL,
  `data_publicacao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_autor` (`id_autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `login` varchar(60) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `tipo` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `tipo`) VALUES
(66, 'gustavo', 'gugu', 'a3622ca65e74a73963541ccce73fb02f', 'm'),
(67, 'joazinho', 'jojo', '7510d498f23f5815d3376ea7bad64e29', 'M'),
(68, 'manoel', 'manu', 'f13bb1bed03db9d68a7d9a48aafeec78', 'S'),
(69, 'liliane', 'lili', '777bbb7869ae8193249f8ff7d3e59afe', 'S'),
(70, 'marcelinho', 'mama', 'eeafbf4d9b3957b139da7b7f2e7f2d4a', 'S'),
(71, 'leopoldo', 'lele', '69bfc4ef467b367e3515cdcf693e65db', 'M'),
(73, 'sindico', 'sindico', '826db2ac8dc8fc13ea257cb9e9de5283', 'S');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `mural`
--
ALTER TABLE `mural`
  ADD CONSTRAINT `usuario_mural` FOREIGN KEY (`id_autor`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
