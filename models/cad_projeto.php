<?php
// ============================================================
// PROCESSAMENTO DO FORMULÁRIO
// ============================================================
$errors   = [];
$success  = false;
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name'        => trim($_POST['name']        ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'category'    => trim($_POST['category']    ?? ''),
        'status'      => trim($_POST['status']      ?? ''),
        'state'       => trim($_POST['state']       ?? ''),
        'city'        => trim($_POST['city']        ?? ''),
        'ong'         => trim($_POST['ong']         ?? ''),
        'ong_id'      => trim($_POST['ong_id']      ?? ''),
        'startDate'   => trim($_POST['startDate']   ?? ''),
        'area'        => trim($_POST['area']        ?? ''),
        'impact'      => trim($_POST['impact']      ?? ''),
    ];

    if (empty($formData['name']))
        $errors['name'] = 'O nome do projeto é obrigatório.';
    elseif (strlen($formData['name']) < 5)
        $errors['name'] = 'O nome deve ter pelo menos 5 caracteres.';
    elseif (strlen($formData['name']) > 120)
        $errors['name'] = 'O nome deve ter no máximo 120 caracteres.';

    if (empty($formData['description']))
        $errors['description'] = 'A descrição é obrigatória.';
    elseif (strlen($formData['description']) < 20)
        $errors['description'] = 'A descrição deve ter pelo menos 20 caracteres.';

    $validCategories = ['reflorestamento','reciclagem','energia','educacao'];
    if (empty($formData['category']))
        $errors['category'] = 'Selecione uma categoria.';
    elseif (!in_array($formData['category'], $validCategories))
        $errors['category'] = 'Categoria inválida.';

    $validStatuses = ['ativo','planejamento','concluido'];
    if (empty($formData['status']))
        $errors['status'] = 'Selecione um status.';
    elseif (!in_array($formData['status'], $validStatuses))
        $errors['status'] = 'Status inválido.';

    $validStates = ['Acre','Alagoas','Amapá','Amazonas','Bahia','Ceará','Distrito Federal','Espírito Santo','Goiás','Maranhão','Mato Grosso','Mato Grosso do Sul','Minas Gerais','Pará','Paraíba','Paraná','Pernambuco','Piauí','Rio de Janeiro','Rio Grande do Norte','Rio Grande do Sul','Rondônia','Roraima','Santa Catarina','São Paulo','Sergipe','Tocantins'];
    if (empty($formData['state']))
        $errors['state'] = 'Selecione um estado.';
    elseif (!in_array($formData['state'], $validStates))
        $errors['state'] = 'Estado inválido.';

    if (empty($formData['city']))
        $errors['city'] = 'A cidade é obrigatória.';
    elseif (!preg_match('/^[\p{L}\s\-\.\']{2,80}$/u', $formData['city']))
        $errors['city'] = 'Nome de cidade inválido.';

    if (empty($formData['ong']))
        $errors['ong'] = 'O nome da organização é obrigatório.';
    elseif (strlen($formData['ong']) < 3)
        $errors['ong'] = 'O nome da ONG deve ter pelo menos 3 caracteres.';

    if (!empty($formData['ong_id']) && !preg_match('/^\d+$/', $formData['ong_id']))
        $errors['ong_id'] = 'ID da ONG inválido.';

    if (empty($formData['startDate']))
        $errors['startDate'] = 'A data de início é obrigatória.';
    else {
        $d = DateTime::createFromFormat('Y-m-d', $formData['startDate']);
        if (!$d || $d->format('Y-m-d') !== $formData['startDate'])
            $errors['startDate'] = 'Data inválida.';
    }

    if (!empty($formData['area']) && !preg_match('/^[\d\s\.,a-zA-Záàãâéêíóôõúç]+$/u', $formData['area']))
        $errors['area'] = 'Área de atuação inválida.';

    if (empty($formData['impact']))
        $errors['impact'] = 'Descreva o impacto ambiental esperado.';

    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedMime = ['image/jpeg','image/png','image/webp'];
        if (!in_array($_FILES['image']['type'], $allowedMime))
            $errors['image'] = 'Formato inválido. Use JPG, PNG ou WEBP.';
        elseif ($_FILES['image']['size'] > 5 * 1024 * 1024)
            $errors['image'] = 'Arquivo muito grande. Máximo 5MB.';
        else
            $imageName = $_FILES['image']['name'];
    }

    if (empty($errors)) $success = true;
}

