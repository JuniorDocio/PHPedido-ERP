<?php


class Carrinho
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    public function adicionarItem($id_variacao, $id_produto, $quantidade)
    {
        if (isset($_SESSION['carrinho'][$id_variacao])) {
            $_SESSION['carrinho'][$id_variacao]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id_variacao] = [
                'quantidade' => $quantidade,
                'id_produto' => $id_produto
            ];
        }
        return true;
    }


    public function atualizar($id_variacao, $quantidade)
    {
        if ($quantidade <= 0) {
            unset($_SESSION['carrinho'][$id_variacao]);
        } else {
            $_SESSION['carrinho'][$id_variacao] = $quantidade;
        }
        return true;
    }

    public function remover($id_variacao)
    {
        if (isset($_SESSION['carrinho'][$id_variacao])) {
            unset($_SESSION['carrinho'][$id_variacao]);
        }
        return true;
    }

    public function listar()
    {
        require_once __DIR__ . '/variacao.php';
        $variacaoModel = new Variacao();

        $itens = [];

        foreach ($_SESSION['carrinho'] as $id_variacao => $dados) {
            $variacao = $variacaoModel->buscarPorId($id_variacao);

            if ($variacao) {
                $itens[] = [
                    'id_variacao' => $id_variacao,
                    'id_produto' => $dados['id_produto'],
                    'nome_variacao' => $variacao['nome'],
                    'quantidade' => $dados['quantidade'],
                    'preco' => $variacao['preco']
                ];
            }
        }

        return $itens;
    }


    public function limpar()
    {
        $_SESSION['carrinho'] = [];
        return true;
    }

    public function aplicarCupom($codigo)
    {
        require_once __DIR__ . '/cupom.php';
        $cupomModel = new Cupom();
        $cupom = $cupomModel->buscarPorCodigo($codigo);

        if (!$cupom) {
            unset($_SESSION['cupom']);
            return "Cupom inválido ou expirado.";
        }

        $total = 0;
        require_once __DIR__ . '/variacao.php';
        $variacaoModel = new Variacao();

        foreach ($_SESSION['carrinho'] as $id_variacao => $dados) {
            $variacao = $variacaoModel->buscarPorId($id_variacao);
            if ($variacao) {
                $total += $variacao['preco'] * $dados['quantidade'];
            }
        }

        if ($total < $cupom['valor_minimo']) {
            unset($_SESSION['cupom']);
            return "Este cupom requer um valor mínimo de R$ " . number_format($cupom['valor_minimo'], 2, ',', '.');
        }

        $_SESSION['cupom'] = [
            'codigo' => $cupom['codigo'],
            'percentual'   => 'percentual',
            'valor'  => $cupom['desconto_percentual']
        ];
        return true;
    }

    public function getCupom()
    {
        return $_SESSION['cupom'] ?? null;
    }

}
