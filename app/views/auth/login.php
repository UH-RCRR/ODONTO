<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>UHipocrates | Odontologia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    :root {
        --primary-navy: #1a2a6c;
        --electric-blue: #00d2ff;
        --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --input-focus: #e3f2fd;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    body {
        background: var(--bg-gradient);
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
    }

    .login-card {
        background: #ffffff;
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 40px 80px rgba(26, 42, 108, 0.15);
        width: 100%;
        max-width: 440px;
        padding: 50px 40px;
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .brand-section {
        text-align: center;
        margin-bottom: 35px;
    }

    .logo-box {
        width: 70px;
        height: 70px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        margin: 0 auto 15px;
        font-size: 1.8rem;
        box-shadow: 0 15px 30px rgba(26, 42, 108, 0.3);
        background: linear-gradient(45deg, var(--primary-navy), #b21f1f);
    }

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
        height: 60px;
        border-radius: 16px;
        border: 2px solid #f0f0f0;
        background: #fcfcfc;
        padding: 0 20px 0 50px;
        font-size: 1rem;
        transition: all 0.3s;
        color: #1a2a6c;
        width: 100%;
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
        z-index: 5;
    }

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
    }

    /* Estilo del Alert que ya tenías (se mantiene como refuerzo) */
    .alert-custom {
        background: #fff5f5;
        border-left: 4px solid #ff4757;
        color: #ff4757;
        border-radius: 12px;
        font-size: 0.9rem;
        padding: 15px;
        margin-bottom: 25px;
        animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
    }

    @keyframes shake {

        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }

        20%,
        80% {
            transform: translate3d(2px, 0, 0);
        }

        30%,
        50%,
        70% {
            transform: translate3d(-4px, 0, 0);
        }

        40%,
        60% {
            transform: translate3d(4px, 0, 0);
        }
    }

    .footer-text {
        text-align: center;
        margin-top: 30px;
        font-size: 0.8rem;
        color: #95a5a6;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 35px 25px;
        }

        .form-control-premium,
        .btn-premium {
            height: 55px;
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
                <h2 class="fw-bold" style="color: var(--primary-navy); letter-spacing: -1px;">SIGO</h2>
                <p class="text-muted small">Sistema Integral de Gestión Odontológica</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
            <div class="alert-custom d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3"></i>
                <div>Credenciales incorrectas. Intente de nuevo.</div>
            </div>
            <?php endif; ?>

            <form method="POST" action="index.php?c=auth&a=login" id="loginForm">

                <div class="custom-input-group">
                    <label class="form-label">USUARIO PROFESIONAL</label>
                    <i class="fas fa-user-md input-icon"></i>
                    <input type="email" name="correo" class="form-control-premium" placeholder="doctor@elitedental.com"
                        required>
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
                    <a href="index.php?c=auth&a=recuperar" class="text-decoration-none small fw-bold"
                        style="color: var(--electric-blue);">
                        ¿Olvidó su contraseña?
                    </a>
                </div>
            </form>

            <div class="footer-text">
                &copy; Autor: Ing. Jared Marcelino Zamudio Vielma. <br>
                <i class="fas fa-circle-check text-success me-1"></i> Servidor UHipocrates Seguro Activo
            </div>
        </div>
    </div>

    <script>
    // 1. Efecto de carga al presionar el botón
    document.getElementById('loginForm').onsubmit = function() {
        const btn = this.querySelector('.btn-premium');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> VALIDANDO...';
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.8';
    };

    // 2. DISPARAR ALERT MODERNO SI HAY ERROR
    <?php if (isset($_GET['error'])): ?>
    Swal.fire({
        icon: 'error',
        title: '¡Acceso Denegado!',
        text: 'El correo electrónico o la contraseña no coinciden con nuestros registros.',
        confirmButtonColor: '#1a2a6c',
        confirmButtonText: 'Entendido',
        background: '#ffffff',
        customClass: {
            popup: 'rounded-5 shadow-lg border-0',
            title: 'fw-bold text-dark',
            confirmButton: 'rounded-4 px-5'
        },
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    });
    <?php endif; ?>
    </script>

</body>

</html>