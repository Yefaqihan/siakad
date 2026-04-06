<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/custom.css" rel="stylesheet">
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
        }
        .login-page::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
            animation: floatBlob 8s ease-in-out infinite;
        }
        .login-page::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(14,165,233,0.1) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
            animation: floatBlob 10s ease-in-out infinite reverse;
        }
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -20px) scale(1.1); }
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,0.97);
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-logo {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 20px rgba(29,78,216,0.3);
        }
        .login-card h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            text-align: center;
            margin-bottom: 4px;
        }
        .login-card .subtitle {
            color: #64748b;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }
        .form-floating {
            margin-bottom: 16px;
        }
        .form-floating .form-control {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 16px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-floating .form-control:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
            color: white;
            transition: all 0.3s;
            margin-top: 8px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(29,78,216,0.35);
            color: white;
        }
        .demo-accounts {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .demo-accounts p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 10px;
            text-align: center;
        }
        .demo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 0.82rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .demo-item:hover {
            background: #eff6ff;
        }
        .demo-item .role-badge {
            font-weight: 600;
            color: #1d4ed8;
        }
        .demo-item .cred {
            color: #94a3b8;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1><?= APP_NAME ?></h1>
            <p class="subtitle"><?= APP_FULL_NAME ?></p>

            <?php if (hasFlash('error')): ?>
                <div class="alert alert-danger border-0 rounded-3 py-2 px-3 mb-3" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?= getFlash('error') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/index.php?page=login">
                <?= csrfField() ?>
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="email"
                           placeholder="name@example.com" value="<?= e($_POST['email'] ?? '') ?>" required>
                    <label for="email"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Password" required minlength="6">
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                </div>
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="demo-accounts">
                <p>Demo Akun (klik untuk isi otomatis)</p>
                <div class="demo-item" onclick="fillLogin('admin@sias.id')">
                    <span><i class="bi bi-shield-check me-2 text-primary"></i><span class="role-badge">Admin</span></span>
                    <span class="cred">admin@sias.id</span>
                </div>
                <div class="demo-item" onclick="fillLogin('guru1@sias.id')">
                    <span><i class="bi bi-person-workspace me-2 text-info"></i><span class="role-badge">Guru</span></span>
                    <span class="cred">guru1@sias.id</span>
                </div>
                <div class="demo-item" onclick="fillLogin('kepsek@sias.id')">
                    <span><i class="bi bi-person-badge me-2 text-dark"></i><span class="role-badge">Kepala Sekolah</span></span>
                    <span class="cred">kepsek@sias.id</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password123';
            document.getElementById('password').focus();
        }
    </script>
</body>
</html>