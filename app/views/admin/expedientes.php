<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$url_base = "/Odonto/public/index.php?c=";
$id_rol = $_SESSION['usuario']['rol_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedientes Clínicos | Dental UH</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

    <style>
    :root {
        --primary-dark: #0f172a;
        --accent: #0284c7;
        --bg-soft: #f8fafc;
        --sidebar-width: 280px;
        /* Ancho exacto de tu sidebar */
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-soft);
        margin: 0;
        padding: 0;
        /* Eliminamos el flex aquí por si el sidebar es fixed */
    }

    /* ESTO ES LO MÁS IMPORTANTE:
           El contenedor principal DEBE tener un margen izquierdo 
           igual al ancho del sidebar para que nada se tape.
        */
    .main-content {
        margin-left: var(--sidebar-width);
        padding: 2.5rem;
        min-height: 100vh;
        width: calc(100% - var(--sidebar-width));
        transition: all 0.3s ease;
    }

    .main-card {
        background: white;
        border-radius: 28px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
        margin-top: 1.5rem;
        width: 100%;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: white;
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        color: var(--accent);
        transform: translateX(-4px);
    }

    .avatar-circle {
        width: 44px;
        height: 44px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .btn-excel {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 14px;
        padding: 12px 20px;
        font-weight: 700;
    }

    /* Si la pantalla es pequeña, quitamos el margen */
    @media (max-width: 992px) {
        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 1.5rem;
        }
    }
    </style>
</head>

<body>

    <?php include_once dirname(__DIR__) . '/layouts/sidebar.php'; ?>

    <main class="main-content">

        <div class="row align-items-center g-4 mb-2">
            <div class="col-12 col-lg-8">
                <a href="<?= $url_base ?>Dashboard" class="btn-back mb-3">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Volver al Panel
                </a>
                <h1 style="font-weight: 800; color: var(--primary-dark); margin: 0;">Expedientes Clínicos</h1>
                <p class="text-muted small">Gestión de historiales académicos dentales.</p>
            </div>

            <div class="col-12 col-lg-4 text-lg-end">
                <button onclick="exportarExpedientes()"
                    class="btn btn-excel d-inline-flex align-items-center gap-2 shadow-sm">
                    <span class="material-symbols-rounded">description</span>
                    Exportar Reporte
                </button>
            </div>
        </div>

        <div class="card main-card">
            <div class="card-body p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="tablaExpedientes">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-700">Alumno / Matrícula</th>
                                <th class="text-center text-muted small fw-700">Consultas</th>
                                <th class="text-muted small fw-700">Fecha Apertura</th>
                                <th class="text-end pe-4 text-muted small fw-700">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($expedientes)): ?>
                            <?php foreach ($expedientes as $e): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle">
                                            <?= strtoupper(substr($e['alumno_nombre'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= htmlspecialchars($e['alumno_nombre']) ?></div>
                                            <div class="text-muted small">ID:
                                                <?= htmlspecialchars($e['alumno_matricula']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-light text-primary border px-3 py-2 fw-bold">
                                        <?= $e['total_consultas'] ?> visitas
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-secondary fw-semibold"><?= date('d/m/Y', strtotime($e['fecha_apertura'])) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= $url_base ?>Expedientes&a=ver&id=<?= $e['id'] ?>"
                                        class="btn btn-outline-dark btn-sm fw-bold px-3" style="border-radius: 10px;">
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No hay expedientes para mostrar</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
    function exportarExpedientes() {
        const table = document.getElementById("tablaExpedientes");
        const wb = XLSX.utils.table_to_book(table, {
            sheet: "Expedientes"
        });
        XLSX.writeFile(wb, "Reporte_Expedientes.xlsx");
    }
    </script>
</body>

</html>