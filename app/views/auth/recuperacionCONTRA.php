<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Recuperación de Acceso | SIGO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --primary-navy: #1a2a6c;
        --electric-blue: #00d2ff;
        --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    .recovery-card {
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 40px 80px rgba(26, 42, 108, 0.15);
        width: 100%;
        max-width: 450px;
        padding: 50px 40px;
        text-align: center;
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background: #fff5f5;
        color: #ff4757;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 25px;
        font-size: 2rem;
        border: 2px dashed #ff4757;
    }

    .phone-badge {
        background: var(--primary-navy);
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        display: inline-block;
        margin-top: 20px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 10px 20px rgba(26, 42, 108, 0.2);
    }

    .btn-back {
        margin-top: 30px;
        color: var(--primary-navy);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: var(--electric-blue);
        transform: translateX(-5px);
    }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="recovery-card">
            <div class="icon-box">
                <i class="fas fa-user-shield"></i>
            </div>

            <h2 class="fw-bold mb-3" style="color: var(--primary-navy);">¿Olvidaste tu contraseña?</h2>

            <p class="text-muted mb-4">
                Por seguridad de la clínica, la restauración de accesos se realiza de manera presencial o vía telefónica
                con el personal autorizado.
            </p>

            <div class="alert alert-light border-0 py-3" style="background: #f8f9fa; border-radius: 15px;">
                <p class="mb-1 fw-bold">Favor de comunicarse a:</p>
                <h5 class="fw-normal">Coordinación de Sistemas</h5>
                <div class="phone-badge">
                    <i class="fas fa-phone-alt me-2"></i> EXT. 168
                </div>
            </div>

            <a href="index.php?c=auth&a=form" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
            </a>

            <div class="mt-5 pt-3 border-top">
                <small class="text-muted">UHipocrates | Soporte Técnico</small>
            </div>
        </div>
    </div>

</body>

</html>