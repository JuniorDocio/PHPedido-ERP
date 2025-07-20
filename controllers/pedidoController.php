<?php

require_once 'models/pedido.php';
require_once 'models/produto.php';
require_once 'models/variacao.php';

class PedidoController
{
    private $pedidoModel;
    private $produtoModel;
    private $variacaoModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->pedidoModel = new Pedido();
        $this->produtoModel = new Produto();
        $this->variacaoModel = new Variacao(); 
    }

    public function index()
    {
        $pedidos = $this->pedidoModel->buscarTodos();
        require 'views/pedido/lista.php';
    }

    public function ver($id)
    {
        $pedido = $this->pedidoModel->buscarPorId($id);
        if (!$pedido) {
            echo "Pedido não encontrado.";
            exit;
        }

        require 'views/pedido/detalhesPedido.php';
    }

    public function criar()
    {
        $produtos = $this->produtoModel->buscarTodos();
        require 'views/pedido/formulario.php';
    }

    public function salvar()
    {
        $status = $_POST['status'] ?? 'pendente';
        $total = $_POST['total_pedido'] ?? 0.00;
        $itens = $_POST['itens'] ?? [];
        $frete = $_POST['frete'] ?? 0.00;
        $desconto = $_POST['desconto'] ?? 0.00;

        try {
            $id_pedido = $this->pedidoModel->criar($status, $total, $frete, $desconto, $itens);
            header("Location: /pedido/ver/$id_pedido");
            exit;
        } catch (Exception $e) {
            echo "Erro ao salvar pedido: " . $e->getMessage();
        }
    }

    public function deletar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "ID não informado.";
            exit;
        }

        $this->pedidoModel->deletar($id);
        header("Location: index.php?controller=pedido&action=index");
        exit;
    }

    public function finalizar()
    {
        if (empty($_SESSION['carrinho'])) {
            header('Location: index.php?controller=carrinho&action=index');
            exit;
        }

        $itens = [];
        $total = 0;

        foreach ($_SESSION['carrinho'] as $id_variacao => $item) {
            $variacao = $this->variacaoModel->buscarPorId($id_variacao);
            if (!$variacao) {
                continue;
            }

            $quantidade = (int)$item['quantidade'];
            $preco = (float)$variacao['preco'];

            $subtotal = $preco * $quantidade;
            $total += $subtotal;

            $itens[] = [
                'id_produto' => $item['id_produto'],
                'quantidade' => $quantidade,
                'preco_unitario' => $preco,
                'id_variacao' => $id_variacao
            ];
        }

        if ($total >= 52.00 && $total <= 166.59) {
            $frete = 15.00;
        } elseif ($total > 200.00) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }

        $desconto = 0;
        if (!empty($_SESSION['cupom'])) {
            $cupom = $_SESSION['cupom'];

            $tipo = strtolower(trim($cupom['percentual'] ?? ''));
            $valor = isset($cupom['valor']) ? (float)$cupom['valor'] : 0;

            if ($tipo === 'percentual' && $valor > 0) {
                $desconto = ($total * $valor) / 100;
                if ($desconto > $total) {
                    $desconto = $total;
                }
                $total -= $desconto;
            }
        }
        
        $total_com_frete = $total + $frete;

        try {
            $id_pedido = $this->pedidoModel->criar('pendente', $total_com_frete, $frete, $desconto, $itens);

            unset($_SESSION['carrinho']);
            unset($_SESSION['cupom']);

            header("Location: index.php?controller=pedido&action=index");
            exit;
        } catch (Exception $e) {
            echo "Erro ao finalizar pedido: " . $e->getMessage();
        }
    }
}
?>
