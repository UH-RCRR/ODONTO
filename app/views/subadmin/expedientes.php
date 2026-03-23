<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental UH | Expedientes</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    :root {
        --primary-dark: #0f172a;
        --dental-blue: #0284c7;
        --glass: rgba(255, 255, 255, 0.8);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        display: flex;
        margin: 0;
    }

    .main-content {
        margin-left: 280px;
        padding: 2rem;
        width: calc(100% - 280px);
    }

    .card-custom {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid white;
        border-radius: 28px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .table thead th {
        background-color: #f1f5f9;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        border: none;
        padding: 15px;
    }

    .table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .badge-tipo {
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.7rem;
    }

    .search-bar {
        background: #f1f5f9;
        border: none;
        border-radius: 15px;
        padding: 12px 20px;
        font-weight: 600;
    }
    </style>
</head>

<body>

    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="container-fluid">

            <header class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-800 mb-0">Gestión de Expedientes</h4>
                    <p class="text-muted small">Listado general de alumnos asignados en clínica</p>
                </div>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control search-bar" placeholder="Buscar alumno o matrícula...">
                </div>
            </header>

            <div class="card-custom">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Nombre del Alumno</th>
                                <th>Tipo</th>
                                <th>Docente Asignado</th>
                                <th>Fecha</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['alumnos'])): ?>
                            <?php foreach ($data['alumnos'] as $alumno): ?>
                            <tr>
                                <td class="fw-bold text-primary"><?= $alumno['alumno_matricula'] ?></td>
                                <td class="fw-800"><?= $alumno['alumno_nombre'] ?></td>
                                <td>
                                    <span class="badge-tipo bg-info-subtle text-info">
                                        <?= $alumno['tipo'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="material-symbols-rounded text-muted"
                                            style="font-size: 1.2rem;">person</span>
                                        <span class="small fw-600"><?= $alumno['docente_nombre'] ?></span>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    <?= date('d/m/Y', strtotime($alumno['fecha_asignacion'])) ?>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-light btn-sm rounded-3">
                                        <span class="material-symbols-rounded fs-5">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No hay expedientes registrados actualmente.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>

</html>