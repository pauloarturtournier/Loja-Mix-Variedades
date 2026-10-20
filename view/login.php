<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login – MixTudo</title>
  <link rel="stylesheet" href="../view/css/style.css" />
</head>
<body class="login-page">
  <div class="card-login">
    <h1>MixTudo Variedades</h1>
    <?php if (!empty($erro)): ?>
      <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
      <div class="alerta alerta-sucesso">Conta criada com sucesso! Faça login.</div>
    <?php endif; ?>
    <form method="POST" action="../controller/LoginController.php">
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="email@mixtudo.com" required />
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="••••••••" required />
      </div>
      <hr />
      <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>
    <p style="text-align:center; margin-top:1rem;">
      Não tem conta? <a href="../controller/RegistrarController.php">Cadastre-se</a>
    </p>
  </div>
</body>
</html>
