-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2021 às 02:00
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mel_modas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `numero_casa` int(11) DEFAULT NULL,
  `complemento` text DEFAULT NULL,
  `data_nasc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `created_at`, `updated_at`, `deleted_at`, `nome`, `rua`, `bairro`, `numero_casa`, `complemento`, `data_nasc`) VALUES
(1, '2021-04-05 13:28:40', '2021-04-05 13:28:40', NULL, 'Consumidor Final', '----', '-----', 0, 'Consumidor Final não é um cliente cadastrado. Logo não tem direito a promoções oferecidas pelo estabelecimento', '0001-01-01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_produto`
--

CREATE TABLE `cliente_produto` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade_vendida` int(11) DEFAULT NULL,
  `valor_total` double DEFAULT NULL,
  `valor_bruto` double DEFAULT NULL,
  `forma_pagamento` varchar(255) DEFAULT NULL,
  `parcelamento` varchar(255) DEFAULT NULL,
  `estado_compra` varchar(45) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `nv_vl_unitario` double DEFAULT NULL,
  `cliente_anonimo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente_produto`
--

INSERT INTO `cliente_produto` (`id`, `cliente_id`, `produto_id`, `quantidade_vendida`, `valor_total`, `valor_bruto`, `forma_pagamento`, `parcelamento`, `estado_compra`, `descricao`, `nv_vl_unitario`, `cliente_anonimo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 1, 2, 50, 6, 'A vista', '0', 'concluida', NULL, 5, '', '2021-04-06 14:36:40', '2021-04-06 14:36:40', NULL),
(5, 1, 1, 3, 50, 9, 'A vista', '0', 'concluida', NULL, 10, '', '2021-04-06 14:36:40', '2021-04-06 14:36:40', NULL),
(6, 1, 1, 3, 50, 9, 'A vista', '0', 'concluida', NULL, 4, '', '2021-04-06 14:36:40', '2021-04-06 14:36:40', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_promocao`
--

CREATE TABLE `cliente_promocao` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `promocao_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `mes_antigido` date DEFAULT NULL,
  `valor_atual` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nota_promissoria`
--

CREATE TABLE `nota_promissoria` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `cliente_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `valor_compra` double DEFAULT NULL,
  `valor_venda` double DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `created_at`, `updated_at`, `deleted_at`, `codigo`, `nome`, `quantidade`, `marca`, `foto`, `valor_compra`, `valor_venda`, `descricao`) VALUES
(1, '2021-04-06 13:19:56', '2021-04-06 14:36:40', NULL, '1010', 'Cerveja', 35, 'skol', NULL, 3, 4, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `promocao`
--

CREATE TABLE `promocao` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `desconto_porcento` int(11) DEFAULT NULL,
  `valor_atingir` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `promocao`
--

INSERT INTO `promocao` (`id`, `created_at`, `updated_at`, `deleted_at`, `desconto_porcento`, `valor_atingir`) VALUES
(1, '2021-02-27 15:05:21', '2021-02-27 15:05:21', NULL, 10, 4300);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

CREATE TABLE `telefone` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telefone`
--

INSERT INTO `telefone` (`id`, `created_at`, `updated_at`, `deleted_at`, `telefone`, `cliente_id`) VALUES
(1, '2021-04-05 13:28:41', '2021-04-05 13:28:41', NULL, '(55) 5 5555-5555', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `created_at`, `updated_at`, `deleted_at`, `nome`, `senha`, `email`) VALUES
(1, '2021-02-05 13:41:18', '2021-02-05 13:41:18', NULL, 'Tiago', 'melmodas', 'tiagoalves@email.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cliente_produto`
--
ALTER TABLE `cliente_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_has_produto_produto1_idx` (`produto_id`),
  ADD KEY `fk_cliente_has_produto_cliente_idx` (`cliente_id`);

--
-- Índices para tabela `cliente_promocao`
--
ALTER TABLE `cliente_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_has_promocao_promocao1_idx` (`promocao_id`),
  ADD KEY `fk_cliente_has_promocao_cliente1_idx` (`cliente_id`);

--
-- Índices para tabela `nota_promissoria`
--
ALTER TABLE `nota_promissoria`
  ADD PRIMARY KEY (`id`,`cliente_produto_id`),
  ADD KEY `fk_nota_promissoria_cliente_produto1_idx` (`cliente_produto_id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `promocao`
--
ALTER TABLE `promocao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`id`,`cliente_id`),
  ADD KEY `fk_telefone_cliente1_idx` (`cliente_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cliente_produto`
--
ALTER TABLE `cliente_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cliente_promocao`
--
ALTER TABLE `cliente_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nota_promissoria`
--
ALTER TABLE `nota_promissoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `promocao`
--
ALTER TABLE `promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente_produto`
--
ALTER TABLE `cliente_produto`
  ADD CONSTRAINT `fk_cliente_has_produto_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_produto_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `cliente_promocao`
--
ALTER TABLE `cliente_promocao`
  ADD CONSTRAINT `fk_cliente_has_promocao_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_promocao_promocao1` FOREIGN KEY (`promocao_id`) REFERENCES `promocao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `nota_promissoria`
--
ALTER TABLE `nota_promissoria`
  ADD CONSTRAINT `fk_nota_promissoria_cliente_produto1` FOREIGN KEY (`cliente_produto_id`) REFERENCES `cliente_produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `fk_telefone_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
