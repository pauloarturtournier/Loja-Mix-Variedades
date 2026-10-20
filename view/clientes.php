<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clientes – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card">

    <?php if ($acao === 'listar'): ?>
      <h1>Clientes</h1>
      <?php if (!empty($sucesso)): ?><div class="alerta alerta-sucesso"><?php echo htmlspecialchars($sucesso); ?></div><?php endif; ?>

      <?php if (!empty($clientes)): ?>
      <table>
        <tr><th>Nome</th><th>Telefone</th><th>Ações</th></tr>
        <?php foreach ($clientes as $c): ?>
        <tr>
          <td><?php echo htmlspecialchars($c['nome']); ?></td>
          <td><?php echo $c['telefone'] ? htmlspecialchars($c['telefone']) : '—'; ?></td>
          <td>
            <a href="../controller/ClienteController.php?acao=editar&id=<?php echo $c['id']; ?>" class="btn btn-sm">Editar</a>
            <a href="../controller/ClienteController.php?acao=excluir&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhum cliente cadastrado.</p>
      <?php endif; ?>

      <hr />
      <a href="../controller/ClienteController.php?acao=cadastrar" class="btn btn-primary">Novo Cliente</a>
      <a href="../controller/DashboardController.php" class="btn">Voltar</a>

    <?php elseif ($acao === 'cadastrar'): ?>
      <h1>Novo Cliente</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/ClienteController.php?acao=salvar">
        <div class="form-group">
          <label>Nome Completo</label>
          <input type="text" name="nome" placeholder="Nome completo" required />
        </div>
        <div class="form-group">
          <label>Telefone</label>
          <input type="tel" name="telefone" placeholder="(00) 00000-0000" />
        </div>
        <div class="form-group">
          <label>E-mail</label>
          <input type="email" name="email" placeholder="email@email.com" />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/ClienteController.php?acao=listar" class="btn">Voltar</a>
      </form>

    <?php elseif ($acao === 'editar' && $cliente): ?>
      <h1>Editar Cliente</h1>
      <?php if (!empty($erro)): ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
      <form method="POST" action="../controller/ClienteController.php?acao=atualizar">
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>" />
        <div class="form-group">
          <label>Nome Completo</label>
          <input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required />
        </div>
        <div class="form-group">
          <label>Telefone</label>
          <input type="tel" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" placeholder="(00) 00000-0000" />
        </div>
        <div class="form-group">
          <label>E-mail</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" placeholder="email@email.com" />
        </div>
        <hr />
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="../controller/ClienteController.php?acao=listar" class="btn">Voltar</a>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>
