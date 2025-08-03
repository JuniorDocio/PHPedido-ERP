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

```-- Table: cupons
CREATE TABLE cupons (
    id_cupom INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL,
    validade DATETIME NOT NULL,
    desconto_percentual INT NOT NULL,
    ativo TINYINT(1) NOT NULL,
    valor_minimo DECIMAL(10,2) NOT NULL
);

-- Table: produtos
CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    id_estoque INT NOT NULL,
    descricao VARCHAR(255)
);

-- Table: variacoes
CREATE TABLE variacoes (
    id_variacao INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

-- Table: estoque
CREATE TABLE estoque (
    id_estoque INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    id_variacao INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto),
    FOREIGN KEY (id_variacao) REFERENCES variacoes(id_variacao)
);

-- Table: pedidos
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    total_pedido DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    data_pedido DATETIME NOT NULL,
    id_cupom INT NOT NULL,
    frete DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cupom) REFERENCES cupons(id_cupom)
);

-- Table: pedido_itens
CREATE TABLE pedido_itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    id_variacao INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto),
    FOREIGN KEY (id_variacao) REFERENCES variacoes(id_variacao)
);```
