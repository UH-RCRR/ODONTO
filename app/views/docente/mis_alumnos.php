<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica para agrupar los alumnos por su grupo en el PHP antes de mostrar la tabla
$grupos = [];
if (!empty($alumnos)) {
    foreach ($alumnos as $alumno) {
        // Usamos el nombre del grupo como llave (si no tiene grupo, le ponemos 'Sin Grupo')
        $nombreGrupo = $alumno['grupo_nombre'] ?? 'Asignaciones Individuales';
        $grupos[$nombreGrupo][] = $alumno;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Grupos | SIGO UH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    :root {
        --primary: #0f172a;
        --accent: #0284c7;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f1f5f9;
    }

    .main-content {
        padding: 2rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Estilo de los separadores de grupo */
    .group-header {
        background: var(--primary);
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        margin-top: 2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        padding: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .btn-back {
        background: white;
        color: var(--primary);
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: var(--accent);
        color: var(--accent);
    }
    </style>
</head>

<body>

    <main class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-800 mb-0">Mis Alumnos Asignados</h3>
                <p class="text-muted small">Organizados por grupo académico</p>
            </div>
            <a href="index.php?c=Docentes&a=dashboard" class="btn-back d-flex align-items-center gap-2">
                <span class="material-symbols-rounded">arrow_back</span> Volver
            </a>
        </header>

        <?php if (empty($grupos)): ?>
        <div class="alert alert-info border-0 shadow-sm rounded-4 text-center py-4">
            <span class="material-symbols-rounded fs-1 d-block mb-2">person_search</span>
            No tiene alumnos o grupos asignados todavía.
        </div>
        <?php else: ?>

        <?php foreach ($grupos as $nombreDelGrupo => $listaAlumnos): ?>
        <div class="group-header">
            <span class="material-symbols-rounded">grid_view</span>
            GRUPO: <?= htmlspecialchars($nombreDelGrupo) ?>
            <span class="badge bg-light text-dark ms-auto"><?= count($listaAlumnos) ?> Alumnos</span>
        </div>

        <div class="table-card mb-4">
            <div class="table-responsive">
                <table class="table align-middle m-0">
                    <thead class="text-secondary small fw-bold">
                        <tr>
                            <th>NOMBRE DEL ALUMNO</th>
                            <th>MATRÍCULA</th>
                            <th class="text-end">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaAlumnos as $alumno): ?>
                        <tr>
                            <td class="fw-600"><?= htmlspecialchars($alumno['alumno_nombre']) ?></td>
                            <td><code><?= htmlspecialchars($alumno['alumno_matricula']) ?></code></td>
                            <td class="text-end">
                                <a href="index.php?c=Docentes&a=verExpediente&matricula=<?= $alumno['alumno_matricula'] ?>"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                    Ver Expediente
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>
    </main>

</body>

</html>