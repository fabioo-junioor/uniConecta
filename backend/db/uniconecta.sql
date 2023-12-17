-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17-Dez-2023 às 05:58
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `uniconecta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `pk_avaliacao` int NOT NULL AUTO_INCREMENT,
  `stars_comprador` int DEFAULT NULL,
  `stars_vendedor` int DEFAULT NULL,
  `fk_compra_venda` int DEFAULT NULL,
  PRIMARY KEY (`pk_avaliacao`),
  KEY `fk_compra_venda` (`fk_compra_venda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compravenda`
--

DROP TABLE IF EXISTS `compravenda`;
CREATE TABLE IF NOT EXISTS `compravenda` (
  `pk_compra_venda` int NOT NULL AUTO_INCREMENT,
  `data_hora` datetime DEFAULT NULL,
  `fk_comprador` int DEFAULT NULL,
  `fk_vendedor` int DEFAULT NULL,
  `fk_curso` int DEFAULT NULL,
  PRIMARY KEY (`pk_compra_venda`),
  KEY `fk_comprador` (`fk_comprador`),
  KEY `fk_vendedor` (`fk_vendedor`),
  KEY `fk_curso` (`fk_curso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `pk_curso` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `total_horas` float DEFAULT NULL,
  `valor_curso` int DEFAULT NULL,
  `local_curso` varchar(255) DEFAULT NULL,
  `data_curso` varchar(255) DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo_curso` varchar(255) DEFAULT NULL,
  `link_material` varchar(255) DEFAULT NULL,
  `is_visivel` tinyint DEFAULT NULL,
  `fk_usuario` int DEFAULT NULL,
  PRIMARY KEY (`pk_curso`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `pk_favorito` int NOT NULL AUTO_INCREMENT,
  `fk_curso` int DEFAULT NULL,
  `fk_usuario` int DEFAULT NULL,
  PRIMARY KEY (`pk_favorito`),
  KEY `fk_curso` (`fk_curso`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `moedas`
--

DROP TABLE IF EXISTS `moedas`;
CREATE TABLE IF NOT EXISTS `moedas` (
  `pk_moedas` int NOT NULL AUTO_INCREMENT,
  `total_moedas` int DEFAULT NULL,
  `fk_usuario` int DEFAULT NULL,
  PRIMARY KEY (`pk_moedas`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontos`
--

DROP TABLE IF EXISTS `pontos`;
CREATE TABLE IF NOT EXISTS `pontos` (
  `pk_pontos` int NOT NULL AUTO_INCREMENT,
  `total_pontos` int DEFAULT NULL,
  `fk_usuario` int DEFAULT NULL,
  PRIMARY KEY (`pk_pontos`),
  KEY `fk_usuario` (`fk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `pk_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `graduacao` varchar(255) DEFAULT NULL,
  `img` longtext,
  `senha` varchar(255) DEFAULT NULL,
  `permissao_telefone` tinyint DEFAULT NULL,
  PRIMARY KEY (`pk_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
