<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * RUTA CORREGIDA SEGÚN TU ESTRUCTURA
 */
require_once dirname(__DIR__) . '/layouts/sidebar.php'; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docente | SIGO UH</title>
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

    /* AJUSTE RESPONSIVO PARA EL CONTENIDO PRINCIPAL */
    .main-content {
        margin-left: 280px;
        padding: 1.5rem;
        width: calc(100% - 280px);
        transition: all 0.3s ease;
    }

    @media (max-width: 992px) {
        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 1rem;
        }
    }

    .main-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* GRID RESPONSIVO */
    @media (max-width: 1200px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .bento-grid {
            grid-template-columns: 1fr;
        }

        .span-2 {
            grid-column: span 1 !important;
        }
    }

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
    }

    .bento-card:hover {
        transform: translateY(-8px);
        background-color: var(--dental-light) !important;
        border-color: var(--dental-blue) !important;
    }

    .big-stat {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1;
    }

    .span-2 {
        grid-column: span 2;
    }

    .row-2 {
        grid-row: span 2;
    }

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
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-action:hover {
        background: var(--dental-blue) !important;
        color: white !important;
    }

    .btn-dark-premium {
        background: #1e293b;
        color: white !important;
        padding: 15px;
        border-radius: 18px;
        text-align: center;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-dark-premium:hover {
        background: var(--dental-blue);
    }
    </style>
</head>

<body>
    <main class="main-content">
        <div class="main-wrapper">
            <header class="d-flex justify-content-between align-items-center mb-4 px-2">
                <div>
                    <h4 class="fw-800 mb-0">Panel de Control</h4>
                    <p class="text-muted small mb-0">Bienvenido al sistema SIGO UH</p>
                </div>
                <div class="text-muted small fw-bold uppercase d-none d-sm-block"><?= date('d M, Y') ?></div>
            </header>

            <div class="bento-grid">
                <div class="bento-card">
                    <span class="material-symbols-rounded text-primary">group</span>
                    <div class="big-stat mt-2"><?= isset($alumnos) ? count($alumnos) : 0 ?></div>
                    <div class="fw-bold text-muted small">Alumnos bajo su cargo</div>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-success">dentistry</span>
                    <div class="mt-3 h5 fw-800 mb-1">Especialidad</div>
                    <div class="fw-bold text-muted small">Odontología Clínica</div>
                </div>

                <div class="bento-card span-2 row-2">
                    <div>
                        <h3 class="fw-800">Expedientes Clínicos</h3>
                        <p class="text-muted">Revise, valide y gestione todas las historias clínicas subidas por sus
                            alumnos.</p>
                        <div class="bg-light p-3 rounded-4 mb-4 border d-flex align-items-center gap-2">
                            <span class="material-symbols-rounded text-primary">folder_shared</span>
                            <span class="small fw-bold">Gestión de archivos por matrícula</span>
                        </div>
                    </div>
                    <a href="index.php?c=Docentes&a=misAlumnos" class="btn-dark-premium">
                        Gestionar Expedientes
                    </a>
                </div>

                <div class="bento-card row-2">
                    <span class="material-symbols-rounded fs-1 text-primary">analytics</span>
                    <h4 class="fw-800 mt-2">Reportes</h4>
                    <p class="text-muted small">Descarga de bitácoras de alumnos y avances académicos.</p>
                    <a href="index.php?c=Docentes&a=exportar" class="btn-action">
                        <span class="material-symbols-rounded">download</span> Descargar PDF
                    </a>
                </div>

                <div class="bento-card">
                    <h5 class="fw-800 mb-2">Mi Grupo</h5>
                    <p class="text-muted small">Administración de la lista de alumnos.</p>
                    <a href="index.php?c=Docentes&a=misAlumnos" class="btn-action">
                        Ver Lista
                    </a>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-info">person</span>
                    <div class="fw-bold mt-2 text-uppercase" style="font-size: 0.9rem;">
                        <?= $_SESSION['usuario']['nombre'] ?></div>
                    <div class="text-muted small">Docente Titular</div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>