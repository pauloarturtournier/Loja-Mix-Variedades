<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body class="login-page">
  <div class="card-login">
    <h1>Criar Conta</h1>
    <?php if (!empty($erro)): ?>
      <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form method="POST" action="../controller/RegistrarController.php">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Seu nome" required />
      </div>
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="email@mixtudo.com" required />
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="••••••••" required />
      </div>
      <div class="form-group">
        <label for="confirmar_senha">Confirmar Senha</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="••••••••" required />
      </div>
      <hr />
      <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
    </form>
    <p style="text-align:center; margin-top:1rem;">
      Já tem conta? <a href="../controller/LoginController.php">Faça login</a>
    </p>
  </div>
</body>
</html>
