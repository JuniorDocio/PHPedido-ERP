<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($cupom['id']) ? 'Editar Cupom' : 'Cadastrar Cupom' ?></title>

    <link rel="stylesheet" href="http://localhost/ERP_montink/css/cupom/formulario.css">
</head>
<body>
    <div>
        <h2><?= isset($cupom['id']) ? 'Editar Cupom' : 'Cadastrar Cupom' ?></h2>

        <form action="http://localhost/ERP_montink/index.php?controller=cupom&action=criar" method="POST">

            <?php if (isset($cupom['id_cupom'])): ?>
                <input type="hidden" name="id" value="<?= (int)$cupom['id_cupom'] ?>">
            <?php endif; ?>

            <label>Código:</label><br>
            <input type="text" name="codigo" required value="<?= htmlspecialchars($cupom['codigo'] ?? '') ?>"><br><br>

            <label>Desconto (%):</label><br>
            <input type="number" name="desconto_percentual" step="0.01" min="0" max="100" required value="<?= htmlspecialchars($cupom['desconto_percentual'] ?? '') ?>"><br><br>

            <label>Validade:</label><br>
            <input type="date" name="validade" value="<?= htmlspecialchars($cupom['validade'] ?? '') ?>"><br>
            <small>Deixe em branco para cupom sem validade.</small><br><br>

            <label>Valor Mínimo para Uso (R$):</label><br>
            <input type="number" name="valor_minimo" step="0.01" min="0" required value="<?= htmlspecialchars($cupom['valor_minimo'] ?? '0') ?>"><br><br>

            <label id='cupom-ativo'>
                <input type="checkbox" name="ativo" value="1" <?= (!isset($cupom['ativo']) || $cupom['ativo']) ? 'checked' : '' ?>>
                Ativo
            </label><br><br>

            <input type="submit" value="Salvar Cupom">
            <a href="index.php?controller=cupom&action=index" style="margin-left: 10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>
