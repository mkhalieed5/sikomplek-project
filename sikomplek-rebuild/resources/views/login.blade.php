<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Sikomplek</title>
    
    <style>
        :root { 
            --ink: #102a43; 
            --muted: #64748b; 
            --blue: #1769e0; 
            --cream: #f7fbff; 
            --line: #e5edf5; 
        }
        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            color: var(--ink); 
            background: #f8fbff; 
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        a { color: var(--blue); text-decoration: none; font-weight: 600; }
        a:hover { text-decoration: underline; }
        
        .auth-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(16,42,67,.06);
        }
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 24px;
            color: var(--ink);
        }
        .brand-mark {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            color: #fff;
            font-size: 20px;
            background: linear-gradient(135deg,var(--blue),#55a5ff);
            box-shadow: 0 8px 18px rgba(23,105,224,.25);
        }
        .auth-title { text-align: center; margin-bottom: 28px; }
        .auth-title h2 { margin: 0 0 8px; font-size: 24px; letter-spacing: -.5px; }
        .auth-title p { margin: 0; color: var(--muted); font-size: 14px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--ink); }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
            background: #fbfdff;
        }
        .form-input:focus { border-color: var(--blue); background: #fff; }
        
        .button {
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            color: #fff;
            background: var(--blue);
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(23,105,224,.2);
            transition: transform .2s, box-shadow .2s;
            margin-top: 8px;
        }
        .button:hover { transform: translateY(-2px); box-shadow: 0 14px 26px rgba(23,105,224,.28); }
        
        .auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: var(--muted); }
    </style>
</head>
<body>

    <div class="auth-card">
        <a class="brand" href="{{ url('/') }}">
            <span class="brand-mark">⌂</span>Sikomplek
        </a>
        
        <div class="auth-title">
            <h2>Selamat Datang</h2>
            <p>Masukkan akun pengurus atau warga Anda</p>
        </div>

        <form method="POST" action="{{ url('/home') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email / NIK</label>
                <input type="text" id="email" name="email" class="form-input" placeholder="contoh: admin@sikomplek.id" required autofocus>
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label for="password" style="margin: 0;">Kata Sandi</label>
                    <a href="#" style="font-size: 12px;">Lupa sandi?</a>
                </div>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="button">Masuk ke Sistem <span>→</span></button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar Warga Baru</a>
        </div>
    </div>

</body>
</html>