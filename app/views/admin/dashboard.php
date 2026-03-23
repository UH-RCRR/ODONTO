<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental UH | Master Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    :root {
        --primary-dark: #0f172a;
        --dental-blue: #0284c7;
        --dental-light: #e0f2fe;
        /* El azul bajo que pediste */
        --primary-gradient: linear-gradient(135deg, #0f172a 0%, #0284c7 100%);
        --glass: rgba(255, 255, 255, 0.8);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f1f5f9;
        min-height: 100vh;
        color: var(--primary-dark);
        margin: 0;
        display: flex;
    }

    /* --- CONTENEDOR PRINCIPAL --- */
    .main-content {
        margin-left: 280px;
        padding: 1.5rem;
        width: calc(100% - 280px);
    }

    .main-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* --- GRID RESPONSIVO --- */
    .bento-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .bento-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* --- TARJETAS (ESTADO NORMAL) --- */
    .bento-card {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid white;
        border-radius: 28px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }

    /* --- EFECTO HOVER PARA TODAS LAS TARJETAS --- */
    .bento-card:hover {
        transform: translateY(-8px);
        background-color: var(--dental-light) !important;
        border-color: var(--dental-blue) !important;
        box-shadow: 0 12px 30px rgba(2, 132, 199, 0.15);
    }

    /* Cambio de colores internos en Hover */
    .bento-card:hover h4,
    .bento-card:hover h3,
    .bento-card:hover h5,
    .bento-card:hover .big-stat,
    .bento-card:hover .material-symbols-rounded:not(.text-white) {
        color: var(--dental-blue) !important;
    }

    .bento-card:hover .text-muted {
        color: #0369a1 !important;
    }

    /* --- BOTONES DE ACCIÓN DENTRO DE TARJETAS --- */
    .btn-action {
        background: white;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 16px;
        padding: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        color: var(--primary-dark);
        margin-top: 8px;
        transition: 0.3s;
    }

    .bento-card:hover .btn-action {
        border-color: var(--dental-blue);
        color: var(--dental-blue);
    }

    .btn-action:hover {
        background: var(--dental-blue) !important;
        color: white !important;
    }

    /* --- EXCEPCIÓN: TARJETA OSCURA (DARK CARD) --- */
    /* Mantenemos que la oscura no se pinte azul para no perder el contraste */
    .dark-card:hover {
        background: var(--primary-gradient) !important;
        filter: brightness(1.1);
    }

    /* Auxiliares de Grid */
    @media (min-width: 768px) {
        .span-2 {
            grid-column: span 2;
        }

        .row-2 {
            grid-row: span 2;
        }
    }

    .big-stat {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        transition: 0.3s;
    }

    /* --- TARJETA DE PENDIENTES SIEMPRE REMARCADA --- */
    .card-pendientes {
        border: 2px solid var(--dental-blue) !important;
        background: white;
        box-shadow: 0 10px 20px rgba(2, 132, 199, 0.1) !important;
    }

    /* --- ESTADO CUANDO LLEGA NOTIFICACIÓN (CAMBIO DE COLOR) --- */
    .card-pendientes.has-notification {
        background: #fff1f2 !important;
        /* Un rojo/rosa muy suave */
        border-color: #f43f5e !important;
        /* Bordes color rosa fuerte/rojo */
        animation: pulse-red 2s infinite;
    }

    .card-pendientes.has-notification .material-symbols-rounded,
    .card-pendientes.has-notification .big-stat {
        color: #e11d48 !important;
        /* Texto en rojo para alertar */
    }

    /* Animación de pulso para llamar la atención */
    @keyframes pulse-red {
        0% {
            box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4);
        }

        70% {
            box-shadow: 0 0 0 15px rgba(244, 63, 94, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(244, 63, 94, 0);
        }
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="main-wrapper">

            <header class="d-flex justify-content-between align-items-center mb-4 px-2">
                <div>
                    <h4 class="fw-800 mb-0">Panel de Control</h4>
                    <p class="text-muted small mb-0">Bienvenido al sistema SIGO UH</p>
                </div>
                <div class="text-muted small fw-bold"><?= date('d M, Y') ?></div>
            </header>

            <div class="bento-grid">
                <div class="bento-card">
                    <span class="material-symbols-rounded text-primary">group</span>
                    <div class="big-stat mt-2"><?= $data['usuarios'] ?></div>
                    <div class="fw-bold text-muted small uppercase">Usuarios</div>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-success">school</span>
                    <div class="big-stat mt-2"><?= $data['alumnos'] ?></div>
                    <div class="fw-bold text-muted small">Alumnos</div>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-info">medical_services</span>
                    <div class="big-stat mt-2"><?= $data['docentes'] ?></div>
                    <div class="fw-bold text-muted small">Docentes</div>
                </div>
                <?php $tieneNotificaciones = ($data['pendientes'] > 0) ? 'has-notification' : ''; ?>

                <div class="bento-card card-pendientes <?= $tieneNotificaciones ?>">
                    <span class="material-symbols-rounded">notifications_active</span>
                    <div class="big-stat mt-2"><?= $data['pendientes'] ?></div>
                    <div class="fw-bold text-muted small">Solicitudes Pendientes</div>

                    <?php if ($data['pendientes'] > 0): ?>
                    <span class="badge rounded-pill bg-danger mt-2" style="font-size: 0.6rem;">Atención requerida</span>
                    <?php endif; ?>
                </div>

                <div class="bento-card span-2 row-2">
                    <h3 class="fw-800">Gestión de Usuarios</h3>
                    <p class="text-muted">Administración central de cuentas, permisos y seguridad de la plataforma.</p>
                    <div class="bg-light p-3 rounded-4 mb-4 border d-flex align-items-center gap-2">
                        <span class="material-symbols-rounded text-success">shield_check</span>
                        <span class="small fw-bold">Base de datos optimizada y segura</span>
                    </div>
                    <a href="index.php?c=usuarios" class="btn btn-dark py-3 rounded-4 fw-bold">Abrir Administrador</a>
                </div>

                <div class="bento-card row-2">
                    <span class="material-symbols-rounded fs-1 text-primary">hub</span>
                    <h4 class="fw-800 mt-2">Asignaciones</h4>
                    <p class="text-muted small">Vinculación académica entre docentes y alumnos.</p>

                    <a href="index.php?c=asignaciones&a=grupal" class="btn-action">
                        <span class="material-symbols-rounded" style="font-size: 1.2rem;">groups</span> Grupal
                    </a>

                    <a href="index.php?c=asignaciones&a=individual" class="btn-action">
                        <span class="material-symbols-rounded" style="font-size: 1.2rem;">person</span> Individual
                    </a>
                </div>

                <div class="bento-card">
                    <h5 class="fw-800 mb-1">Supervisión</h5>
                    <p class="text-muted small">Monitoreo por docente.</p>
                    <a href="index.php?c=docentes&a=alumnos" class="btn-action">Ver Lista</a>
                </div>

                <a href="index.php?c=expedientes" class="bento-card text-center">
                    <span class="material-symbols-rounded fs-1 text-primary">folder_shared</span>
                    <div class="fw-bold mt-2">Expedientes</div>
                </a>

                <a href="index.php?c=bitacora" class="bento-card text-center">
                    <span class="material-symbols-rounded fs-1 text-dark">history_edu</span>
                    <div class="fw-bold mt-2">Bitácora</div>
                </a>

                <div class="bento-card">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold small">Online</span>
                        <div class="spinner-grow text-success" style="width: 10px; height: 10px;"></div>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 70%"></div>
                    </div>
                    <span class="text-muted small mt-2" style="font-size: 0.6rem;">Monitor de Alumnos</span>
                </div>

                <div class="bento-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold small">Servidor</span>
                        <span class="material-symbols-rounded text-primary fs-5">cloud_done</span>
                    </div>
                    <div class="bg-primary-subtle p-2 rounded-3 mt-2 text-center">
                        <span class="text-primary fw-bold" style="font-size: 0.6rem;">API Escolar Conectada</span>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

</html>