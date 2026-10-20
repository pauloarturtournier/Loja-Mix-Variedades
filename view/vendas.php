<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vendas – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card">

    <?php if ($acao === 'registrar' || $acao === 'salvar'): ?>
      <h1>Nova Venda</h1>
      <?php if (!empty($sucesso)): ?><div class="alerta alerta-sucesso"><?php echo htmlspecialchars($sucesso); ?></div><?php endif; ?>
      <?php if (!empty($erro)):    ?><div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>

      <form method="POST" action="../controller/VendaController.php?acao=salvar">
        <div class="form-group">
          <label>Cliente (opcional)</label>
          <select name="cliente_id">
            <option value="">— Sem cliente —</option>
            <?php foreach ($clientes as $c): ?>
            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <hr />
        <label style="margin-bottom:0.6rem;display:block">Itens</label>

        <div id="itens">
          <div class="item-linha">
            <select name="produto_id[]" class="select-produto" onchange="preencherPreco(this)">
              <option value="">— Produto —</option>
              <?php foreach ($produtos as $p): ?>
              <option value="<?php echo $p['id']; ?>" data-preco="<?php echo $p['preco']; ?>">
                <?php echo htmlspecialchars($p['nome']); ?> (<?php echo $p['estoque']; ?>)
              </option>
              <?php endforeach; ?>
            </select>
            <input type="number" name="quantidade[]" value="1" min="1" />
            <input type="number" name="preco_unit[]" class="preco-unit" value="0" min="0" step="0.01" />
            <button type="button" class="btn btn-danger" onclick="remover(this)">✕</button>
          </div>
        </div>

        <button type="button" class="btn" style="margin:0.5rem 0" onclick="addItem()">+ Item</button>
        <hr />
        <button type="submit" class="btn btn-primary">Registrar Venda</button>
        <a href="../controller/DashboardController.php" class="btn">Voltar</a>
      </form>

    <?php elseif ($acao === 'historico'): ?>
      <h1>Histórico de Vendas</h1>

      <?php if (!empty($vendas)): ?>
      <table>
        <tr><th>#</th><th>Data</th><th>Cliente</th><th>Total</th></tr>
        <?php foreach ($vendas as $v): ?>
        <tr>
          <td><?php echo $v['id']; ?></td>
          <td><?php echo date('d/m/Y', strtotime($v['data_venda'])); ?></td>
          <td><?php echo $v['cliente_nome'] ? htmlspecialchars($v['cliente_nome']) : '—'; ?></td>
          <td>R$ <?php echo number_format($v['valor_total'], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php else: ?>
        <p style="font-size:0.9rem;color:#888;margin-bottom:1rem">Nenhuma venda registrada.</p>
      <?php endif; ?>

      <hr />
      <a href="../controller/DashboardController.php" class="btn">Voltar</a>
    <?php endif; ?>

  </div>

<script>
var opcoesHtml = '';
<?php foreach ($produtos as $p): ?>
opcoesHtml += '<option value="<?php echo $p['id']; ?>" data-preco="<?php echo $p['preco']; ?>"><?php echo addslashes($p['nome']); ?> (<?php echo $p['estoque']; ?>)</option>';
<?php endforeach; ?>

function addItem() {
  var div = document.createElement('div');
  div.className = 'item-linha';
  div.innerHTML =
    '<select name="produto_id[]" class="select-produto" onchange="preencherPreco(this)">' +
    '<option value="">— Produto —</option>' + opcoesHtml + '</select>' +
    '<input type="number" name="quantidade[]" value="1" min="1" />' +
    '<input type="number" name="preco_unit[]" class="preco-unit" value="0" min="0" step="0.01" />' +
    '<button type="button" class="btn btn-danger" onclick="remover(this)">✕</button>';
  document.getElementById('itens').appendChild(div);
}

function remover(btn) {
  var linhas = document.querySelectorAll('.item-linha');
  if (linhas.length > 1) btn.closest('.item-linha').remove();
}

function preencherPreco(select) {
  var preco = select.options[select.selectedIndex].getAttribute('data-preco') || '0';
  select.closest('.item-linha').querySelector('.preco-unit').value = parseFloat(preco).toFixed(2);
}
</script>
</body>
</html>
