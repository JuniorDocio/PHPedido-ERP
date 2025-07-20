<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= isset($produto['id_produto']) ? 'Editar Produto' : 'Cadastrar Produto' ?></title>

        <link rel="stylesheet" href="http://localhost/ERP_montink/css/produto/formulario.css">
</head>
<body>

<div id='formulario-cadastro-produto'>
    <h2><?= isset($produto['id_produto']) ? 'Editar Produto' : 'Cadastrar Produto' ?></h2>

    <form action="http://localhost/ERP_montink/index.php?controller=produto&action=salvar" method="POST">

        <?php if (isset($produto['id_produto'])): ?>
            <input type="hidden" name="id" value="<?= (int)$produto['id_produto'] ?>">
        <?php endif; ?>

        <label>Nome:</label><br>
        <input type="text" name="nome" required value="<?= htmlspecialchars($produto['nome'] ?? '') ?>"><br><br>

        <label>Preço (R$):</label><br>
        <input type="number" step="0.01" name="preco" required value="<?= htmlspecialchars($produto['preco'] ?? '') ?>"><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea><br><br>

        <h3>Variações:</h3>
        <div id="variacoes-container">
            <?php if (!empty($variacoes)): ?>
                <?php foreach ($variacoes as $i => $var): ?>
                    <div class="variacao-item">
                        <input type="hidden" name="variacoes[<?= $i ?>][id_variacao]" value="<?= (int)$var['id_variacao'] ?>">

                        <input type="text" name="variacoes[<?= $i ?>][nome]" placeholder="Ex: Tamanho M" required value="<?= htmlspecialchars($var['nome']) ?>">

                        <input type="number" name="variacoes[<?= $i ?>][estoque]" placeholder="Estoque" required value="<?= (int)$var['estoque'] ?>">

                        <button type="button" onclick="removerVariacao(this)">Remover</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="variacao-item">
                    <input id='nome-variacao' type="text" name="variacoes[0][nome]" placeholder="Ex: Tamanho M" required>
                    <input id='valor-estoque' type="number" name="variacoes[0][estoque]" placeholder="Estoque" required>
                    <button id='remover-variacao' type="button" onclick="removerVariacao(this)">Remover</button>
                </div>
            <?php endif; ?>
        </div>
        <br>
        <button id='adicionar-variacao' type="button" onclick="adicionarVariacao()">+ Adicionar Variação</button><br><br>
            <input type="submit" value="Salvar Produto">
    </form>

    <script>
        let variacaoIndex = <?= isset($variacoes) ? count($variacoes) : 1 ?>;

        function adicionarVariacao() {
            const container = document.getElementById('variacoes-container');
            const div = document.createElement('div');
            div.classList.add('variacao-item');
            div.innerHTML = `
                <input type="text" name="variacoes[${variacaoIndex}][nome]" placeholder="Ex: Tamanho M" required>
                <input type="number" name="variacoes[${variacaoIndex}][estoque]" placeholder="Estoque" required>
                <button type="button" onclick="removerVariacao(this)">Remover</button>
            `;
            container.appendChild(div);
            variacaoIndex++;
        }

        function removerVariacao(button) {
            button.parentElement.remove();
        }
    </script>
</div>

</body>
</html>
