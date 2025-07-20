<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="http://localhost/ERP_montink/css/carrinho/lista.css">
</head>
<body>
    <div>
        <h1>Carrinho de Compras</h1>

        <?php if (empty($itens)): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Variação</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>

                <?php 
                    $total = 0; 
                    foreach ($itens as $item):
                        $subtotal = $item['preco'] * $item['quantidade'];
                        $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nome_variacao']) ?></td>
                        <td><?= (int)$item['quantidade'] ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td>
                            <a id="remover-produto-carrinho" href="index.php?controller=carrinho&action=remover&id_variacao=<?= (int)$item['id_variacao'] ?>" onclick="return confirm('Remover este item do carrinho?')">Remover</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php
                
                if ($total >= 52.00 && $total <= 166.59) {
                    $frete = 15.00;
                } elseif ($total > 200.00) {
                    $frete = 0.00;
                } else {
                    $frete = 20.00;
                }
                $_SESSION['frete'] = $frete;

                
                $desconto = 0;
                if (isset($_SESSION['cupom'])) {
                    $cupom = $_SESSION['cupom'];
                    
                    if ($cupom['percentual'] === 'percentual') {
                        $desconto = ($total * $cupom['valor']) / 100;
                    } elseif ($cupom['percentual'] === 'fixo') {
                        $desconto = $cupom['valor'];
                    }

                    if ($desconto > $total) {
                        $desconto = $total; 
                    }
                }
                $_SESSION['desconto'] = $desconto;

                $total_com_frete = $total - $desconto + $frete;
            ?>

            <?php if (isset($_SESSION['mensagem_erro'])): ?>
                <p style="color: red;"><strong><?= htmlspecialchars($_SESSION['mensagem_erro']) ?></strong></p>
                <?php unset($_SESSION['mensagem_erro']); ?>
            <?php endif; ?>

            <p><strong>Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>

            <?php if ($desconto > 0): ?>
                <p><strong>Desconto:</strong> - R$ <?= number_format($desconto, 2, ',', '.') ?> (Cupom: <?= htmlspecialchars($cupom['codigo']) ?>)</p>
            <?php endif; ?>

            <p><strong>Frete:</strong> <?= $frete == 0 ? 'Grátis' : 'R$ ' . number_format($frete, 2, ',', '.') ?></p>
            <p><strong>Total com Frete:</strong> R$ <?= number_format($total_com_frete, 2, ',', '.') ?></p>

            <form method="POST" action="index.php?controller=carrinho&action=aplicarCupom">
                <label for="cupom">Cupom de Desconto:</label>
                <input type="text" name="cupom" id="cupom">
                <button type="submit">Aplicar Cupom</button>
            </form>

            <section>
                <p><a href="index.php?controller=produto&action=index">Continuar Comprando</a></p>
                <p><a id="limpar-carrinho" href="index.php?controller=carrinho&action=limpar" onclick="return confirm('Tem certeza que deseja limpar o carrinho?')">Limpar Carrinho</a></p>
            </section>

            <form method="POST" action="index.php?controller=pedido&action=finalizar">
                <input type="hidden" name="frete" value="<?= $frete ?>">
                <button id='finalizar-compra' type="submit">Finalizar Compra</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
