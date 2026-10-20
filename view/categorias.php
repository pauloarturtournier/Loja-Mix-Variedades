<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Categorias – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card">

    <?php if ($acao === 'listar'): ?>
      <h1>Categorias</h1>
      <?php if (!empty($sucesso)): ?><div class="alerta alerta-sucesso"><?php echo htmlspecialchars($sucesso); ?></div><?php endif; ?>

      <?php if (!empty($categorias)): ?>
      <table>
        <tr><th>Nome</th><th>Ações</th></tr>
        <?php foreach ($categorias as $cat): ?>
        <tr>
          <td><?php echo htmlspecialchars($cat['nome']); ?></td>
          <td>
            <a href="../controller/CategoriaController.php?acao=editar&id=<?php echo $cat['id']; ?>" class="btn btn-sm">Editar</a>
            <a href="../controller/CategoriaController.php?acao=excluir&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhuma categoria cadastrada.</p>
      <?php endif; ?>

      <hr />
      <a href="../controller/CategoriaController.php?acao=cadastrar" class="btn btn-primary">Nova Categoria</a>
      <a href="../controller/DashboardController.php" class="btn">Voltar</a>

    <?php elseif ($acao === 'cadastrar'): ?>
      <h1>Nova Categoria</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/CategoriaController.php?acao=salvar">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" placeholder="Nome da categoria" required />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/CategoriaController.php?acao=listar" class="btn">Voltar</a>
      </form>

    <?php elseif ($acao === 'editar' && $categoria): ?>
      <h1>Editar Categoria</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/CategoriaController.php?acao=atualizar">
        <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>" />
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($categoria['nome']); ?>" required />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/CategoriaController.php?acao=listar" class="btn">Voltar</a>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>
