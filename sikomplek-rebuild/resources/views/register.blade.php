<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Warga — Sikomplek</title>
    
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
            padding: 40px 20px;
        }
        a { color: var(--blue); text-decoration: none; font-weight: 600; }
        a:hover { text-decoration: underline; }
        
        .auth-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
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
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--ink); }
        .form-input, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
            background: #fbfdff;
        }
        .form-input:focus, .form-select:focus { border-color: var(--blue); background: #fff; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        
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
            margin-top: 10px;
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
            <h2>Pendaftaran Warga</h2>
            <p>Lengkapi data diri Anda untuk membuat akun</p>
        </div>

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="form-group">
                <label for="nik">NIK (Sesuai KTP)</label>
                <input type="text" id="nik" name="nik" class="form-input" placeholder="3201123456780001" required>
            </div>

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Nama sesuai KTP" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com" required>
                </div>
                <div class="form-group">
                    <label for="phone">No. WhatsApp</label>
                    <input type="text" id="phone" name="phone" class="form-input" placeholder="081234567890" required>
                </div>
            </div>

            

            <div class="form-group">
                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" class="form-select">
                    <option value="warga">Warga / Penghuni Komplek</option>
                    <option value="admin">Pengurus RT / RW (Admin)</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="button">Buat Akun Sekarang <span>→</span></button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
        </div>
    </div>

</body>
</html>