<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>EcoMapa Brasil · Cadastro</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, sans-serif;
      background: linear-gradient(145deg, #eaf7e6 0%, #c8e6d9 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    /* Container principal – mesma largura do login */
    .cadastro-container {
      max-width: 520px;
      width: 100%;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    /* Card branco – idêntico ao login */
    .cadastro-card {
      background: #ffffff;
      border-radius: 2rem;
      padding: 2.2rem 2rem 2.5rem;
      box-shadow: 0 20px 35px -12px rgba(0, 32, 16, 0.15);
      transition: transform 0.2s ease;
    }

    /* Marca / cabeçalho */
    .brand {
      text-align: center;
      margin-bottom: 1.8rem;
    }

    .logo-icon {
      font-size: 3rem;
      background: #eef6e9;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 30px;
      margin: 0 auto 0.8rem;
    }

    .brand h1 {
      font-size: 1.9rem;
      font-weight: 700;
      color: #1a4d2c;
      letter-spacing: -0.3px;
    }

    .tagline {
      font-size: 0.85rem;
      color: #4b6b53;
      font-weight: 500;
      margin-top: 0.25rem;
      border-top: 1px solid #e2efe4;
      display: inline-block;
      padding-top: 0.5rem;
    }

    /* Título do formulário */
    .form-header {
      text-align: center;
      margin: 1.2rem 0 1.6rem;
    }

    .form-header h2 {
      font-size: 1.6rem;
      font-weight: 600;
      color: #1f2e24;
      margin-bottom: 8px;
    }

    .accent-line {
      width: 60px;
      height: 4px;
      background: #3faa5e;
      border-radius: 4px;
      margin: 0 auto;
    }

    /* Formulário */
    .cadastro-form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .input-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .input-group label {
      font-weight: 600;
      font-size: 0.9rem;
      color: #1e3a2f;
      letter-spacing: -0.2px;
      margin-left: 0.25rem;
    }

    /* Campo de entrada – mesmo estilo do login */
    .input-field {
      background: #f9fbf9;
      border: 1px solid #ddebe0;
      border-radius: 1.2rem;
      padding: 0.85rem 1rem;
      font-size: 1rem;
      font-family: inherit;
      color: #1c2e23;
      outline: none;
      transition: all 0.2s;
      width: 100%;
    }

    .input-field:focus {
      border-color: #2c8c4a;
      box-shadow: 0 0 0 3px rgba(47, 167, 89, 0.2);
      background: #ffffff;
    }

    .input-field::placeholder {
      color: #a5c0ae;
      font-weight: 400;
    }

    /* Botão – mesma cor, gradiente e tamanho */
    .btn-cadastrar {
      background: linear-gradient(95deg, #238b45 0%, #1a6e3b 100%);
      border: none;
      padding: 0.9rem;
      font-size: 1.05rem;
      font-weight: 700;
      font-family: inherit;
      color: white;
      border-radius: 2.5rem;
      cursor: pointer;
      transition: 0.18s linear;
      margin-top: 0.5rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .btn-cadastrar:hover {
      background: linear-gradient(95deg, #1e713b 0%, #145a30 100%);
      transform: scale(0.98);
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Link para login */
    .login-prompt {
      text-align: center;
      margin-top: 0.6rem;
      font-size: 0.9rem;
      color: #3f5c49;
      border-top: 1px solid #e4efdf;
      padding-top: 1.5rem;
    }

    .login-link {
      color: #1f7840;
      font-weight: 700;
      text-decoration: none;
      margin-left: 0.3rem;
      transition: color 0.2s;
    }

    .login-link:hover {
      color: #0e562f;
      text-decoration: underline;
    }

    /* Rodapé – idêntico ao login */
    .footer {
      text-align: center;
    }

    .footer-content {
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(4px);
      border-radius: 2rem;
      padding: 0.9rem 1.2rem;
      font-size: 0.75rem;
      color: #2c523c;
    }

    .copyright {
      font-weight: 500;
      margin-bottom: 0.4rem;
    }

    .footer-links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 0.35rem;
      font-size: 0.7rem;
    }

    .footer-links a {
      color: #2e6b45;
      text-decoration: none;
      font-weight: 500;
    }

    .footer-links a:hover {
      text-decoration: underline;
      color: #124b2a;
    }

    .separator {
      opacity: 0.6;
      color: #668b74;
    }

    /* Responsividade */
    @media (max-width: 520px) {
      body {
        padding: 1rem;
      }
      .cadastro-card {
        padding: 1.8rem 1.5rem 2rem;
        border-radius: 1.5rem;
      }
      .brand h1 {
        font-size: 1.6rem;
      }
      .form-header h2 {
        font-size: 1.4rem;
      }
      .btn-cadastrar {
        padding: 0.8rem;
        font-size: 1rem;
      }
      .footer-content {
        padding: 0.7rem 1rem;
      }
    }

    @media (max-width: 380px) {
      .cadastro-card {
        padding: 1.5rem 1.2rem;
      }
      .login-prompt {
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="cadastro-container">
    <div class="cadastro-card">
      <div class="brand">
        <div class="logo-icon" aria-hidden="true">🌱</div>
        <h1>EcoMapa Brasil</h1>
        <p class="tagline">Sistema de Gestão de Projetos Ecológicos</p>
      </div>

      <div class="form-header">
        <h2>Criar nova conta</h2>
        <div class="accent-line"></div>
      </div>

      <!-- action atualizado -->
      <form class="cadastro-form" action="/controllers/cad_usuarios.php" method="post">
        <div class="input-group">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome" name="nome" class="input-field" placeholder="Seu nome" autocomplete="name" required>
        </div>

        <div class="input-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" class="input-field" placeholder="seu@email.com" autocomplete="email" required>
        </div>

        <div class="input-group">
          <label for="confirmar_email">Confirmar e-mail</label>
          <input type="email" id="confirmar_email" name="confirmar_email" class="input-field" placeholder="digite o e-mail novamente" required>
        </div>

        <div class="input-group">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha" class="input-field" placeholder="crie uma senha" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn-cadastrar">Cadastrar</button>

        <div class="login-prompt">
          <span>Já tem uma conta?</span>
          <a href="/models/login.php" class="login-link">Faça login</a>
        </div>
      <?php if (isset($_GET['erro'])): ?>
        <div style="color:#d32f2f; background:#ffebee; padding:0.75rem; border-radius:8px; margin-top:1rem; text-align:center;">
          <?php if ($_GET['erro'] === 'campos'): ?>
            ⚠️ Preencha todos os campos.
          <?php elseif ($_GET['erro'] === 'email'): ?>
            ⚠️ Os e-mails não coincidem 
          <?php elseif ($_GET['erro'] === 'existe'): ?>
            OU e-mail já está cadastrado.
          <?php endif; ?>
        </div>
      <?php endif; ?>
      </form>
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