<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>EcoMapa Brasil · Acesso ao Sistema</title>
  <meta name="description" content="Plataforma de gestão de projetos ecológicos — EcoMapa Brasil">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
  <div class="login-card">
    <div class="brand">
      <div class="logo-icon" aria-hidden="true">🌱</div>
      <h1>EcoMapa Brasil</h1>
      <p class="tagline">Sistema de Gestão de Projetos Ecológicos</p>
    </div>

    <div class="form-header">
      <h2>Entrar no Sistema</h2>
      <div class="accent-line"></div>
    </div>

    <form class="login-form" action="/controllers/login.php" method="post">
      <div class="input-group">
        <label for="email">E-mail</label>
        <div class="input-icon-field">
          <span class="field-icon">📧</span>
          <input type="email" id="email" name="email" placeholder="seu@email.com" autocomplete="email" required>
        </div>
      </div>

      <div class="input-group">
        <label for="password">Senha</label>
        <div class="input-icon-field">
          <span class="field-icon">🔒</span>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
        </div>
      </div>

      <button type="submit" class="btn-entrar">Entrar</button>

      <div class="signup-prompt">
        <span>Não tem uma conta?</span>
        <a href="/models/cad_usuarios.php" class="signup-link">Cadastre-se gratuitamente</a>
      </div>
    </form>

    <?php if (isset($_GET['erro'])): ?>
      <div class="error-message" style="color:#d32f2f; background:#ffebee; padding:0.75rem; border-radius:8px; margin-top:1rem; text-align:center;">
        ⚠️ E-mail ou senha inválidos. Tente novamente.
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['sucesso'])): ?>
        <div style="color:#1a4d2c; background:#eaf7e6; padding:0.75rem; border-radius:8px; margin-top:1rem; text-align:center;">
            ✅ Cadastro realizado! Faça login.
        </div>
    <?php endif; ?>
  </div>

  <footer class="footer">
    <div class="footer-content">
      <p class="copyright">© 2026 EcoMapa Brasil. Todos os direitos reservados.</p>
      <div class="footer-links">
        <a href="#">Termos de Uso</a>
        <span class="separator">·</span>
        <a href="#">Política de Privacidade</a>
        <span class="separator">·</span>
        <a href="#">Suporte</a>
      </div>
    </div>
  </footer>
</div>

</body>
</html>