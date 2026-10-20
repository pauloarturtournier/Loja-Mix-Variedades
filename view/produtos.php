<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produtos – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card">

    <?php if ($acao === 'listar'): ?>
      <h1>Produtos</h1>
      <?php if (!empty($sucesso)): ?><div class="alerta alerta-sucesso"><?php echo htmlspecialchars($sucesso); ?></div><?php endif; ?>

      <?php if (!empty($produtos)): ?>
      <table>
        <tr><th>Nome</th><th>Preço</th><th>Est.</th><th>Ações</th></tr>
        <?php foreach ($produtos as $p): ?>
        <tr>
          <td><?php echo htmlspecialchars($p['nome']); ?></td>
          <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
          <td><?php echo $p['estoque']; ?></td>
          <td>
            <a href="../controller/ProdutoController.php?acao=editar&id=<?php echo $p['id']; ?>" class="btn btn-sm">Editar</a>
            <a href="../controller/ProdutoController.php?acao=excluir&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhum produto cadastrado.</p>
      <?php endif; ?>

      <hr />
      <a href="../controller/ProdutoController.php?acao=cadastrar" class="btn btn-primary">Novo Produto</a>
      <a href="../controller/DashboardController.php" class="btn">Voltar</a>

    <?php elseif ($acao === 'cadastrar'): ?>
      <h1>Novo Produto</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/ProdutoController.php?acao=salvar">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" name="nome" placeholder="Nome do produto" required />
        </div>
        <div class="form-group">
          <label>Categoria</label>
          <select name="categoria_id">
            <option value="">— Selecione —</option>
            <?php foreach ($categorias as $cat): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Preço (R$)</label>
          <input type="number" name="preco" placeholder="0,00" min="0" step="0.01" required />
        </div>
        <div class="form-group">
          <label>Estoque</label>
          <input type="number" name="estoque" placeholder="0" min="0" required />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/ProdutoController.php?acao=listar" class="btn">Voltar</a>
      </form>

    <?php elseif ($acao === 'editar' && $produto): ?>
      <h1>Editar Produto</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/ProdutoController.php?acao=atualizar">
        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>" />
        <div class="form-group">
          <label>Nome</label>
          <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required />
        </div>
        <div class="form-group">
          <label>Categoria</label>
          <select name="categoria_id">
            <option value="">— Selecione —</option>
            <?php foreach ($categorias as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $produto['categoria_id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($cat['nome']); ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Preço (R$)</label>
          <input type="number" name="preco" value="<?php echo $produto['preco']; ?>" min="0" step="0.01" required />
        </div>
        <div class="form-group">
          <label>Estoque</label>
          <input type="number" name="estoque" value="<?php echo $produto['estoque']; ?>" min="0" required />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/ProdutoController.php?acao=listar" class="btn">Voltar</a>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>
