# 🛒 ERP System in PHP for Sales Management

This project implements a ERP system developed in **pure PHP** for managing **products**, **orders**, **inventory**, **coupons**, and **shopping carts**. The goal is to provide a practical and lightweight tool for small and medium-sized businesses to efficiently manage their sales operations. 📦

## Overview

The system offers a web-based interface that enables administrators to perform essential commercial tasks such as managing product variations, tracking inventory, applying discount coupons, and handling customer orders through an integrated shopping cart flow. This solution streamlines the sales process and improves control over the entire operation. 🧾

## Key Features

- 🛍️ Register and manage products with variations and stock control  
- 📦 Complete order management with status, shipping, and discounts  
- 🎟️ Apply and validate discount coupons  
- 🛒 Integrated shopping cart to streamline the order flow  
- 🖥️ Intuitive web interface for ease of use by administrators

## Database

The system uses a relational MySQL database. Below is the full script to create the database and all necessary tables with foreign key constraints.

### 🎯 Create the database
```
The database name should be: erp_montink

-- Table: cupons
CREATE TABLE `cupons` (
  `id_cupom` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `validade` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `desconto_percentual` float NOT NULL,
  `ativo` int(11) NOT NULL,
  `valor_minimo` float NOT NULL
);

-- Table: produtos
CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` float NOT NULL,
  `id_estoque` int(11) NOT NULL,
  `descricao` text NOT NULL
);

-- Table: variacoes
CREATE TABLE `variacoes` (
  `id_variacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
);

-- Table: estoque
CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_variacao` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
);

-- Table: pedidos
CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `total_pedido` float NOT NULL,
  `status` varchar(255) NOT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_cupom` int(11) NOT NULL,
  `frete` float NOT NULL,
  `desconto` float NOT NULL
);

-- Table: pedido_itens
CREATE TABLE `pedido_itens` (
  `id_item` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_variacao` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` float NOT NULL
);
