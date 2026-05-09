<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoMapa Brasil</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      color: #1a3a2a;
      background: linear-gradient(145deg, #eaf7e6 0%, #c8e6d9 100%);
      min-height: 100vh;
    }

    /* ── HEADER ── */
    header {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(10px);
      box-shadow: 0 1px 12px rgba(0,50,20,0.08);
      position: sticky;
      top: 0;
      z-index: 50;
    }

    nav {
      max-width: 1280px;
      margin: 0 auto;
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.25rem;
      font-weight: 700;
      color: #1a4d2c;
      text-decoration: none;
    }

    .brand-icon {
      font-size: 1.6rem;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a {
      text-decoration: none;
      color: #2d6a4a;
      font-size: 0.95rem;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: #1a4d2c;
    }

    .nav-buttons {
      display: flex;
      gap: 0.75rem;
      align-items: center;
    }

    .btn-outline {
      background: transparent;
      color: #1a4d2c;
      border: 2px solid #1a4d2c;
      padding: 0.5rem 1.3rem;
      border-radius: 9999px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .btn-outline:hover {
      background: #1a4d2c;
      color: #fff;
    }

    .btn-primary {
      background: linear-gradient(95deg, #238b45 0%, #1a6e3b 100%);
      color: #fff;
      border: none;
      padding: 0.55rem 1.4rem;
      border-radius: 9999px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      box-shadow: 0 4px 12px rgba(35,139,69,0.3);
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(95deg, #1e713b 0%, #145a30 100%);
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(35,139,69,0.4);
    }

    /* ── HERO ── */
    .hero {
      position: relative;
      height: 600px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .hero img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 8s ease;
    }

    .hero:hover img {
      transform: scale(1.03);
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(10,40,20,0.55), rgba(10,40,20,0.7));
    }

    .hero-content {
      position: relative;
      z-index: 10;
      text-align: center;
      color: #fff;
      max-width: 860px;
      padding: 0 1.5rem;
    }

    .hero-content h1 {
      font-size: clamp(2.2rem, 5vw, 3.5rem);
      font-weight: 700;
      line-height: 1.15;
      margin-bottom: 1.2rem;
      text-shadow: 0 2px 12px rgba(0,0,0,0.3);
    }

    .hero-content p {
      font-size: 1.15rem;
      color: #d1fae5;
      margin-bottom: 2rem;
    }

    .hero-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-hero-primary {
      background: linear-gradient(95deg, #238b45 0%, #1a6e3b 100%);
      color: #fff;
      border: none;
      padding: 0.85rem 2rem;
      border-radius: 9999px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      box-shadow: 0 4px 16px rgba(35,139,69,0.4);
      transition: all 0.35s ease;
    }

    .btn-hero-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(35,139,69,0.5);
    }

    .btn-hero-secondary {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(8px);
      color: #fff;
      border: 2px solid rgba(255,255,255,0.6);
      padding: 0.85rem 2rem;
      border-radius: 9999px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.35s ease;
    }

    .btn-hero-secondary:hover {
      background: rgba(255,255,255,0.25);
      border-color: #fff;
      transform: translateY(-2px);
    }

    /* ── IMPACT STATS ── */
    .stats {
      padding: 4.5rem 2rem;
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(6px);
    }

    .stats-grid {
      max-width: 1280px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2rem;
    }

    .stat-item {
      text-align: center;
      background: #fff;
      border-radius: 1.5rem;
      padding: 2rem 1rem;
      box-shadow: 0 4px 20px rgba(0,50,20,0.08);
      transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .stat-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(0,50,20,0.14);
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      color: #238b45;
      margin: 0 auto 1rem;
    }

    .stat-number {
      font-size: 2.2rem;
      font-weight: 700;
      color: #1a4d2c;
      margin-bottom: 0.25rem;
    }

    .stat-label {
      color: #4b6b53;
      font-size: 0.9rem;
      font-weight: 500;
    }

    /* ── ABOUT ── */
    .about {
      padding: 5rem 2rem;
    }

    .about-inner {
      max-width: 1280px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3.5rem;
      align-items: center;
    }

    .about-text-card {
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(8px);
      border-radius: 2rem;
      padding: 2.5rem;
      box-shadow: 0 8px 30px rgba(0,50,20,0.1);
    }

    .about h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #1a4d2c;
      margin-bottom: 1.2rem;
    }

    .about p {
      font-size: 1rem;
      color: #3f5c49;
      line-height: 1.75;
      margin-bottom: 1.2rem;
    }

    .about-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-top: 0.5rem;
    }

    .about-list-item {
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .dot-outer {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: #d1fae5;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .dot-inner {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #238b45;
    }

    .about-list-title {
      font-weight: 600;
      color: #1a4d2c;
      margin-bottom: 0.2rem;
    }

    .about-list-desc {
      font-size: 0.88rem;
      color: #4b6b53;
    }

    .about-image {
      height: 500px;
      border-radius: 2rem;
      overflow: hidden;
      box-shadow: 0 25px 50px rgba(0,50,20,0.2);
      transition: transform 0.4s ease;
    }

    .about-image:hover {
      transform: scale(1.01);
    }

    .about-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* ── PROJETOS ── */
    .projetos {
      padding: 5rem 2rem;
      background: rgba(255,255,255,0.4);
      backdrop-filter: blur(6px);
    }

    .section-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .section-header h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #1a4d2c;
      margin-bottom: 0.75rem;
    }

    .section-header p {
      font-size: 1rem;
      color: #4b6b53;
    }

    .projetos-grid {
      max-width: 1280px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
    }

    .projeto-card {
      background: #fff;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,50,20,0.08);
      transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .projeto-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 40px rgba(0,50,20,0.16);
    }

    .projeto-card-img {
      height: 192px;
      overflow: hidden;
    }

    .projeto-card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.45s ease;
    }

    .projeto-card:hover .projeto-card-img img {
      transform: scale(1.08);
    }

    .projeto-card-body {
      padding: 1.5rem;
    }

    .projeto-card-body h3 {
      font-size: 1.05rem;
      font-weight: 600;
      color: #1a4d2c;
      margin-bottom: 0.5rem;
    }

    .projeto-card-body p {
      font-size: 0.88rem;
      color: #4b6b53;
      margin-bottom: 1rem;
      line-height: 1.6;
    }

    .progress-label {
      display: flex;
      justify-content: space-between;
      font-size: 0.82rem;
      margin-bottom: 0.4rem;
      color: #3f5c49;
    }

    .progress-label span:last-child {
      color: #238b45;
      font-weight: 600;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background: #d1fae5;
      border-radius: 9999px;
      margin-bottom: 1.2rem;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #238b45, #3faa5e);
      border-radius: 9999px;
      transition: width 1s ease;
    }

    .btn-saiba {
      background: none;
      border: none;
      color: #238b45;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0;
      transition: color 0.3s ease, gap 0.3s ease;
    }

    .btn-saiba:hover {
      color: #1a4d2c;
      gap: 0.65rem;
    }

    .projeto-placeholder {
      max-width: 1280px;
      margin: 2rem auto 0;
      background: rgba(255,255,255,0.6);
      border: 2px dashed #a8d5b5;
      border-radius: 1.5rem;
      padding: 2.5rem;
      text-align: center;
      color: #4b6b53;
    }

    .projeto-placeholder p {
      font-size: 0.95rem;
      font-style: italic;
    }

    /* ── CTA ── */
    .cta {
      background: linear-gradient(135deg, #1a4d2c 0%, #238b45 100%);
      padding: 5rem 2rem;
      text-align: center;
    }

    .cta h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1rem;
    }

    .cta p {
      font-size: 1.05rem;
      color: #d1fae5;
      margin-bottom: 2rem;
    }

    .cta-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-cta-white {
      background: #fff;
      color: #1a4d2c;
      border: none;
      padding: 0.85rem 2rem;
      border-radius: 9999px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.35s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-cta-white:hover {
      background: #d1fae5;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn-cta-outline {
      background: transparent;
      color: #fff;
      border: 2px solid rgba(255,255,255,0.7);
      padding: 0.85rem 2rem;
      border-radius: 9999px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.35s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-cta-outline:hover {
      background: rgba(255,255,255,0.15);
      border-color: #fff;
      transform: translateY(-2px);
    }

    /* ── FOOTER ── */
    footer {
      background: #0f2d1a;
      color: #fff;
      padding: 3.5rem 2rem 2rem;
    }

    .footer-grid {
      max-width: 1280px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2rem;
    }

    .footer-brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 1rem;
      font-weight: 700;
      font-size: 1.1rem;
      color: #d1fae5;
    }

    .footer-desc {
      color: #6b9e7a;
      font-size: 0.88rem;
      line-height: 1.65;
    }

    .footer-col h3 {
      font-size: 0.95rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #d1fae5;
    }

    .footer-col ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.55rem;
    }

    .footer-col ul a {
      color: #6b9e7a;
      text-decoration: none;
      font-size: 0.88rem;
      transition: color 0.3s ease;
    }

    .footer-col ul a:hover { color: #d1fae5; }

    .footer-contact li {
      color: #6b9e7a;
      font-size: 0.88rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .footer-contact svg {
      width: 15px;
      height: 15px;
      flex-shrink: 0;
    }

    .footer-bottom {
      max-width: 1280px;
      margin: 2rem auto 0;
      padding-top: 1.5rem;
      border-top: 1px solid #1f3d28;
      text-align: center;
      color: #4b6b53;
      font-size: 0.82rem;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .projetos-grid { grid-template-columns: repeat(2, 1fr); }
      .footer-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
      .nav-links { display: none; }
      .about-inner { grid-template-columns: 1fr; }
      .about-image { height: 280px; }
      .projetos-grid { grid-template-columns: 1fr; }
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .footer-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 480px) {
      .footer-grid { grid-template-columns: 1fr; }
      .hero-content h1 { font-size: 2rem; }
      .nav-buttons .btn-outline { display: none; }
    }
  </style>
</head>
<body>

<!-- HEADER -->
<header>
  <nav>
    <a href="#" class="brand">
      <span class="brand-icon">🌱</span>
      EcoMapa Brasil
    </a>
    <ul class="nav-links">
      <li><a href="#sobre">Sobre</a></li>
      <li><a href="#projetos">Projetos</a></li>
      <li><a href="#impacto">Impacto</a></li>
      <li><a href="#contato">Contato</a></li>
    </ul>
    <div class="nav-buttons">
      <a href="/models/login.php" class="btn-outline">Login</a>
      <a href="/models/cad_usuarios.php" class="btn-primary">Cadastre-se</a>
    </div>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
  <img src="https://images.unsplash.com/photo-1593113616828-6f22bca04804?w=1080&q=80" alt="Voluntários ajudando a comunidade">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Transformando Vidas, Construindo Futuros</h1>
    <p>Juntos, podemos fazer a diferença na vida de milhares de pessoas</p>
    <div class="hero-buttons">
      <a href="/models/cad_usuarios.php" class="btn-hero-primary">
        Cadastre-se Agora
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
      <a href="#projetos" class="btn-hero-secondary">Conheça Nossos Projetos</a>
    </div>
  </div>
</section>

<!-- IMPACT STATS -->
<section class="stats" id="impacto">
  <div class="stats-grid">
    <div class="stat-item">
      <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      <div class="stat-number">12.500+</div>
      <div class="stat-label">Vidas Impactadas</div>
    </div>
    <div class="stat-item">
      <svg class="stat-icon" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
      </svg>
      <div class="stat-number">850+</div>
      <div class="stat-label">Voluntários Ativos</div>
    </div>
    <div class="stat-item">
      <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
      </svg>
      <div class="stat-number">45</div>
      <div class="stat-label">Comunidades Atendidas</div>
    </div>
    <div class="stat-item">
      <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
      </svg>
      <div class="stat-number">320+</div>
      <div class="stat-label">Projetos Realizados</div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="sobre">
  <div class="about-inner">
    <div class="about-text-card">
      <h2>Nossa Missão</h2>
      <p>O EcoMapa Brasil é uma plataforma dedicada a conectar organizações ecológicas e voluntários, promovendo ações concretas em preservação ambiental e desenvolvimento sustentável.</p>
      <p>Acreditamos que cada pessoa merece um planeta mais limpo e saudável. Trabalhamos para criar pontes entre quem quer ajudar e quem precisa de apoio.</p>
      <div class="about-list">
        <div class="about-list-item">
          <div class="dot-outer"><div class="dot-inner"></div></div>
          <div>
            <div class="about-list-title">Preservação Ambiental</div>
            <div class="about-list-desc">Projetos de reflorestamento e limpeza de ecossistemas</div>
          </div>
        </div>
        <div class="about-list-item">
          <div class="dot-outer"><div class="dot-inner"></div></div>
          <div>
            <div class="about-list-title">Educação Ecológica</div>
            <div class="about-list-desc">Programas de conscientização ambiental para comunidades</div>
          </div>
        </div>
        <div class="about-list-item">
          <div class="dot-outer"><div class="dot-inner"></div></div>
          <div>
            <div class="about-list-title">Desenvolvimento Sustentável</div>
            <div class="about-list-desc">Capacitação e geração de renda com foco no meio ambiente</div>
          </div>
        </div>
      </div>
    </div>
    <div class="about-image">
      <img src="https://images.unsplash.com/photo-1560220604-1985ebfe28b1?w=1080&q=80" alt="Equipe de voluntários">
    </div>
  </div>
</section>

<!-- PROJETOS -->
<section class="projetos" id="projetos">
  <div class="section-header">
    <h2>Nossos Projetos</h2>
    <p>Conheça as iniciativas que estão transformando comunidades</p>
  </div>
  <div class="projetos-grid">

    <div class="projeto-card">
      <div class="projeto-card-img">
        <img src="https://images.unsplash.com/photo-1758599668547-2b1192c10abb?w=1080&q=80" alt="Limpeza ambiental">
      </div>
      <div class="projeto-card-body">
        <h3>Meio Ambiente Limpo</h3>
        <p>Mutirões de limpeza e preservação ambiental em comunidades carentes.</p>
        <div class="progress-label">
          <span>Progresso</span><span>75%</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:75%"></div>
        </div>
        <button class="btn-saiba">
          Saiba Mais
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </div>
    </div>

    <div class="projeto-card">
      <div class="projeto-card-img">
        <img src="https://images.unsplash.com/photo-1758599668209-783bd3691ec8?w=1080&q=80" alt="Educação para jovens">
      </div>
      <div class="projeto-card-body">
        <h3>Educação para Todos</h3>
        <p>Aulas de reforço e capacitação profissional para jovens e adultos.</p>
        <div class="progress-label">
          <span>Progresso</span><span>90%</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:90%"></div>
        </div>
        <button class="btn-saiba">
          Saiba Mais
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </div>
    </div>

    <div class="projeto-card">
      <div class="projeto-card-img">
        <img src="https://images.unsplash.com/photo-1758599668429-121d54188b9c?w=1080&q=80" alt="Ação comunitária">
      </div>
      <div class="projeto-card-body">
        <h3>Assistência Social</h3>
        <p>Distribuição de alimentos e itens básicos para famílias necessitadas.</p>
        <div class="progress-label">
          <span>Progresso</span><span>62%</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:62%"></div>
        </div>
        <button class="btn-saiba">
          Saiba Mais
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </div>
    </div>

  </div>

  <!-- Placeholder para SELECT futuro do banco -->
  <div class="projeto-placeholder">
    <p>🔄 Em breve: projetos carregados dinamicamente do banco de dados com ONGs reais cadastradas.</p>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <h2>Faça Parte Dessa Transformação</h2>
  <p>Crie sua conta e conecte-se a projetos ecológicos que estão mudando o Brasil.</p>
  <div class="cta-buttons">
    <a href="/models/cad_usuarios.php" class="btn-cta-white">Criar Conta Grátis</a>
    <a href="/models/login.php" class="btn-cta-outline">Já tenho uma conta</a>
  </div>
</section>

<!-- FOOTER -->
<footer id="contato">
  <div class="footer-grid">
    <div>
      <div class="footer-brand">🌱 EcoMapa Brasil</div>
      <p class="footer-desc">Conectando pessoas e organizações para um Brasil mais verde e sustentável.</p>
    </div>
    <div class="footer-col">
      <h3>Links Rápidos</h3>
      <ul>
        <li><a href="#sobre">Sobre Nós</a></li>
        <li><a href="#projetos">Nossos Projetos</a></li>
        <li><a href="#impacto">Nosso Impacto</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h3>Acesso</h3>
      <ul>
        <li><a href="/models/login.php">Login</a></li>
        <li><a href="/models/cad_usuarios.php">Cadastre-se</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h3>Contato</h3>
      <ul class="footer-contact">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          contato@ecomapa.com.br
        </li>
        <li>São Paulo - SP</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2026 EcoMapa Brasil. Todos os direitos reservados.</p>
  </div>
</footer>

</body>
</html>
