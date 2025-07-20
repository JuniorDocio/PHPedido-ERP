<?php

require_once __DIR__ . '/../models/produto.php';
require_once __DIR__ . '/../models/estoque.php';
require_once __DIR__ . '/../models/variacao.php';

class ProdutoController
{
    private $produtoModel;
    private $estoqueModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
        $this->estoqueModel = new Estoque();
        $this->variacaoModel = new Variacao();
    }

    public function index()
    {
        $produtos = $this->produtoModel->buscarTodos();
        include __DIR__ . '/../views/produto/lista.php';
    }

    public function criar()
    {
        $produto = null; 
        $variacoes = [];
        include __DIR__ . '/../views/produto/formulario.php';
    }


    public function editar($id)
    {
        $produto = $this->produtoModel->buscarPorId($id);
        $variacoes = $this->variacaoModel->buscarPorProduto($id);
        var_dump($variacoes);

        foreach ($variacoes as &$variacao) {
            $estoque = $this->estoqueModel->obterQuantidade($variacao['id_variacao']);
            $variacao['estoque'] = $estoque ?? 0;
    }

        include __DIR__ . '/../views/produto/formulario.php';
    }

    public function salvar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? null;
        $preco = $_POST['preco'] ?? null;
        $descricao = $_POST['descricao'] ?? null;
        $variacoes = $_POST['variacoes'] ?? [];

        if ($id) {
            // Atualizar produto
            $this->produtoModel->atualizar($id, $nome, $preco, $descricao);
        } else {
            // Criar novo produto
            $id = $this->produtoModel->criar($nome, $preco, $descricao);
        }

        foreach ($variacoes as $variacao) {
            $varNome = $variacao['nome'] ?? null;
            $varEstoque = (int)($variacao['estoque'] ?? 0);

            if ($varNome) {
                if (!empty($variacao['id_variacao'])) {
                    // Atualizar variação existente
                    $this->variacaoModel->atualizar($variacao['id_variacao'], $varNome);
                    $this->estoqueModel->atualizar($variacao['id_variacao'], $varEstoque);
                } else {
                    // Criar nova variação
                    $idVariacao = $this->variacaoModel->criar($id, $varNome);
                    $this->estoqueModel->criar($idVariacao, $varEstoque);
                }
            }
        }

        header('Location: index.php?controller=produto&action=index');
        exit;
    } else {
        echo "Requisição inválida.";
    }
}


    public function removerPorProduto()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->estoqueModel->removerPorProduto($id);

            $this->produtoModel->deletar($id);

            header('Location: index.php?controller=produto&action=index');
            exit;
        } else {
            echo "ID do produto não informado.";
        }
    }

}
