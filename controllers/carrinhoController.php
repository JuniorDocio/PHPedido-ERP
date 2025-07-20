<?php

require_once __DIR__ . '/../models/Carrinho.php';

class CarrinhoController
{
    private $carrinhoModel;

    public function __construct()
    {
        $this->carrinhoModel = new Carrinho();
    }


    public function adicionar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_variacao = isset($_POST['id_variacao']) ? (int)$_POST['id_variacao'] : null;
            $id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
            $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

            if ($id_variacao && $id_produto && $quantidade > 0) {
                $this->carrinhoModel->adicionarItem($id_variacao, $id_produto, $quantidade);

                header('Location: index.php?controller=carrinho&action=lista');
                exit;
            } else {
                echo "Dados inválidos para adicionar ao carrinho.";
            }
        }
    }

    public function remover()
    {
        if (isset($_GET['id_variacao'])) {
            $id_variacao = (int)$_GET['id_variacao'];
            $this->carrinhoModel->remover($id_variacao);
            header('Location: index.php?controller=carrinho&action=lista');
            exit;
        }
    }

    public function limpar()
    {
        $this->carrinhoModel->limpar();
        header('Location: index.php?controller=carrinho&action=lista');
        exit;
    }

    public function lista()
    {
        $itens = $this->carrinhoModel->listar();
        require_once __DIR__ . '/../views/carrinho/lista.php';
    }

    public function aplicarCupom()
    {
        $codigo = $_POST['cupom'] ?? '';
        $carrinhoModel = new Carrinho();
        $resultado = $carrinhoModel->aplicarCupom($codigo);

        if ($resultado === true) {
            $_SESSION['mensagem'] = "Cupom aplicado com sucesso!";
        } else {
            $_SESSION['mensagem'] = $resultado;
        }

        header('Location: index.php?controller=carrinho&action=lista');
        exit;
    }
}
