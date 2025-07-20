<?php

require_once 'models/estoque.php';

class EstoqueController
{
    private $estoqueModel;

    public function __construct()
    {
        $this->estoqueModel = new Estoque();
    }

    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_variacao = $_POST['id_variacao'] ?? null;
            $quantidade = $_POST['quantidade'] ?? null;

            if ($id_variacao && $quantidade !== null) {
                $this->estoqueModel->criar($id_variacao, $quantidade);
                header('Location: index.php?controller=produto&action=editar&id=' . (int)$_POST['id_produto']);
                exit;
            }
        }

        echo "Dados inválidos para criar estoque.";
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_variacao = $_POST['id_variacao'] ?? null;
            $quantidade = $_POST['quantidade'] ?? null;

            if ($id_variacao && $quantidade !== null) {
                $this->estoqueModel->atualizar($id_variacao, $quantidade);
                header('Location: index.php?controller=produto&action=editar&id=' . (int)$_POST['id_produto']);
                exit;
            }
        }

        echo "Dados inválidos para atualizar estoque.";
    }

    public function mostrar()
    {
        if (isset($_GET['id_variacao'])) {
            $quantidade = $this->estoqueModel->obterQuantidade((int)$_GET['id_variacao']);
            echo "Quantidade em estoque: " . $quantidade;
        } else {
            echo "ID da variação não fornecido.";
        }
    }

    public function reduzir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_variacao = $_POST['id_variacao'] ?? null;
            $quantidade = $_POST['quantidade'] ?? null;

            if ($id_variacao && $quantidade !== null) {
                $this->estoqueModel->reduzir($id_variacao, $quantidade);
                header('Location: index.php?controller=pedido&action=finalizado');
                exit;
            }
        }

        echo "Dados inválidos para reduzir estoque.";
    }
}
