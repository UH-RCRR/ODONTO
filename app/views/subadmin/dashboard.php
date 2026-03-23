<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental UH | Subadmin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    :root {
        --primary-dark: #0f172a;
        --dental-blue: #0284c7;
        --dental-light: #e0f2fe;
        --primary-gradient: linear-gradient(135deg, #334155 0%, #0f172a 100%);
        --glass: rgba(255, 255, 255, 0.8);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        color: var(--primary-dark);
        margin: 0;
        display: flex;
    }

    .main-content {
        margin-left: 280px;
        padding: 1.5rem;
        width: calc(100% - 280px);
    }

    .main-wrapper { max-width: 1200px; margin: 0 auto; }

    /* --- BENTO GRID --- */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
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
        text-decoration: none;
        color: inherit;
    }

    .bento-card:hover {
        transform: translateY(-5px);
        background-color: var(--dental-light);
        border-color: var(--dental-blue);
    }

    .big-stat {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin: 0.5rem 0;
    }

    .btn-action {
        background: white;
        border: 1px solid rgba(15, 23, 42, 0.1);
        border-radius: 14px;
        padding: 10px;
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
        background: var(--dental-blue);
        color: white;
    }

    .span-2 { grid-column: span 2; }
    .row-2 { grid-row: span 2; }

    .header-badge {
        background: #f1f5f9;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="main-wrapper">

            <header class="d-flex justify-content-between align-items-center mb-4 px-2">
                <div>
                    <div class="header-badge mb-2">Área de Gestión Operativa</div>
                    <h4 class="fw-800 mb-0">Panel del Subadministrador</h4>
                    <p class="text-muted small mb-0">Bienvenido, <?= $_SESSION['usuario']['nombre'] ?? 'Subadmin' ?></p>
                </div>
                <div class="text-end">
                    <div class="text-muted small fw-bold"><?= date('d M, Y') ?></div>
                    <span class="badge bg-primary rounded-pill mt-1">Sincronizado</span>
                </div>
            </header>

            <div class="bento-grid">
                
                <div class="bento-card">
                    <span class="material-symbols-rounded text-primary">school</span>
                    <div class="big-stat"><?= $data['total_alumnos'] ?></div>
                    <div class="fw-bold text-muted small uppercase">Alumnos Activos</div>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-info">clinical_notes</span>
                    <div class="big-stat"><?= $data['total_docentes'] ?></div>
                    <div class="fw-bold text-muted small uppercase">Docentes Supervisando</div>
                </div>

                <div class="bento-card span-2 bg-white border-primary shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-800 mb-1">Control de Expedientes</h5>
                            <p class="text-muted small">Supervisión integral de historias clínicas y progreso académico.</p>
                        </div>
                        <span class="material-symbols-rounded fs-1 text-primary">folder_open</span>
                    </div>
                    <div class="mt-auto">
                        <a href="index.php?c=subadmin&a=expedientes" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-sm">Ver Todos los Expedientes</a>
                    </div>
                </div>

                <div class="bento-card span-2 row-2">
                    <h5 class="fw-800 mb-3">Resumen de Asignaciones</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Docente</th>
                                    <th>Cant. Alumnos</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data['asignaciones_recientes'])): ?>
                                    <?php foreach($data['asignaciones_recientes'] as $row): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $row['docente_nombre'] ?></td>
                                        <td><span class="badge bg-light text-dark"><?= $row['total_alumnos'] ?> Alumnos</span></td>
                                        <td><a href="#" class="text-primary text-decoration-none">Detalles</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted">No hay asignaciones activas</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-warning">assignment_ind</span>
                    <h6 class="fw-800 mt-2">Vincular Alumnos</h6>
                    <p class="text-muted small">Asignar alumnos a docentes específicos.</p>
                    <a href="index.php?c=subadmin&a=vincular" class="btn-action">Iniciar Vinculación</a>
                </div>

                <div class="bento-card">
                    <span class="material-symbols-rounded text-danger">summarize</span>
                    <h6 class="fw-800 mt-2">Reportes</h6>
                    <p class="text-muted small">Exportar actividad docente.</p>
                    <a href="index.php?c=subadmin&a=reporteDocentes" class="btn-action">Generar PDF</a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>