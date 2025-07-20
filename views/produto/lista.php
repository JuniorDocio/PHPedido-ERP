<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>

    <link rel="stylesheet" href="http://localhost/ERP_montink/css/produto/lista.css">
</head>
<body>
    <div id='lista-produtos'>
        <h1>Produtos</h1>

        <a href="http://localhost/ERP_montink/index.php?controller=produto&action=criar">Novo Produto</a>

        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th><th>Nome</th><th>Preço</th><th>Variações</th><th>Ações</th>
            </tr>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id_produto'] ?></td>
                    <td><?= $produto['nome'] ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td>
                        <?php
                            require_once __DIR__ . '/../../models/variacao.php';
                            $variacaoModel = new Variacao();
                            $variacoes = $variacaoModel->buscarPorProduto($produto['id_produto']);
                        ?>

                        <?php foreach ($variacoes as $variacao): ?>
                            <div style="margin-bottom: 10px;">
                                <?= $variacao['nome'] ?> |
                                <form action="index.php?controller=carrinho&action=adicionar" method="post" style="display:inline;">
                                    <input type="hidden" name="id_variacao" value="<?= $variacao['id_variacao'] ?>">
                                    <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                                    <input type="number" name="quantidade" value="1" min="1" style="width: 50px;">
                                    <button type="submit">Comprar</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a id='editar-lista-produtos' href="index.php?controller=produto&action=editar&id=<?= $produto['id_produto'] ?>">Editar</a>
                        <a id='excluir-lista-produtos' href="index.php?controller=produto&action=removerPorProduto&id=<?= (int)$produto['id_produto'] ?>" onclick="return confirm('Confirma exclusão do produto?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