function old(string $key, array $data, string $default = ''): string {
    return htmlspecialchars($data[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}
function err(string $key, array $errors): string {
    return isset($errors[$key])
        ? '<span class="field-error"><svg viewBox="0 0 16 16" fill="none"><path d="M8 5v3m0 2.5v.5M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>'.htmlspecialchars($errors[$key]).'</span>'
        : '';
}
function hasErr(string $key, array $errors): string {
    return isset($errors[$key]) ? ' has-error' : '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo Projeto — EcoMapa Brasil</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,500;9..144,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

/* ── PALETA EcoMapa Brasil ── */
:root{
  --ep: #2d7a3a;   /* primary green (botão login) */
  --ep-h:#1e5c2a;  /* hover */
  --ed: #1a4d25;   /* dark green (títulos) */
  --em: #3d8c4a;   /* mid green */
  --el: #eaf5eb;   /* light bg */
  --el2:#f2f9f2;   /* lighter bg */
  --eb: #b5d6b5;   /* border */
  --ebf:#4d9c5a;   /* border focus */
  --eg: rgba(45,122,58,.13); /* glow */

  --n50:#f8faf8;--n100:#f1f5f1;--n200:#e2e8e2;--n300:#c8d4c8;
  --n400:#96a896;--n500:#637063;--n600:#4a534a;--n700:#333b33;
  --n800:#1e241e;

  --r500:#ef4444;--r600:#dc2626;
  --a400:#c9960c;

  --rs:6px;--r:12px;--rl:18px;--rxl:26px;
}

html{font-size:16px;scroll-behavior:smooth}
body{
  font-family:'DM Sans',sans-serif;font-weight:400;color:var(--n800);min-height:100vh;
  background:
    radial-gradient(ellipse 1100px 700px at 80% -5%, #c5dfc5 0%, transparent 65%),
    radial-gradient(ellipse 700px 700px at -8% 90%,  #bdd8bd 0%, transparent 60%),
    linear-gradient(155deg,#ddeedd 0%,#e5f0e5 45%,#d5e8d5 100%);
}

/* TOPBAR */
.tb{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.9);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid var(--eb);padding:0 2rem;height:64px;display:flex;align-items:center;justify-content:space-between}
.tb-brand{display:flex;align-items:center;gap:.75rem;text-decoration:none}
.tb-logo{width:36px;height:36px;background:linear-gradient(135deg,var(--ep),var(--em));border-radius:var(--r);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(45,122,58,.3)}
.tb-logo svg{width:20px;height:20px;fill:#fff}
.tb-name{font-family:'Fraunces',serif;font-size:1.2rem;font-weight:700;color:var(--ed);letter-spacing:-.02em}
.tb-bc{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--n500)}
.tb-bc a{color:var(--ep);text-decoration:none;font-weight:500}
.tb-bc a:hover{text-decoration:underline}
.tb-bc .sep{color:var(--n300)}

/* PAGE */
.page{max-width:860px;margin:0 auto;padding:3rem 1.5rem 5rem}
.ph{margin-bottom:2.5rem}
.ph h1{font-family:'Fraunces',serif;font-size:2.25rem;font-weight:700;color:var(--ed);letter-spacing:-.04em;line-height:1.15;margin-bottom:.5rem}
.ph p{font-size:1rem;color:var(--n500);font-weight:300}
.dot{display:inline-block;width:9px;height:9px;background:var(--ep);border-radius:50%;margin-right:.4rem;vertical-align:middle;position:relative;top:-2px;box-shadow:0 0 0 3px rgba(45,122,58,.18)}

/* BANNERS */
.success{background:linear-gradient(135deg,var(--el),#fff);border:1.5px solid var(--eb);border-radius:var(--rl);padding:1.5rem 2rem;display:flex;align-items:flex-start;gap:1rem;margin-bottom:2rem;animation:sld .4s cubic-bezier(.16,1,.3,1)}
.success .ico{width:40px;height:40px;flex-shrink:0;background:var(--ep);border-radius:50%;display:flex;align-items:center;justify-content:center}
.success .ico svg{width:22px;height:22px;stroke:#fff;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.success h3{font-size:1rem;font-weight:600;color:var(--ed);margin-bottom:.25rem}
.success p{font-size:.875rem;color:var(--ep)}

.errsumm{background:#fff5f5;border:1.5px solid #fecaca;border-radius:var(--rl);padding:1.25rem 1.5rem;margin-bottom:2rem;animation:sld .3s cubic-bezier(.16,1,.3,1)}
.errsumm h3{font-size:.9rem;font-weight:600;color:var(--r600);margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem}
.errsumm h3 svg{width:16px;height:16px;stroke:var(--r600);fill:none;stroke-width:2}
.errsumm ul{list-style:none;display:flex;flex-direction:column;gap:.2rem}
.errsumm li{font-size:.85rem;color:var(--r600);padding-left:1rem;position:relative}
.errsumm li::before{content:'—';position:absolute;left:0;color:#fca5a5}

/* CARD */
.card{background:rgba(255,255,255,.97);border:1px solid var(--eb);border-radius:var(--rxl);padding:2rem 2.25rem;margin-bottom:1.5rem;box-shadow:0 2px 12px rgba(45,122,58,.07),0 1px 3px rgba(0,0,0,.04);transition:box-shadow .2s}
.card:focus-within{box-shadow:0 4px 20px rgba(45,122,58,.11),0 1px 4px rgba(0,0,0,.05)}

.stit{font-family:'Fraunces',serif;font-size:1.125rem;font-weight:500;color:var(--ed);margin-bottom:1.75rem;padding-bottom:.875rem;border-bottom:1px solid var(--el);display:flex;align-items:center;gap:.625rem}
.stit .tag{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;background:var(--el);border:1px solid var(--eb);border-radius:8px;flex-shrink:0}
.stit .tag svg{width:14px;height:14px;stroke:var(--ep);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

/* GRID */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
.stk{display:flex;flex-direction:column;gap:1.25rem}
@media(max-width:640px){.g2{grid-template-columns:1fr}}

/* FIELDS */
.field{display:flex;flex-direction:column;gap:.5rem}
.field label{font-size:.875rem;font-weight:500;color:var(--n700);display:flex;align-items:center;gap:.35rem}
.field label .req{color:var(--ep);font-size:1rem;line-height:1}
.field label .hint{margin-left:auto;font-size:.75rem;font-weight:300;color:var(--n400)}
.field input,.field textarea,.field select{width:100%;padding:.7rem 1rem;font-family:'DM Sans',sans-serif;font-size:.9375rem;color:var(--n800);background:var(--el2);border:1.5px solid var(--eb);border-radius:var(--r);outline:none;transition:border-color .18s,box-shadow .18s,background .18s;appearance:none;-webkit-appearance:none}
.field input::placeholder,.field textarea::placeholder{color:var(--n400);font-weight:300}
.field input:hover,.field textarea:hover,.field select:hover{border-color:var(--em);background:#fff}
.field input:focus,.field textarea:focus,.field select:focus{border-color:var(--ep);box-shadow:0 0 0 3px var(--eg);background:#fff}
.field textarea{resize:vertical;min-height:110px;line-height:1.6}

.sw{position:relative}
.sw svg.arr{position:absolute;right:.875rem;top:50%;transform:translateY(-50%);width:16px;height:16px;pointer-events:none;stroke:var(--n400);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;transition:stroke .18s}
.field select{padding-right:2.5rem;cursor:pointer}
.field .sw:has(select:focus) .arr{stroke:var(--ep)}
.field input[type="date"]{cursor:pointer}
.field input[type="date"]::-webkit-calendar-picker-indicator{opacity:.55;cursor:pointer;filter:invert(30%) sepia(60%) saturate(400%) hue-rotate(100deg)}

.field.has-error input,.field.has-error textarea,.field.has-error select{border-color:var(--r500);background:#fff5f5;box-shadow:0 0 0 3px rgba(239,68,68,.08)}
.field-error{font-size:.8125rem;color:var(--r600);display:flex;align-items:center;gap:.375rem;font-weight:400;animation:fdi .2s ease}
.field-error svg{width:14px;height:14px;stroke:var(--r500);fill:none;stroke-width:1.5;stroke-linecap:round;flex-shrink:0}
.field .cc{font-size:.75rem;color:var(--n400);text-align:right;font-weight:300;margin-top:-.25rem}
.field .cc.warn{color:var(--a400)}
.field .cc.over{color:var(--r500)}

/* ONG AUTOCOMPLETE */
.ong-wrap{position:relative}
.ong-badge{display:none;align-items:center;gap:.375rem;margin-top:.375rem;padding:.32rem .8rem;background:var(--el);border:1px solid var(--eb);border-radius:999px;font-size:.8125rem;color:var(--ed);font-weight:500;width:fit-content;animation:fdi .2s ease}
.ong-badge.show{display:inline-flex}
.ong-badge svg{width:13px;height:13px;stroke:var(--ep);fill:none;stroke-width:2;stroke-linecap:round}
.ong-badge strong{color:var(--ep);font-weight:700}

.ong-drop{display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:100;background:#fff;border:1.5px solid var(--eb);border-radius:var(--r);box-shadow:0 8px 24px rgba(45,122,58,.13),0 2px 6px rgba(0,0,0,.06);max-height:200px;overflow-y:auto}
.ong-drop.open{display:block;animation:sld .18s ease}
.ong-opt{padding:.625rem 1rem;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:.75rem;font-size:.9rem;color:var(--n700);border-bottom:1px solid var(--el);transition:background .12s}
.ong-opt:last-child{border-bottom:none}
.ong-opt:hover,.ong-opt.foc{background:var(--el)}
.ong-opt .on{font-weight:500}
.ong-opt .oid{font-size:.75rem;font-weight:600;color:var(--ep);background:var(--el);border:1px solid var(--eb);border-radius:4px;padding:.1rem .4rem;white-space:nowrap;flex-shrink:0}

/* CATEGORY PILLS */
.cgrid{display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem}
@media(max-width:640px){.cgrid{grid-template-columns:repeat(2,1fr)}}
.cpill input[type="radio"]{position:absolute;opacity:0;width:0;height:0}
.cpill label{display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:.875rem .5rem;background:var(--el2);border:1.5px solid var(--eb);border-radius:var(--rl);cursor:pointer;transition:all .18s;text-align:center;font-size:.8125rem;font-weight:500;color:var(--n600)}
.cpill label:hover{border-color:var(--em);background:var(--el);color:var(--ed)}
.cpill input:checked+label{border-color:var(--ep);background:linear-gradient(135deg,var(--el),var(--el2));color:var(--ed);box-shadow:0 0 0 3px var(--eg)}
.cpill .em{font-size:1.5rem;line-height:1}

/* STATUS */
.srow{display:flex;gap:.75rem;flex-wrap:wrap}
.sitem input[type="radio"]{position:absolute;opacity:0;width:0;height:0}
.sitem label{display:flex;align-items:center;gap:.5rem;padding:.5rem 1rem;border:1.5px solid var(--eb);border-radius:999px;cursor:pointer;font-size:.875rem;font-weight:500;color:var(--n600);background:var(--el2);transition:all .18s}
.sitem label:hover{border-color:var(--n300);background:#fff}
.sitem label .dot2{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.sitem[data-s="ativo"] label .dot2{background:var(--ep)}
.sitem[data-s="planejamento"] label .dot2{background:var(--a400)}
.sitem[data-s="concluido"] label .dot2{background:var(--n400)}
.sitem input:checked+label{background:#fff;box-shadow:0 0 0 3px rgba(0,0,0,.05)}
.sitem[data-s="ativo"] input:checked+label{color:var(--ep);border-color:var(--ep);box-shadow:0 0 0 3px var(--eg)}
.sitem[data-s="planejamento"] input:checked+label{color:#7c5a00;border-color:var(--a400);box-shadow:0 0 0 3px rgba(201,150,12,.12)}
.sitem[data-s="concluido"] input:checked+label{color:var(--n600);border-color:var(--n400);box-shadow:0 0 0 3px rgba(100,112,100,.08)}

/* UPLOAD */
.uarea{border:2px dashed var(--eb);border-radius:var(--rl);padding:2.5rem 2rem;text-align:center;cursor:pointer;transition:all .2s;position:relative;background:var(--el2)}
.uarea:hover{border-color:var(--ep);background:var(--el)}
.uarea.drag{border-color:var(--ep);background:var(--el);box-shadow:0 0 0 4px var(--eg)}
.uarea input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.uico{width:48px;height:48px;margin:0 auto .875rem;background:var(--el);border:1px solid var(--eb);border-radius:var(--rl);display:flex;align-items:center;justify-content:center}
.uico svg{width:22px;height:22px;stroke:var(--ep);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.uarea h4{font-size:.9375rem;font-weight:500;color:var(--n700);margin-bottom:.25rem}
.uarea p{font-size:.8125rem;color:var(--n400);font-weight:300}
.uprev{display:none;align-items:center;gap:.75rem;margin-top:1.25rem;padding:.875rem 1rem;background:#fff;border:1px solid var(--eb);border-radius:var(--r);text-align:left}
.uprev.show{display:flex}
.uprev img{width:56px;height:56px;object-fit:cover;border-radius:var(--rs);flex-shrink:0}
.uprev .fi{flex:1;min-width:0}
.uprev .fn{font-size:.875rem;font-weight:500;color:var(--n700);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.uprev .fs{font-size:.75rem;color:var(--n400)}
.uprev .rm{background:none;border:none;color:var(--n400);cursor:pointer;padding:.25rem;border-radius:4px;transition:color .15s;line-height:0}
.uprev .rm:hover{color:var(--r500)}
.uprev .rm svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round}

/* ACTIONS */
.factions{display:flex;gap:1rem;margin-top:2rem}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.78rem 1.75rem;font-family:'DM Sans',sans-serif;font-size:.9375rem;font-weight:500;border-radius:var(--r);cursor:pointer;border:1.5px solid transparent;transition:all .2s cubic-bezier(.4,0,.2,1);text-decoration:none;white-space:nowrap;outline:none}
.btn svg{width:18px;height:18px;flex-shrink:0}
.btn:focus-visible{box-shadow:0 0 0 3px var(--eg)}
.bto{background:rgba(255,255,255,.9);border-color:var(--eb);color:var(--n600);flex:0 0 auto}
.bto svg{stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.bto:hover{background:var(--el);border-color:var(--em);color:var(--ed)}
.btp{background:linear-gradient(160deg,var(--em) 0%,var(--ep) 60%,var(--ep-h) 100%);border-color:transparent;color:#fff;flex:1;position:relative;box-shadow:0 2px 10px rgba(45,122,58,.3),0 1px 3px rgba(0,0,0,.1)}
.btp svg{stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.btp:hover{background:linear-gradient(160deg,var(--ep) 0%,var(--ep-h) 100%);box-shadow:0 5px 20px rgba(45,122,58,.38),0 2px 6px rgba(0,0,0,.12);transform:translateY(-1px)}
.btp:active{transform:translateY(0);box-shadow:0 2px 10px rgba(45,122,58,.2)}
.btp.ld{pointer-events:none;opacity:.75}
.btp.ld .btxt{opacity:0}
.btp .spin{display:none;width:18px;height:18px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;position:absolute}
.btp.ld .spin{display:block}

/* STEPS */
.steps{display:flex;align-items:center;margin-bottom:2.5rem}
.step{display:flex;flex-direction:column;align-items:center;gap:.375rem;flex:1;position:relative}
.sc{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8125rem;font-weight:600;position:relative;z-index:1;transition:all .3s}
.step.act .sc{background:var(--ep);color:#fff;box-shadow:0 0 0 4px var(--eg)}
.step.dn  .sc{background:var(--ed);color:#fff}
.step.off .sc{background:var(--n200);color:var(--n500)}
.sl{font-size:.75rem;font-weight:500;white-space:nowrap}
.step.act .sl{color:var(--ep)}
.step.dn  .sl{color:var(--n500)}
.step.off .sl{color:var(--n400)}
.sline{height:2px;flex:1;background:var(--eb);position:relative;top:-20px;margin:0 -6px}
.sline.dn{background:var(--ep)}

/* ANIMATIONS */
@keyframes sld{from{opacity:0;transform:translateY(-12px)}to{opacity:1;transform:translateY(0)}}
@keyframes fdi{from{opacity:0}to{opacity:1}}
@keyframes spin{to{transform:rotate(360deg)}}

.rn{font-size:.8125rem;color:var(--n400);margin-top:1rem}
.rn span{color:var(--ep);font-size:1rem}
</style>
</head>
<body>

<header class="tb">
    <a href="#" class="tb-brand">
        <div class="tb-logo">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 0c0 0-4 8 0 12 4-4 0-12 0-12zm0 0c0 0 4 8 0 12-4-4 0-12 0-12z"/></svg>
        </div>
        <span class="tb-name">EcoMapa Brasil</span>
    </a>
    <nav class="tb-bc">
        <a href="#">Painel</a><span class="sep">/</span>
        <a href="#">Projetos</a><span class="sep">/</span>
        <span>Novo Projeto</span>
    </nav>
</header>

<main class="page">
    <div class="ph">
        <h1><span class="dot"></span>Novo Projeto</h1>
        <p>Cadastre um novo projeto ecológico no mapa colaborativo</p>
    </div>

    <!-- Steps -->
    <div class="steps" aria-label="Etapas do formulário">
        <div class="step act"><div class="sc">1</div><span class="sl">Informações</span></div>
        <div class="sline"></div>
        <div class="step off"><div class="sc">2</div><span class="sl">Localização</span></div>
        <div class="sline"></div>
        <div class="step off"><div class="sc">3</div><span class="sl">Impacto</span></div>
        <div class="sline"></div>
        <div class="step off"><div class="sc">4</div><span class="sl">Mídia</span></div>
    </div>

    <?php if ($success): ?>
    <div class="success" role="alert">
        <div class="ico"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div>
            <h3>Projeto cadastrado com sucesso!</h3>
            <p>O projeto <strong><?= htmlspecialchars($formData['name']) ?></strong> foi adicionado ao mapa ecológico.</p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="errsumm" role="alert">
        <h3><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Corrija os erros antes de continuar</h3>
        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" novalidate id="pForm">

        <!-- ① INFORMAÇÕES BÁSICAS -->
        <div class="card">
            <h2 class="stit">
                <span class="tag"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span>
                Informações Básicas
            </h2>
            <div class="stk">
                <div class="field <?= hasErr('name',$errors) ?>">
                    <label for="name">Nome do Projeto <span class="req">*</span><span class="hint" id="nc">0 / 120</span></label>
                    <input type="text" id="name" name="name" value="<?= old('name',$formData) ?>" placeholder="Ex: Reflorestamento da Mata Atlântica" maxlength="120" aria-required="true">
                    <div id="nameError"><?= err('name',$errors) ?></div>
                </div>

                <div class="field <?= hasErr('description',$errors) ?>">
                    <label for="description">Descrição <span class="req">*</span><span class="hint" id="dc">0 / 600</span></label>
                    <textarea id="description" name="description" rows="4" placeholder="Descreva os objetivos, atividades e metodologia do projeto..." maxlength="600" aria-required="true"><?= old('description',$formData) ?></textarea>
                    <div id="descriptionError"><?= err('description',$errors) ?></div>
                </div>

                <div class="field <?= hasErr('category',$errors) ?>">
                    <label>Categoria <span class="req">*</span></label>
                    <div class="cgrid">
                        <?php foreach(['reflorestamento'=>['🌿','Reflorestamento'],'reciclagem'=>['♻️','Reciclagem'],'energia'=>['☀️','Energia Renovável'],'educacao'=>['📚','Educação Ambiental']] as $v=>[$em,$lb]): $ck=(old('category',$formData)===$v)?'checked':''; ?>
                        <div class="cpill">
                            <input type="radio" name="category" id="cat_<?=$v?>" value="<?=$v?>" <?=$ck?>>
                            <label for="cat_<?=$v?>"><span class="em"><?=$em?></span><?=$lb?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="categoryError"><?= err('category',$errors) ?></div>
                </div>

                <div class="field <?= hasErr('status',$errors) ?>">
                    <label>Status <span class="req">*</span></label>
                    <div class="srow">
                        <?php foreach(['planejamento'=>'Em Planejamento','ativo'=>'Ativo','concluido'=>'Concluído'] as $v=>$lb): $ck=(old('status',$formData,'planejamento')===$v)?'checked':''; ?>
                        <div class="sitem" data-s="<?=$v?>">
                            <input type="radio" name="status" id="st_<?=$v?>" value="<?=$v?>" <?=$ck?>>
                            <label for="st_<?=$v?>"><span class="dot2"></span><?=$lb?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="statusError"><?= err('status',$errors) ?></div>
                </div>
            </div>
        </div>

        <!-- ② LOCALIZAÇÃO -->
        <div class="card">
            <h2 class="stit">
                <span class="tag"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                Localização
            </h2>
            <div class="g2">
                <div class="field <?= hasErr('state',$errors) ?>">
                    <label for="state">Estado <span class="req">*</span></label>
                    <div class="sw">
                        <select id="state" name="state" aria-required="true">
                            <option value="">Selecione o estado...</option>
                            <?php foreach(['Acre','Alagoas','Amapá','Amazonas','Bahia','Ceará','Distrito Federal','Espírito Santo','Goiás','Maranhão','Mato Grosso','Mato Grosso do Sul','Minas Gerais','Pará','Paraíba','Paraná','Pernambuco','Piauí','Rio de Janeiro','Rio Grande do Norte','Rio Grande do Sul','Rondônia','Roraima','Santa Catarina','São Paulo','Sergipe','Tocantins'] as $s): $sel=(old('state',$formData)===$s)?'selected':''; ?>
                            <option value="<?=htmlspecialchars($s)?>" <?=$sel?>><?=htmlspecialchars($s)?></option>
                            <?php endforeach; ?>
                        </select>
                        <svg class="arr" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div id="stateError"><?= err('state',$errors) ?></div>
                </div>
                <div class="field <?= hasErr('city',$errors) ?>">
                    <label for="city">Cidade <span class="req">*</span></label>
                    <input type="text" id="city" name="city" value="<?= old('city',$formData) ?>" placeholder="Nome da cidade" maxlength="80" aria-required="true">
                    <div id="cityError"><?= err('city',$errors) ?></div>
                </div>
            </div>
        </div>

        <!-- ③ ORGANIZAÇÃO E IMPACTO -->
        <div class="card">
            <h2 class="stit">
                <span class="tag"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                Organização e Impacto
            </h2>
            <div class="stk">

                <!-- ONG + ID -->
                <div class="field <?= hasErr('ong',$errors) ?>">
                    <label for="ong">Organização Responsável (ONG) <span class="req">*</span></label>
                    <div class="ong-wrap">
                        <input type="text" id="ong" name="ong"
                            value="<?= old('ong',$formData) ?>"
                            placeholder="Digite o nome da ONG..."
                            maxlength="100" autocomplete="off" aria-required="true"
                            aria-autocomplete="list" aria-controls="ongDrop">
                        <input type="hidden" id="ong_id" name="ong_id" value="<?= old('ong_id',$formData) ?>">
                        <div class="ong-drop" id="ongDrop" role="listbox"></div>
                    </div>
                    <!-- Badge com ID da ONG selecionada -->
                    <div class="ong-badge <?= !empty($formData['ong_id'])?'show':'' ?>" id="ongBadge">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/></svg>
                        ID da ONG:&nbsp;<strong id="ongIdDisp"><?= old('ong_id',$formData) ?></strong>
                    </div>
                    <div id="ongError"><?= err('ong',$errors) ?></div>
                </div>

                <div class="g2">
                    <div class="field <?= hasErr('startDate',$errors) ?>">
                        <label for="startDate">Data de Início <span class="req">*</span></label>
                        <input type="date" id="startDate" name="startDate" value="<?= old('startDate',$formData) ?>" max="<?= date('Y-m-d',strtotime('+10 years')) ?>" aria-required="true">
                        <div id="startDateError"><?= err('startDate',$errors) ?></div>
                    </div>
                    <div class="field <?= hasErr('area',$errors) ?>">
                        <label for="area">Área de Atuação <span class="hint">opcional</span></label>
                        <input type="text" id="area" name="area" value="<?= old('area',$formData) ?>" placeholder="Ex: 120 hectares" maxlength="60">
                        <div id="areaError"><?= err('area',$errors) ?></div>
                    </div>
                </div>

                <div class="field <?= hasErr('impact',$errors) ?>">
                    <label for="impact">Impacto Ambiental Esperado <span class="req">*</span></label>
                    <input type="text" id="impact" name="impact" value="<?= old('impact',$formData) ?>" placeholder="Ex: 500 toneladas/mês processadas, 50 mil mudas plantadas..." maxlength="160" aria-required="true">
                    <div id="impactError"><?= err('impact',$errors) ?></div>
                </div>
            </div>
        </div>

        <!-- ④ IMAGENS -->
        <div class="card">
            <h2 class="stit">
                <span class="tag"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>
                Imagens
            </h2>
            <div class="field <?= hasErr('image',$errors) ?>">
                <div class="uarea" id="uarea">
                    <input type="file" name="image" id="imgIn" accept="image/jpeg,image/png,image/webp" aria-label="Selecionar imagem">
                    <div class="uico"><svg viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg></div>
                    <h4>Clique ou arraste para fazer upload</h4>
                    <p>PNG, JPG ou WEBP — máximo 5MB</p>
                </div>
                <div class="uprev" id="uprev">
                    <img id="pImg" src="" alt="Preview">
                    <div class="fi"><div class="fn" id="fName">—</div><div class="fs" id="fSize">—</div></div>
                    <button type="button" class="rm" id="rmImg" aria-label="Remover imagem">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <?= err('image',$errors) ?>
            </div>
        </div>

        <p class="rn"><span>*</span> Campos obrigatórios</p>

        <div class="factions">
            <a href="#" class="btn bto">
                <svg viewBox="0 0 24 24" style="stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Cancelar
            </a>
            <button type="submit" class="btn btp" id="subBtn">
                <span class="spin"></span>
                <span class="btxt" style="display:flex;align-items:center;gap:.5rem">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Salvar Projeto
                </span>
            </button>
        </div>
    </form>
</main>

<script>
(function(){
'use strict';

/* ── Char counters ── */
function ctr(id,ctId,max){
    const el=document.getElementById(id),ct=document.getElementById(ctId);
    if(!el||!ct)return;
    const u=()=>{const n=el.value.length;ct.textContent=n+' / '+max;ct.className='hint'+(n>=max?' over':n>max*.9?' warn':'');};
    el.addEventListener('input',u);u();
}
ctr('name','nc',120);ctr('description','dc',600);

/* ── Upload preview ── */
const fi=document.getElementById('imgIn'),pr=document.getElementById('uprev'),pi=document.getElementById('pImg'),fn=document.getElementById('fName'),fs=document.getElementById('fSize'),rb=document.getElementById('rmImg'),ua=document.getElementById('uarea');
function fmt(b){return b<1024?b+' B':b<1048576?(b/1024).toFixed(1)+' KB':(b/1048576).toFixed(1)+' MB';}
function show(f){if(!f)return;const r=new FileReader();r.onload=e=>{pi.src=e.target.result;fn.textContent=f.name;fs.textContent=fmt(f.size);pr.classList.add('show');};r.readAsDataURL(f);}
fi.addEventListener('change',()=>{if(fi.files.length)show(fi.files[0]);});
rb.addEventListener('click',()=>{fi.value='';pr.classList.remove('show');pi.src='';});
['dragenter','dragover'].forEach(ev=>ua.addEventListener(ev,e=>{e.preventDefault();ua.classList.add('drag');}));
['dragleave','drop'].forEach(ev=>ua.addEventListener(ev,e=>{e.preventDefault();ua.classList.remove('drag');}));
ua.addEventListener('drop',e=>{if(e.dataTransfer.files.length){fi.files=e.dataTransfer.files;show(e.dataTransfer.files[0]);}});

/* ── ONG Autocomplete com ID ──
   Substitua ONGS_MOCK por chamada fetch() ao seu endpoint SQL:
   fetch('/api/ongs?q='+encodeURIComponent(q)).then(r=>r.json()).then(render);
*/
const ONGS=[
    {id:1,name:'SOS Mata Atlântica'},{id:2,name:'Recicla Rio'},
    {id:3,name:'Instituto Akatu'},{id:4,name:'WWF Brasil'},
    {id:5,name:'Greenpeace Brasil'},{id:6,name:'TNC Brasil'},
    {id:7,name:'Instituto Socioambiental'},{id:8,name:'Fundação Florestal SP'},
    {id:9,name:'Amazônia Legal'},{id:10,name:'Movimento Lixo Zero'},
];
const oi=document.getElementById('ong'),oidI=document.getElementById('ong_id'),odrop=document.getElementById('ongDrop'),obadge=document.getElementById('ongBadge'),odisp=document.getElementById('ongIdDisp');
let fidx=-1;

function render(items){
    odrop.innerHTML='';fidx=-1;
    if(!items.length){odrop.classList.remove('open');return;}
    items.forEach((o,i)=>{
        const d=document.createElement('div');
        d.className='ong-opt';d.setAttribute('role','option');d.dataset.id=o.id;d.dataset.name=o.name;
        d.innerHTML='<span class="on">'+o.name+'</span><span class="oid">ID #'+o.id+'</span>';
        d.addEventListener('mousedown',()=>pick(o));
        odrop.appendChild(d);
    });
    odrop.classList.add('open');
}
function pick(o){
    oi.value=o.name;oidI.value=o.id;odisp.textContent=o.id;
    obadge.classList.add('show');odrop.classList.remove('open');
    showErr('ong','');
}
function clrId(){oidI.value='';obadge.classList.remove('show');}

oi.addEventListener('input',function(){
    const q=this.value.trim().toLowerCase();clrId();
    if(q.length<2){odrop.classList.remove('open');return;}
    render(ONGS.filter(o=>o.name.toLowerCase().includes(q)));
});
oi.addEventListener('keydown',function(e){
    const opts=odrop.querySelectorAll('.ong-opt');if(!opts.length)return;
    if(e.key==='ArrowDown'){e.preventDefault();fidx=Math.min(fidx+1,opts.length-1);opts.forEach((o,i)=>o.classList.toggle('foc',i===fidx));}
    else if(e.key==='ArrowUp'){e.preventDefault();fidx=Math.max(fidx-1,0);opts.forEach((o,i)=>o.classList.toggle('foc',i===fidx));}
    else if(e.key==='Enter'&&fidx>=0){e.preventDefault();const op=opts[fidx];pick({id:op.dataset.id,name:op.dataset.name});}
    else if(e.key==='Escape'){odrop.classList.remove('open');}
});
oi.addEventListener('blur',()=>setTimeout(()=>odrop.classList.remove('open'),150));

/* ── Validações ── */
const rules={
    name:{required:true,min:5,max:120,label:'Nome do Projeto'},
    description:{required:true,min:20,max:600,label:'Descrição'},
    category:{required:true,label:'Categoria'},
    state:{required:true,label:'Estado'},
    city:{required:true,min:2,label:'Cidade'},
    ong:{required:true,min:3,label:'Organização'},
    startDate:{required:true,label:'Data de Início'},
    impact:{required:true,label:'Impacto Ambiental'},
};
function showErr(name,msg){
    const el=document.getElementById(name+'Error');
    if(el)el.innerHTML=msg?'<span class="field-error"><svg viewBox="0 0 16 16" fill="none"><path d="M8 5v3m0 2.5v.5M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>'+msg+'</span>':'';
    const w=document.querySelector('[name="'+name+'"]')?.closest('.field')||
        (name==='category'?document.querySelector('.cgrid')?.closest('.field'):null)||
        (name==='status'?document.querySelector('.srow')?.closest('.field'):null);
    if(w)w.classList.toggle('has-error',!!msg);
}
function vf(name){
    const r=rules[name];if(!r)return true;
    let v='';
    if(name==='category'||name==='status'){const c=document.querySelector('[name="'+name+'"]:checked');v=c?c.value:'';}
    else{const el=document.getElementById(name)||document.querySelector('[name="'+name+'"]');v=el?el.value.trim():'';}
    if(r.required&&!v){showErr(name,r.label+' é obrigatório.');return false;}
    if(r.min&&v.length<r.min){showErr(name,'Mínimo de '+r.min+' caracteres.');return false;}
    if(r.max&&v.length>r.max){showErr(name,'Máximo de '+r.max+' caracteres.');return false;}
    if(name==='startDate'&&v&&isNaN(new Date(v).getTime())){showErr(name,'Data inválida.');return false;}
    showErr(name,'');return true;
}
Object.keys(rules).forEach(n=>{
    document.querySelectorAll('[name="'+n+'"]').forEach(el=>{
        el.addEventListener('blur',()=>vf(n));el.addEventListener('change',()=>vf(n));
    });
});
document.getElementById('pForm').addEventListener('submit',function(e){
    let ok=true;
    Object.keys(rules).forEach(n=>{if(!vf(n))ok=false;});
    if(fi.files.length){const f=fi.files[0];if(!['image/jpeg','image/png','image/webp'].includes(f.type)||f.size>5*1024*1024){fi.closest('.field')?.classList.add('has-error');ok=false;}}
    if(!ok){e.preventDefault();document.querySelector('.has-error')?.scrollIntoView({behavior:'smooth',block:'center'});return;}
    document.getElementById('subBtn').classList.add('ld');
});

/* ── Step indicator ── */
const SE=document.querySelectorAll('.step'),LE=document.querySelectorAll('.sline');
function actStep(i){SE.forEach((s,j)=>s.className='step '+(j<i?'dn':j===i?'act':'off'));LE.forEach((l,j)=>l.className='sline'+(j<i?' dn':''));}
document.querySelectorAll('.card').forEach((c,i)=>c.addEventListener('focusin',()=>actStep(i)));
})();
</script>
</body>
</html>
