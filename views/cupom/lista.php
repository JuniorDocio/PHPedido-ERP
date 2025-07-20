<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Cupons</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="http://localhost/ERP_montink/css/cupom/lista.css">
</head>
<body>

<div>
  <h2>Cupons</h2>

  <a href="http://localhost/ERP_montink/index.php?controller=cupom&action=criar">+ Novo Cupom</a>

  <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 10px; width: 100%;">
    <thead>
      <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Desconto (%)</th>
        <th>Validade</th>
        <th>Valor Mínimo (R$)</th>
        <th>Ativo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($cupons)): ?>
        <?php foreach ($cupons as $cupom): ?>
          <tr>
            <td><?= (int)$cupom['id_cupom'] ?></td>
            <td><?= htmlspecialchars($cupom['codigo']) ?></td>
            <td><?= number_format($cupom['desconto_percentual'], 2, ',', '.') ?>%</td>
            <td>
              <?= $cupom['validade'] ? date('d/m/Y', strtotime($cupom['validade'])) : 'Sem validade' ?>
            </td>
            <td>R$ <?= number_format($cupom['valor_minimo'], 2, ',', '.') ?></td>
            <td><?= $cupom['ativo'] ? 'Sim' : 'Não' ?></td>
            <td>
              <a id='editar-lista-cupons' href="http://localhost/ERP_montink/index.php?controller=cupom&action=editar&id=<?= (int)$cupom['id_cupom'] ?>">Editar</a> |
              <a id='excluir-lista-cupons' href="http://localhost/ERP_montink/index.php?controller=cupom&action=deletar&id=<?= (int)$cupom['id_cupom'] ?>" onclick="return confirm('Confirma exclusão do cupom?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7">Nenhum cupom cadastrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
