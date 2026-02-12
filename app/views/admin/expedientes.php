<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedientes Clínicos | Dental UH</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

    <style>
        :root {
            --primary-dark: #0f172a;
            --accent: #0284c7;
            --bg-soft: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            color: var(--primary-dark);
        }

        /* Botón de Regreso */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: white;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            color: var(--accent);
            background: #fff;
            transform: translateX(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Card de Contenido */
        .main-card {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
        }

        /* Tabla Estilizada */
        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            padding: 1.2rem 1.5rem;
            border: none;
        }

        .table tbody td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Avatares */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #e2e8f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .bg-user { background: #e0f2fe; color: #0369a1; }

        /* Botones de Acción */
        .btn-action {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            padding: 8px 16px;
        }

        .btn-excel {
            background-color: #16a34a;
            color: white;
            border: none;
        }

        .btn-excel:hover {
            background-color: #15803d;
            color: white;
        }
    </style>
</head>

<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <a href="index.php?c=admin" class="btn-back mb-3">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver al Panel
            </a>
            <h2 class="fw-800 mb-1">Expedientes Clínicos</h2>
            <p class="text-muted mb-0 small">Gestión y consulta de historiales académicos dentales.</p>
        </div>
        
        <button onclick="exportarExpedientes()" class="btn btn-excel btn-action d-flex align-items-center gap-2 shadow-sm">
            <span class="material-symbols-rounded fs-5">description</span>
            Exportar Excel
        </button>
    </div>

    <div class="card main-card overflow-hidden">
        <div class="card-body p-0">
            <?php if (!empty($expedientes)): ?>
                <div class="table-responsive">
                    <table class="table mb-0" id="tablaExpedientes">
                        <thead>
                            <tr>
                                <th>Alumno / Matrícula</th>
                                <th class="text-center">Consultas Totales</th>
                                <th>Fecha de Apertura</th>
                                <th class="text-end">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expedientes as $e): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle bg-user">
                                                <?= strtoupper(substr($e['alumno_nombre'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($e['alumno_nombre']) ?></div>
                                                <div class="text-muted small" style="font-size: 0.75rem;">ID: <?= htmlspecialchars($e['alumno_matricula']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-light text-primary border px-3 py-2">
                                            <?= $e['total_consultas'] ?> visitas
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold" style="font-size: 0.9rem;">
                                            <?= date('d/m/Y', strtotime($e['fecha_apertura'])) ?>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.7rem;">Registro inicial</div>
                                    </td>
                                    <td class="text-end">
                                        <a href="index.php?c=expedientes&a=ver&id=<?= $e['id'] ?>"
                                           class="btn btn-outline-dark btn-action">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="material-symbols-rounded fs-5">visibility</span>
                                                Ver Detalle
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <span class="material-symbols-rounded fs-1 opacity-25 text-muted" style="font-size: 4rem;">folder_off</span>
                    <h5 class="mt-3 fw-bold">Sin expedientes</h5>
                    <p class="text-muted mx-auto" style="max-width: 300px;">No se encontraron historiales clínicos registrados en el sistema actualmente.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="mt-5 text-center">
        <div class="d-flex justify-content-center align-items-center gap-2 text-muted small">
            <span class="material-symbols-rounded fs-6">verified_user</span>
            <span>Sistema Seguro DentalUH © 2026 - Auditoría Interna</span>
        </div>
    </footer>
</div>

<script>
function exportarExpedientes() {
    const table = document.getElementById("tablaExpedientes");
    if (!table) return;

    const wb = XLSX.utils.table_to_book(table, { sheet: "Expedientes_Clinicos" });
    const fecha = new Date().toISOString().slice(0,10);
    XLSX.writeFile(wb, `Reporte_Expedientes_${fecha}.xlsx`);
}
</script>

</body>
</html>