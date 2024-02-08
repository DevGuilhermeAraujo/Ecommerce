-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Fev-2024 às 14:27
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommercebelezarosa`
--
-- CREATE DATABASE IF NOT EXISTS `ecommercebelezarosa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE `ecommercebelezarosa`;
-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `id` int(3) NOT NULL,
  `description_cat` varchar(30) NOT NULL,
  `input_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `change_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_user` int(5) NOT NULL,
  `change_user` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id`, `description_cat`, `input_date`, `change_date`, `creator_user`, `change_user`) VALUES
(1, 'Perfumaria', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(2, 'Corpo e banho', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(3, 'Maquiagem', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(4, 'Cabelos', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(5, 'Skincare', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(6, 'Encapsulados', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(7, 'Sexshop', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `public_place` varchar(50) DEFAULT NULL,
  `residenceNumber` varchar(50) DEFAULT NULL,
  `neighborhood` varchar(50) DEFAULT NULL,
  `CEP` varchar(9) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `date_Of_Birth` date NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwordUser` varchar(60) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` int(11) DEFAULT NULL,
  `confirmed` int(1) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT 'client',
  `input_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departments`
--

CREATE TABLE `departments` (
  `id` int(3) NOT NULL,
  `description_dep` varchar(30) NOT NULL,
  `input_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `change_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_user` int(5) NOT NULL,
  `change_user` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `departments`
--

INSERT INTO `departments` (`id`, `description_dep`, `input_date`, `change_date`, `creator_user`, `change_user`) VALUES
(1, 'Gerenciador', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(2, 'Direção', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1),
(3, 'Vendedores', '2024-02-08 13:25:42', '2024-02-08 13:25:42', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(9) NOT NULL,
  `prod_name` varchar(100) DEFAULT NULL,
  `prod_desc` longtext DEFAULT NULL,
  `prod_value` decimal(10,2) DEFAULT NULL,
  `prod_category` int(3) DEFAULT NULL,
  `prod_news` int(1) DEFAULT NULL,
  `url_img` varchar(255) DEFAULT NULL,
  `input_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `change_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_user` int(5) NOT NULL,
  `change_user` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `public_place` varchar(50) DEFAULT NULL,
  `residenceNumber` varchar(50) DEFAULT NULL,
  `neighborhood` varchar(50) DEFAULT NULL,
  `date_Of_Birth` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `passwordUser` varchar(60) NOT NULL,
  `departments` int(3) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` int(11) DEFAULT NULL,
  `confirmed` int(1) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT 'employee',
  `input_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_deactivation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `cpf`, `public_place`, `residenceNumber`, `neighborhood`, `date_Of_Birth`, `phone`, `email`, `passwordUser`, `departments`, `active`, `token`, `token_expiration`, `confirmed`, `tipo`, `input_date`, `date_deactivation`) VALUES
(1, 'Administrador', 'Sys', NULL, NULL, NULL, NULL, NULL, NULL, 'devshostinger@gmail.com', 'Devs*hostMG00all', 1, 1, NULL, NULL, NULL, 'manager', '2024-02-08 13:25:42', NULL),
(2, 'Andreia', 'BelezaRosa', NULL, NULL, NULL, NULL, NULL, NULL, 'andreiabelezarosa@gmail.com', 'Coco2124@', 2, 1, NULL, NULL, NULL, 'manager', '2024-02-08 13:25:42', NULL);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `view_client_user_combined`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `view_client_user_combined` (
`id` int(11)
,`first_name` varchar(20)
,`last_name` varchar(40)
,`email` varchar(50)
,`passwordUser` varchar(60)
,`tipo` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `view_client_user_combined`
--
DROP TABLE IF EXISTS `view_client_user_combined`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_client_user_combined`  AS SELECT `clients`.`id` AS `id`, `clients`.`first_name` AS `first_name`, substring_index(`clients`.`last_name`,' ',1) AS `last_name`, `clients`.`email` AS `email`, `clients`.`passwordUser` AS `passwordUser`, `clients`.`tipo` AS `tipo` FROM `clients` union all select `users`.`id` AS `id`,`users`.`first_name` AS `first_name`,substring_index(`users`.`last_name`,' ',1) AS `last_name`,`users`.`email` AS `email`,`users`.`passwordUser` AS `passwordUser`,`users`.`tipo` AS `tipo` from `users`  ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_creator_user_table_category` (`creator_user`),
  ADD KEY `FK_change_user_table_category` (`change_user`);

--
-- Índices para tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_creator_user_table_departments` (`creator_user`),
  ADD KEY `FK_change_user_table_departments` (`change_user`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_creator_user_table_products` (`creator_user`),
  ADD KEY `FK_change_user_table_products` (`change_user`),
  ADD KEY `FK_category_prod_table_products` (`prod_category`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `FK_cpf_unique` (`cpf`),
  ADD KEY `FK_department_user_table_users` (`departments`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_change_user_table_category` FOREIGN KEY (`change_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_creator_user_table_category` FOREIGN KEY (`creator_user`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `FK_change_user_table_departments` FOREIGN KEY (`change_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_creator_user_table_departments` FOREIGN KEY (`creator_user`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_category_prod_table_products` FOREIGN KEY (`prod_category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_change_user_table_products` FOREIGN KEY (`change_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_creator_user_table_products` FOREIGN KEY (`creator_user`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_department_user_table_users` FOREIGN KEY (`departments`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
