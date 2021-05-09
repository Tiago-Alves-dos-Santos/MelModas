-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Maio-2021 às 18:23
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.4.16

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
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `id` int(11) NOT NULL,
  `dinheiro_inicio` double DEFAULT NULL,
  `moeda_inicio` double DEFAULT NULL,
  `dinheiro_fim` double DEFAULT NULL,
  `moeda_fim` double DEFAULT NULL,
  `lucro_dia` double DEFAULT NULL,
  `hora_fechado` time DEFAULT NULL,
  `status_caixa` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, '2021-04-21 14:40:21', '2021-04-21 14:40:21', NULL, 'Consumidor Final', '-', '-', 0, 'Não ira fazer partes das promoções', '0001-01-01');

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
  `peso_vendido` double DEFAULT NULL,
  `cliente_anonimo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Estrutura da tabela `depositos`
--

CREATE TABLE `depositos` (
  `id` int(11) NOT NULL,
  `local` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
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
-- Estrutura da tabela `peso_venda`
--

CREATE TABLE `peso_venda` (
  `id` int(11) DEFAULT NULL,
  `valor_compra` double DEFAULT NULL,
  `valor_venda` double DEFAULT NULL,
  `peso_total` double DEFAULT NULL,
  `alert_peso` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `peso_venda`
--

INSERT INTO `peso_venda` (`id`, `valor_compra`, `valor_venda`, `peso_total`, `alert_peso`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0.001, 0.035, 0, 50, '2021-04-21 00:47:58', '2021-05-05 13:21:18', NULL);

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
  `descricao` text DEFAULT NULL,
  `peso` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, '2021-04-21 14:40:21', '2021-04-21 14:40:21', NULL, '(00) 0 0000-0000', 1);

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
  `email` varchar(255) DEFAULT NULL,
  `tipo_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `created_at`, `updated_at`, `deleted_at`, `nome`, `senha`, `email`, `tipo_user`) VALUES
(1, '2021-02-05 13:41:18', '2021-02-05 13:41:18', NULL, 'Tiago', 'melmodas', 'tiagoalves@email.com', 'admin'),
(2, '2021-04-22 13:20:43', '2021-04-22 13:20:43', NULL, 'Fulano Gerenciador', 'gerenciador', 'gerenciador@email.com', 'gerenciador'),
(3, '2021-04-22 13:21:45', '2021-04-22 13:21:45', NULL, 'Atendente Fulano', 'atendente', 'atendente@email.com', 'atendente'),
(4, '2021-04-22 13:29:50', '2021-04-22 13:33:07', '2021-04-22 13:33:07', 'Excluir', '345345', 'tiago@email.com', 'atendente');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id`);

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
-- Índices para tabela `depositos`
--
ALTER TABLE `depositos`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cliente_produto`
--
ALTER TABLE `cliente_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente_promocao`
--
ALTER TABLE `cliente_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `depositos`
--
ALTER TABLE `depositos`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
