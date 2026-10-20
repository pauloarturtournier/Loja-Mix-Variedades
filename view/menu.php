<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body>
  <div class="card" style="text-align:center">
    <h1>MixTudo Variedades</h1>

    <a href="../controller/ProdutoController.php?acao=listar"  class="btn btn-primary">Produtos</a>
    <a href="../controller/CategoriaController.php?acao=listar" class="btn btn-primary">Categorias</a>
    <a href="../controller/ClienteController.php?acao=listar"  class="btn btn-primary">Clientes</a>
    <a href="../controller/VendaController.php?acao=registrar" class="btn btn-primary">Nova Venda</a>
    <a href="../controller/VendaController.php?acao=historico" class="btn btn-primary">Histórico de Vendas</a>

    <hr />

    <a href="../controller/RelatorioController.php?acao=mais-vendidos" class="btn btn-primary">Mais Vendidos</a>
    <a href="../controller/RelatorioController.php?acao=estoque-baixo" class="btn btn-primary">Estoque Baixo</a>
    <a href="../controller/RelatorioController.php?acao=total-vendas"  class="btn btn-primary">Total de Vendas</a>

    <hr />

    <a href="../controller/LogoutController.php" class="btn btn-primary">Sair</a>
  </div>
</body>
</html>
