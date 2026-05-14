<?php
/* ─────────────────────────────────────────────
   Processamento
───────────────────────────────────────────── */
$errors  = [];
$success = '';
$old     = [];

function clean(string $v): string {
    return trim(htmlspecialchars($v, ENT_QUOTES, 'UTF-8'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old = [
        'nome'      => clean($_POST['nome']      ?? ''),
        'descricao' => clean($_POST['descricao'] ?? ''),
        'email'     => clean($_POST['email']     ?? ''),
        'telefone'  => clean($_POST['telefone']  ?? ''),
        'site'      => clean($_POST['site']      ?? ''),
        'endereco'  => clean($_POST['endereco']  ?? ''),
    ];

    // Nome
    if ($old['nome'] === '') {
        $errors['nome'] = 'Nome é obrigatório.';
    } elseif (mb_strlen($old['nome']) < 3) {
        $errors['nome'] = 'Nome deve ter pelo menos 3 caracteres.';
    }

    // Descrição
    if ($old['descricao'] === '') {
        $errors['descricao'] = 'Descrição é obrigatória.';
    } elseif (mb_strlen($old['descricao']) < 10) {
        $errors['descricao'] = 'Descrição deve ter pelo menos 10 caracteres.';
    }

    // E-mail
    if ($old['email'] === '') {
        $errors['email'] = 'E-mail é obrigatório.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail inválido.';
    }

    // Telefone
    $telDigits = preg_replace('/\D/', '', $old['telefone']);
    if ($old['telefone'] === '') {
        $errors['telefone'] = 'Telefone é obrigatório.';
    } elseif (strlen($telDigits) < 10 || strlen($telDigits) > 11) {
        $errors['telefone'] = 'Telefone inválido (10 ou 11 dígitos).';
    }

    // Endereço
    if ($old['endereco'] === '') {
        $errors['endereco'] = 'Endereço é obrigatório.';
    } elseif (mb_strlen($old['endereco']) < 5) {
        $errors['endereco'] = 'Endereço deve ter pelo menos 5 caracteres.';
    }

    // Site (opcional)
    if ($old['site'] !== '' && !filter_var($old['site'], FILTER_VALIDATE_URL)) {
        $errors['site'] = 'URL inválida. Use http:// ou https://.';
    }

    // Sem erros: salva no banco
    if (empty($errors)) {
        require_once __DIR__ . '/../database/connection.php';
        require_once __DIR__ . '/../repository/UserRepository.php';

        $repo  = new UserRepository();
        $salvo = $repo->CadastrarOng(
            $old['nome'],
            $old['descricao'],
            $old['email'],
            $old['telefone'],
            $old['site'],
            $old['endereco']
        );

        if (!$salvo) {
            $errors['geral'] = 'Erro ao salvar no banco. Tente novamente.';
        } else {
            $success = "ONG \"{$old['nome']}\" cadastrada com sucesso!";
            $old = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de ONG</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #ecfdf5 0%, #ccfbf1 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .card {
      width: 100%;
      max-width: 560px;
      background: #fff;
      border-radius: 1.25rem;
      box-shadow: 0 20px 60px rgba(0,0,0,.10), 0 4px 16px rgba(0,0,0,.06);
      padding: 2.5rem 2rem;
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .icon-wrap {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 4rem;
      height: 4rem;
      background: #d1fae5;
      border-radius: 50%;
      margin-bottom: 1rem;
    }
    .icon-wrap svg {
      width: 2rem; height: 2rem;
      fill: none; stroke: #059669;
      stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    .header h1 { font-size: 1.75rem; font-weight: 700; color: #111827; margin-bottom: .3rem; }
    .header p  { color: #6b7280; font-size: .95rem; }

    /* Alert */
    .alert {
      padding: .85rem 1rem;
      border-radius: .6rem;
      font-size: .9rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
    .alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

    /* Form */
    .form-group { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.25rem; }

    label {
      font-size: .875rem;
      font-weight: 600;
      color: #374151;
    }
    label .req { color: #dc2626; margin-left: 2px; }

    .input-wrap { position: relative; }
    .input-wrap .ico {
      position: absolute;
      top: 50%; left: .8rem;
      transform: translateY(-50%);
      width: 1.05rem; height: 1.05rem;
      fill: none; stroke: #9ca3af;
      stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
      pointer-events: none;
    }
    .input-wrap.ta-wrap .ico { top: .85rem; transform: none; }

    input, textarea {
      width: 100%;
      padding: .72rem .9rem .72rem 2.5rem;
      border: 1.5px solid #d1d5db;
      border-radius: .55rem;
      font-size: .925rem;
      color: #111827;
      background: #f9fafb;
      outline: none;
      transition: border-color .18s, box-shadow .18s, background .18s;
      font-family: inherit;
    }
    textarea { resize: vertical; min-height: 7rem; }

    input:focus, textarea:focus {
      border-color: #059669;
      box-shadow: 0 0 0 3px rgba(5,150,105,.15);
      background: #fff;
    }
    input.err, textarea.err {
      border-color: #dc2626;
      box-shadow: 0 0 0 3px rgba(220,38,38,.10);
    }
    .field-err { font-size: .8rem; color: #dc2626; }

    /* Button */
    .btn {
      width: 100%;
      padding: .85rem 1.5rem;
      background: #059669;
      color: #fff;
      border: none;
      border-radius: .6rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      transition: background .2s, box-shadow .2s, transform .1s;
      margin-top: .5rem;
    }
    .btn:hover  { background: #047857; box-shadow: 0 4px 14px rgba(5,150,105,.35); }
    .btn:active { transform: scale(.98); }
    .btn svg    { width: 1.1rem; height: 1.1rem; fill: none; stroke: #fff; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .footer-note { text-align: center; font-size: .78rem; color: #9ca3af; margin-top: 1.25rem; }


    .btn-voltar-fixo {
      position: fixed;
      top: 1.25rem;
      left: 1.25rem;
      display: flex;
      align-items: center;
      gap: .4rem;
      padding: .5rem .9rem;
      background: #fff;
      color: #059669;
      border: 1.5px solid #059669;
      border-radius: .5rem;
      font-size: .875rem;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0,0,0,.08);
      transition: background .2s;
      z-index: 100;
    }
    .btn-voltar-fixo:hover { background: #ecfdf5; }
    .btn-voltar-fixo svg { width: 1rem; height: 1rem; fill: none; stroke: #059669; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    @media (max-width: 480px) {
      .card { padding: 1.75rem 1.25rem; }
    }
  </style>
</head>
<body>
<a href="/models/menu.html" class="btn-voltar-fixo">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Voltar
</a>

<div class="card">

  <div class="header">
    <div class="icon-wrap">
      <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    </div>
    <h1>Cadastro de ONG</h1>
    <p>Preencha os dados da sua organização</p>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      <?= $success ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-error">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Corrija os campos destacados abaixo
      OU Ong já cadastrada!
    </div>
  <?php endif; ?>

  <form method="POST" action="" novalidate>

    <!-- Nome -->
    <div class="form-group">
      <label for="nome">Nome da ONG <span class="req">*</span></label>
      <div class="input-wrap">
        <svg class="ico" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <input
          type="text" id="nome" name="nome"
          placeholder="Ex: Instituto Esperança"
          maxlength="150"
          value="<?= $old['nome'] ?? '' ?>"
          class="<?= isset($errors['nome']) ? 'err' : '' ?>"
        />
      </div>
      <?php if (!empty($errors['nome'])): ?>
        <span class="field-err"><?= $errors['nome'] ?></span>
      <?php endif; ?>
    </div>

    <!-- Descrição -->
    <div class="form-group">
      <label for="descricao">Descrição <span class="req">*</span></label>
      <div class="input-wrap ta-wrap">
        <svg class="ico" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <textarea
          id="descricao" name="descricao"
          rows="4"
          placeholder="Descreva os objetivos e atividades da sua ONG..."
          maxlength="1000"
          class="<?= isset($errors['descricao']) ? 'err' : '' ?>"
        ><?= $old['descricao'] ?? '' ?></textarea>
      </div>
      <?php if (!empty($errors['descricao'])): ?>
        <span class="field-err"><?= $errors['descricao'] ?></span>
      <?php endif; ?>
    </div>

    <!-- E-mail -->
    <div class="form-group">
      <label for="email">E-mail <span class="req">*</span></label>
      <div class="input-wrap">
        <svg class="ico" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <input
          type="email" id="email" name="email"
          placeholder="contato@suaong.org.br"
          maxlength="150"
          value="<?= $old['email'] ?? '' ?>"
          class="<?= isset($errors['email']) ? 'err' : '' ?>"
        />
      </div>
      <?php if (!empty($errors['email'])): ?>
        <span class="field-err"><?= $errors['email'] ?></span>
      <?php endif; ?>
    </div>

    <!-- Telefone -->
    <div class="form-group">
      <label for="telefone">Telefone <span class="req">*</span></label>
      <div class="input-wrap">
        <svg class="ico" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.53 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.56a16 16 0 0 0 6.29 6.29l1.62-1.62a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <input
          type="tel" id="telefone" name="telefone"
          placeholder="(11) 98765-4321"
          maxlength="15"
          value="<?= $old['telefone'] ?? '' ?>"
          class="<?= isset($errors['telefone']) ? 'err' : '' ?>"
        />
      </div>
      <?php if (!empty($errors['telefone'])): ?>
        <span class="field-err"><?= $errors['telefone'] ?></span>
      <?php endif; ?>
    </div>

    <!-- Site -->
    <div class="form-group">
      <label for="site">Site <span style="font-weight:400;color:#9ca3af">(opcional)</span></label>
      <div class="input-wrap">
        <svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        <input
          type="url" id="site" name="site"
          placeholder="https://www.suaong.org.br"
          maxlength="200"
          value="<?= $old['site'] ?? '' ?>"
          class="<?= isset($errors['site']) ? 'err' : '' ?>"
        />
      </div>
      <?php if (!empty($errors['site'])): ?>
        <span class="field-err"><?= $errors['site'] ?></span>
      <?php endif; ?>
    </div>

    <!-- Endereço -->
    <div class="form-group">
      <label for="endereco">Endereço <span class="req">*</span></label>
      <div class="input-wrap">
        <svg class="ico" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <input
          type="text" id="endereco" name="endereco"
          placeholder="Rua Exemplo, 123 – Bairro, Cidade/UF"
          maxlength="200"
          value="<?= $old['endereco'] ?? '' ?>"
          class="<?= isset($errors['endereco']) ? 'err' : '' ?>"
        />
      </div>
      <?php if (!empty($errors['endereco'])): ?>
        <span class="field-err"><?= $errors['endereco'] ?></span>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      Cadastrar ONG
    </button>

  </form>

  <p class="footer-note">Campos com <span style="color:#dc2626">*</span> são obrigatórios.</p>
</div>

<script>
  document.getElementById('telefone').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 11);
    if (v.length > 10) v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    else if (v.length > 6) v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    else if (v.length > 2) v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    this.value = v;
  });
</script>
</body>
</html>
