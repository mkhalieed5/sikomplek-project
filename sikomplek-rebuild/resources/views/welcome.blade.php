<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sikomplek — Kelola Komplek Lebih Mudah</title>
    
    <style>
        :root { 
            --ink: #102a43; 
            --muted: #64748b; 
            --blue: #1769e0; 
            --teal: #19b394; 
            --cream: #f7fbff; 
            --line: #e5edf5; 
        }
        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            color: var(--ink); 
            background: #fff; 
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif; 
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 40px)); margin: auto; }
        
        /* HEADER / NAVBAR */
        header { padding: 22px 0; border-bottom: 1px solid rgba(229,237,245,.7); background: #fff; }
        .nav { display: flex; align-items: center; justify-content: space-between; gap: 24px; }
        .brand { display: flex; align-items: center; gap: 11px; font-size: 20px; font-weight: 800; letter-spacing: -.5px; }
        .brand-mark { display: grid; place-items: center; width: 38px; height: 38px; border-radius: 12px; color: #fff; font-size: 20px; background: linear-gradient(135deg,var(--blue),#55a5ff); box-shadow: 0 8px 18px rgba(23,105,224,.25); }
        .links { display: flex; align-items: center; gap: 28px; color: var(--muted); font-size: 14px; font-weight: 600; }
        .links a:hover { color: var(--blue); }
        .nav-actions { display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 700; }
        .login { color: var(--blue); padding: 11px 12px; }
        .button { display: inline-flex; align-items: center; justify-content: center; gap: 9px; padding: 13px 19px; border-radius: 10px; color: #fff; background: var(--blue); box-shadow: 0 10px 22px rgba(23,105,224,.2); transition: transform .2s, box-shadow .2s; }
        .button:hover { transform: translateY(-2px); box-shadow: 0 14px 26px rgba(23,105,224,.28); }
        .button-light { color: var(--blue); background: #edf5ff; box-shadow: none; }
        
        /* HERO SECTION */
        .hero { position: relative; overflow: hidden; padding: 78px 0 92px; background: linear-gradient(180deg,#f8fbff 0%,#fff 100%); }
        .hero:before { content: ""; position: absolute; width: 480px; height: 480px; right: -170px; top: -190px; border-radius: 50%; background: #e4f7f3; opacity: .75; }
        .hero-grid { position: relative; display: grid; grid-template-columns: 1.05fr .95fr; align-items: center; gap: 72px; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; padding: 7px 11px; border: 1px solid #ccefe7; border-radius: 99px; color: #168d79; background: #effcf9; font-size: 12px; font-weight: 800; letter-spacing: .4px; text-transform: uppercase; }
        .eyebrow span { width: 7px; height: 7px; border-radius: 50%; background: var(--teal); }
        h1 { max-width: 650px; margin: 20px 0 18px; font-size: clamp(42px, 5.4vw, 67px); line-height: 1.02; letter-spacing: -3.5px; }
        h1 em { color: var(--blue); font-style: normal; }
        .hero-copy { max-width: 520px; color: var(--muted); font-size: 18px; line-height: 1.7; }
        .hero-buttons { display: flex; flex-wrap: wrap; gap: 13px; margin-top: 31px; }
        .subnote { display: flex; align-items: center; gap: 9px; margin-top: 21px; color: #8090a2; font-size: 12px; }
        .subnote b { color: var(--teal); font-size: 17px; }
        
        /* MOCKUP DASHBOARD */
        .dashboard { position: relative; padding: 14px; border: 1px solid #dce9f5; border-radius: 21px; background: #fff; box-shadow: 0 25px 60px rgba(16,42,67,.12); transform: rotate(1.5deg); }
        .dash-top { display: flex; align-items: center; justify-content: space-between; padding: 9px 10px 17px; }
        .dash-title { font-size: 13px; font-weight: 800; }
        .dash-menu { color: #94a3b8; font-size: 18px; letter-spacing: 2px; }
        .dash-welcome { padding: 23px; border-radius: 14px; color: #fff; background: linear-gradient(120deg,#135ed1,#2f86ed); }
        .dash-welcome small { opacity: .75; font-size: 11px; }
        .dash-welcome strong { display: block; margin-top: 7px; font-size: 22px; }
        .dash-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-top: 12px; }
        .stat { padding: 15px 12px; border: 1px solid var(--line); border-radius: 12px; background: #fbfdff; }
        .stat-icon { font-size: 17px; }
        .stat small { display: block; margin-top: 9px; color: var(--muted); font-size: 10px; }
        .stat strong { display: block; margin-top: 3px; font-size: 18px; }
        .dash-bottom { display: flex; align-items: center; gap: 10px; margin: 14px 4px 1px; padding-top: 13px; border-top: 1px solid var(--line); color: var(--muted); font-size: 11px; }
        .pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--teal); box-shadow: 0 0 0 5px #e5faf5; }

        @media (max-width: 800px) { 
            .links { display: none; } 
            .hero-grid { grid-template-columns: 1fr; gap: 48px; } 
            .dashboard { transform: none; } 
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header>
        <div class="wrap nav">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark">⌂</span>Sikomplek
            </a>
            <nav class="links">
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara kerja</a>
                <a href="#tentang">Tentang</a>
            </nav>
            <div class="nav-actions">
                <a class="login" href="{{ url('/login') }}">Masuk</a>
                <a class="button" href="{{ url('/login') }}">Mulai sekarang <span>→</span></a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <main>
        <section class="hero">
            <div class="wrap hero-grid">
                <div>
                    <div class="eyebrow"><span></span> Platform komunitas digital</div>
                    <h1>Komplek rapi,<br><em>warga happy.</em></h1>
                    <p class="hero-copy">Satu ruang untuk mengelola data warga, iuran, dan komunikasi RT/RW. Lebih transparan untuk pengurus, lebih mudah untuk semua.</p>
                    <div class="hero-buttons">
                        <a class="button" href="{{ url('/login') }}">Jelajahi fitur <span>↗</span></a>
                        <a class="button button-light" href="#cara-kerja">Lihat cara kerja</a>
                    </div>
                    <div class="subnote"><b>✓</b> Aman, terorganisir, dan dibuat untuk Indonesia</div>
                </div>

                <!-- PRATINJAU DASHBOARD -->
                <div class="dashboard">
                    <div class="dash-top">
                        <span class="dash-title">Ringkasan komplek</span>
                        <span class="dash-menu">•••</span>
                    </div>
                    <div class="dash-welcome">
                        <small>Selamat pagi, Pengurus 👋</small>
                        <strong>Griya Indah</strong>
                    </div>
                    <div class="dash-stats">
                        <div class="stat">
                            <span class="stat-icon">⌂</span>
                            <small>Total KK</small>
                            <strong>248</strong>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">◈</span>
                            <small>Warga aktif</small>
                            <strong>731</strong>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">✓</span>
                            <small>Iuran lunas</small>
                            <strong>87%</strong>
                        </div>
                    </div>
                    <div class="dash-bottom">
                        <span class="pulse"></span> Semua data tersinkronisasi hari ini
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>