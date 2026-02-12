<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Elite Dental | Acceso Profesional</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-navy: #1a2a6c;
            --electric-blue: #00d2ff;
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --input-focus: #e3f2fd;
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        /* Contenedor Principal con efecto de profundidad */
        .login-card {
            background: #ffffff;
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 40px 80px rgba(26, 42, 108, 0.15);
            width: 100%;
            max-width: 440px;
            padding: 50px 40px;
            transition: all 0.4s ease;
        }

        /* Branding elegante */
        .brand-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-box {
            width: 70px;
            height: 70px;
            background: var(--primary-navy);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            box-shadow: 0 15px 30px rgba(26, 42, 108, 0.3);
            background: linear-gradient(45deg, var(--primary-navy), #b21f1f); /* Toque de elegancia */
        }

        /* Inputs Premium para Touch */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-navy);
            margin-left: 5px;
            opacity: 0.8;
        }

        .custom-input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control-premium {
            height: 60px; /* Tamaño ideal para dedos */
            border-radius: 16px;
            border: 2px solid #f0f0f0;
            background: #fcfcfc;
            padding: 0 20px 0 50px;
            font-size: 1rem;
            transition: all 0.3s;
            color: #1a2a6c;
        }

        .form-control-premium:focus {
            background: #fff;
            border-color: var(--electric-blue);
            box-shadow: 0 8px 20px rgba(0, 210, 255, 0.1);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            transition: 0.3s;
            z-index: 5;
        }

        .form-control-premium:focus + .input-icon {
            color: var(--electric-blue);
        }

        /* Botón Maestro */
        .btn-premium {
            background: var(--primary-navy);
            color: white;
            height: 60px;
            border-radius: 16px;
            border: none;
            width: 100%;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 1px;
            box-shadow: 0 10px 25px rgba(26, 42, 108, 0.2);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-premium:hover {
            background: #253b91;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(26, 42, 108, 0.3);
        }

        .btn-premium:active {
            transform: translateY(1px);
            scale: 0.98;
        }

        /* Alertas Minimalistas */
        .alert-custom {
            background: #fff5f5;
            border-left: 4px solid #ff4757;
            color: #ff4757;
            border-radius: 12px;
            font-size: 0.9rem;
            padding: 15px;
            margin-bottom: 25px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Footer */
        .footer-text {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: #95a5a6;
        }

        /* Media Queries para Tablets */
        @media (max-width: 768px) {
            .login-card {
                max-width: 380px;
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        
        <div class="brand-section">
            <div class="logo-box">
                <i class="fas fa-tooth"></i>
            </div>
            <h2 class="fw-bold" style="color: var(--primary-navy); letter-spacing: -1px;">UH DENTAL</h2>
            <p class="text-muted small">Sistema Integral de Gestión Odontológica</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert-custom d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3"></i>
                <div>Acceso denegado. Revise sus datos.</div>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?c=auth&a=login" id="loginForm">
            
            <div class="custom-input-group">
                <label class="form-label">USUARIO PROFESIONAL</label>
                <i class="fas fa-user-md input-icon"></i>
                <input type="email" name="correo" class="form-control-premium" placeholder="doctor@elitedental.com" required>
            </div>

            <div class="custom-input-group">
                <label class="form-label">CONTRASEÑA SEGURA</label>
                <i class="fas fa-shield-halved input-icon"></i>
                <input type="password" name="password" class="form-control-premium" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-premium mt-2">
                INGRESAR AL SISTEMA <i class="fas fa-chevron-right"></i>
            </button>

            <div class="text-center mt-4">
                <a href="#" class="text-decoration-none small fw-bold" style="color: var(--electric-blue);">
                    ¿Olvidó su contraseña?
                </a>
            </div>
        </form>

        <div class="footer-text">
            &copy; Autor: Jared Marcelino Zamudio Vielma. <br>
            <i class="fas fa-circle-check text-success me-1"></i> Servidor UHipocrates Seguro Activo
        </div>
    </div>
</div>

<script>
    // Pequeño efecto dinámico al enviar
    document.getElementById('loginForm').onsubmit = function() {
        const btn = this.querySelector('.btn-premium');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> VALIDANDO...';
        btn.style.opacity = '0.7';
    };
</script>

</body>
</html>