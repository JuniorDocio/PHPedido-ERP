<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>

    <link rel="stylesheet" href="http://localhost/ERP_montink/css/pedido/lista.css">
</head>
<body>
    <div>
        <h1>Lista de Pedidos</h1>

        <?php if (empty($pedidos)): ?>
            <p>Nenhum pedido encontrado.</p>
        <?php else: ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido['id_pedido']) ?></td>
                            <td><?= htmlspecialchars($pedido['status']) ?></td>
                            <td>R$ <?= number_format($pedido['total_pedido'], 2, ',', '.') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                            <td>
                                <a id="ver-detalhes-pedido" href="http://localhost/ERP_montink/index.php?controller=pedido&action=ver&id=<?= $pedido['id_pedido'] ?>">Ver</a> |
                                <a id="excluir-pedido" href="http://localhost/ERP_montink/index.php?controller=pedido&action=deletar&id=<?= $pedido['id_pedido'] ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <a id="voltar-lista-produtos" href="index.php?controller=produto&action=index">Voltar para Lista de Produtos</a>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
