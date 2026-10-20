<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Relatórios – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card">

    <?php if ($acao === 'mais-vendidos'): ?>
      <h1>Mais Vendidos</h1>
      <?php if (!empty($dados)): ?>
      <table>
        <tr><th>Produto</th><th>Qtd</th><th>Receita</th></tr>
        <?php foreach ($dados as $d): ?>
        <tr>
          <td><?php echo htmlspecialchars($d['nome']); ?></td>
          <td><?php echo $d['total_vendido']; ?></td>
          <td>R$ <?php echo number_format($d['total_receita'], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhuma venda registrada.</p>
      <?php endif; ?>

    <?php elseif ($acao === 'estoque-baixo'): ?>
      <h1>Estoque Baixo</h1>
      <?php if (!empty($dados)): ?>
      <table>
        <tr><th>Produto</th><th>Categoria</th><th>Estoque</th></tr>
        <?php foreach ($dados as $d): ?>
        <tr>
          <td><?php echo htmlspecialchars($d['nome']); ?></td>
          <td><?php echo $d['categoria_nome'] ? htmlspecialchars($d['categoria_nome']) : '—'; ?></td>
          <td style="color:<?php echo $d['estoque'] == 0 ? '#c0392b' : '#e67e22'; ?>;font-weight:600"><?php echo $d['estoque']; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhum produto com estoque baixo.</p>
      <?php endif; ?>

    <?php elseif ($acao === 'total-vendas'): ?>
      <h1>Total de Vendas</h1>
      <?php if (!empty($dados)): ?>
      <table>
        <tr><th>Mês</th><th>Vendas</th><th>Total</th></tr>
        <?php foreach ($dados as $d): ?>
        <tr>
          <td><?php echo date('m/Y', strtotime($d['mes'] . '-01')); ?></td>
          <td><?php echo $d['quantidade']; ?></td>
          <td>R$ <?php echo number_format($d['total'], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhuma venda registrada.</p>
      <?php endif; ?>
    <?php endif; ?>

    <hr />
    <a href="../controller/DashboardController.php" class="btn">Voltar</a>

  </div>
</body>
</html>
