<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido #<?= (int)$pedido['id'] ?></title>
    <link rel="stylesheet" href="http://localhost/ERP_montink/css/pedido/detalhesPedido.css">
</head>
<body>
    <div>
        <h1>Pedido #<?= (int)$pedido['id_pedido'] ?></h1>
        <p><strong>Status:</strong> <?= htmlspecialchars($pedido['status']) ?></p>
        <p><strong>Frete:</strong> <?= $pedido['frete'] == 0 ? 'Grátis' : 'R$ ' . number_format($pedido['frete'], 2, ',', '.') ?></p>
        <p><strong>Desconto:</strong> R$ <?= number_format($pedido['desconto'], 2, ',', '.') ?></p>
        <p><strong>Total do Pedido:</strong> R$ <?= number_format($pedido['total_pedido'], 2, ',', '.') ?></p>


        <?php if (empty($pedido['itens'])): ?>
            <p>Este pedido não possui itens.</p>
        <?php else: ?>
            <h2>Itens do Pedido</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Variação</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido['itens'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome_produto'] ?? '---') ?></td>
                            <td><?= htmlspecialchars($item['nome_variacao'] ?? '---') ?></td>
                            <td><?= (int)$item['quantidade'] ?></td>
                            <td>R$<?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                            <td>R$<?= number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <p><a href="index.php?controller=pedido&action=index">Voltar para Lista de Pedidos</a></p>
    </div>
</body>
</html>
