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
    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

    <style>
    :root {
        --primary-dark: #0f172a;
        --dental-blue: #0284c7;
        --primary-gradient: linear-gradient(135deg, #0f172a 0%, #0284c7 100%);
        --glass: rgba(255, 255, 255, 0.8);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f1f5f9;
        min-height: 100vh;
        color: var(--primary-dark);
        padding: 2rem 1rem;
    }

    .main-wrapper {
        max-width: 1300px;
        margin: 0 auto;
    }

    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .bento-card {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid white;
        border-radius: 32px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
    }

    .bento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        border-color: var(--dental-blue) !important;
    }

    .span-2 {
        grid-column: span 2;
    }

    .row-2 {
        grid-row: span 2;
    }

    .big-stat {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .dark-card {
        background: var(--primary-gradient);
        color: white;
        border: none;
    }

    .btn-action {
        background: white;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 16px;
        padding: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        color: var(--primary-dark);
        margin-top: 8px;
    }
    </style>
</head>

<body>

    <div class="main-wrapper">
        <header class="d-flex justify-content-between align-items-center mb-4 px-2">
            <div class="d-flex align-items-center gap-3">
                <div style="background: var(--primary-gradient); color: white; padding: 10px; border-radius: 14px;">
                    <span class="material-symbols-rounded">dentistry</span>
                </div>
                <h4 class="fw-800 mb-0">Dental UH <br><small class="text-muted fs-6">Panel Maestro</small></h4>
            </div>
            <a href="index.php?c=auth&a=logout" class="btn btn-outline-danger btn-sm fw-bold rounded-pill px-3">Cerrar
                Sesión</a>
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
            <div class="bento-card dark-card">
                <span class="material-symbols-rounded">notifications_active</span>
                <div class="big-stat mt-2"><?= $data['pendientes'] ?></div>
                <div class="small opacity-75">Pendientes</div>
            </div>

            <div class="bento-card span-2 row-2">
                <h3 class="fw-800">Gestión de Usuarios</h3>
                <p class="text-muted">Administración central de cuentas y permisos.</p>
                <div class="bg-light p-3 rounded-4 mb-3 border d-flex align-items-center gap-2">
                    <span class="material-symbols-rounded text-success">shield_check</span>
                    <span class="small fw-bold">Base de datos optimizada y segura</span>
                </div>
                <a href="index.php?c=usuarios" class="btn btn-dark py-3 rounded-4 fw-bold">Abrir Administrador</a>
            </div>

            <div class="bento-card row-2">
                <span class="material-symbols-rounded fs-1 text-primary">hub</span>
                <h4 class="fw-800 mt-2">Asignaciones</h4>
                <p class="text-muted small">Vinculación académica.</p>
                <a href="index.php?c=asignaciones" class="btn-action">Grupal</a>
                <a href="index.php?c=asignaciones&a=individual" class="btn-action">Individual</a>
            </div>

            <div class="bento-card">
                <h5 class="fw-800 mb-1">Supervisión</h5>
                <p class="text-muted small">Alumnos por docente.</p>
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

</body>

</html>