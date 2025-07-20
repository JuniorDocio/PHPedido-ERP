<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/produtoController.php';
require_once __DIR__ . '/controllers/pedidoController.php';
require_once __DIR__ . '/controllers/cupomController.php';
require_once __DIR__ . '/controllers/estoqueController.php';
require_once __DIR__ . '/controllers/carrinhoController.php';

$controller = $_GET['controller'] ?? 'produto';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($controller) {
    case 'produto':
        $produtoController = new ProdutoController();
        if ($action === 'index') {
            $produtoController->index();
        } elseif ($action === 'criar') {
            $produtoController->criar();
        } elseif ($action === 'editar' && $id) {
            $produtoController->editar($id);
        } elseif ($action === 'salvar') {
            $produtoController->salvar();
        } elseif ($action === 'removerPorProduto') {
            $produtoController->removerPorProduto();
        } else {
            echo "Ação não encontrada";
        }
        break;

    case 'pedido':
        $pedidoController = new PedidoController();

        if ($action === 'index') {
            $pedidoController->index();

        } elseif ($action === 'ver' && $id) {
            $pedidoController->ver($id);

        } elseif ($action === 'criar') {
            $pedidoController->criar();

        } elseif ($action === 'salvar') {
            $pedidoController->salvar();

        } elseif ($action === 'deletar' && $id) {
            $pedidoController->deletar($id);

        } elseif ($action === 'finalizar') {
            $pedidoController->finalizar();
        
        } else {
            echo "Ação não encontrada";
        }
        break;

    case 'cupom':
        $cupomController = new CupomController();

        if ($action === 'index') {
            $cupomController->index();

        } elseif ($action === 'criar') {
            $cupomController->criar();

        } elseif ($action === 'editar' && isset($_GET['id'])) {
            $cupomController->editar();

        } elseif ($action === 'deletar' && isset($_GET['id'])) {
            $cupomController->deletar();

        } else {
            echo "Ação não encontrada";
        }
        break;

    case 'estoque':
        $estoqueController = new EstoqueController();

        if ($action === 'criar') {
            $estoqueController->criar();

        } elseif ($action === 'atualizar') {
            $estoqueController->atualizar();

        } elseif ($action === 'mostrar' && isset($_GET['id_variacao'])) {
            $estoqueController->mostrar();

        } elseif ($action === 'reduzir') {
            $estoqueController->reduzir();

        } else {
            echo "Ação não encontrada";
        }
        break;

     case 'carrinho':
        $carrinhoController = new CarrinhoController();

        if ($action === 'adicionar') {
            $carrinhoController->adicionar();
        } elseif ($action === 'remover') {
            $carrinhoController->remover();
        } elseif ($action === 'limpar') {
            $carrinhoController->limpar();
        } elseif ($action === 'lista') {
            $carrinhoController->lista();
        } elseif ($action === 'aplicarCupom') {
            $carrinhoController->aplicarCupom();
        } else {
            echo "Ação do carrinho não encontrada";
        }
        break;

    default:
        echo "Controller não encontrado";
        break;
}
