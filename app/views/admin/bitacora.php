<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría de Bitácora | Dental UH</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

    <style>
        :root {
            --bg-body: #f1f5f9;
            --text-main: #0f172a;
            --accent: #0284c7;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .back-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: white;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #64748b;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            margin-bottom: 2rem;
        }

        .back-nav:hover {
            color: var(--accent);
            background: #f8fafc;
            transform: translateX(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .log-container {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,1);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .log-header {
            padding: 2rem;
            background: linear-gradient(to right, #ffffff, #f8fafc);
            border-bottom: 1px solid #f1f5f9;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .pill-blue { background: #e0f2fe; color: #0369a1; }
        .pill-green { background: #dcfce7; color: #15803d; }
        .pill-red { background: #fee2e2; color: #b91c1c; }
        .pill-yellow { background: #fef9c3; color: #854d0e; }

        .ip-address {
            font-family: 'SF Mono', monospace;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            color: #475569;
        }

        .btn-excel {
            background-color: #16a34a;
            color: white;
            border: none;
            transition: 0.2s;
        }

        .btn-excel:hover {
            background-color: #15803d;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <a href="index.php?c=admin" class="back-nav">
        <span class="material-symbols-rounded">arrow_back</span>
        Regresar al Panel Principal
    </a>

    <div class="log-container">
        <div class="log-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-800 mb-1">Registro de Actividad</h3>
                <p class="text-muted small mb-0">Auditoría completa de movimientos en el sistema Dental UH.</p>
            </div>
            <button onclick="exportarExcel()" class="btn btn-excel btn-md d-flex align-items-center gap-2 rounded-3 fw-bold shadow-sm">
                <span class="material-symbols-rounded fs-5">description</span>
                Exportar a Excel
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="tablaBitacora">
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Identidad (Usuario)</th>
                        <th>Módulo</th>
                        <th>Evento / Acción</th>
                        <th class="text-center">Dirección IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($registros)): ?>
                        <?php foreach ($registros as $r): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= date('d/m/Y', strtotime($r['created_at'])) ?></div>
                                <div class="text-muted small"><?= date('H:i:s', strtotime($r['created_at'])) ?></div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="min-width: 32px; height: 32px; font-size: 0.7rem;">
                                        <?= strtoupper(substr($r['usuario_correo'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($r['usuario_correo']) ?></div>
                                        <div class="text-muted small" style="font-size: 0.7rem;"><?= htmlspecialchars($r['rol']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-uppercase p-1 px-2 bg-light rounded text-secondary" style="font-size: 0.7rem;">
                                    <?= htmlspecialchars($r['modulo']) ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                    $acc = mb_strtolower($r['accion']);
                                    $pill = 'pill-blue';
                                    $icon = 'info';
                                    if (strpos($acc, 'crear') !== false || strpos($acc, 'asignó') !== false) { $pill = 'pill-green'; $icon = 'add_circle'; }
                                    elseif (strpos($acc, 'eliminar') !== false || strpos($acc, 'borrar') !== false) { $pill = 'pill-red'; $icon = 'delete'; }
                                    elseif (strpos($acc, 'actualizar') !== false || strpos($acc, 'editar') !== false) { $pill = 'pill-yellow'; $icon = 'edit'; }
                                ?>
                                <span class="status-pill <?= $pill ?>">
                                    <span class="material-symbols-rounded fs-6"><?= $icon ?></span>
                                    <?= htmlspecialchars($r['accion']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="ip-address"><?= $r['ip'] ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <span class="material-symbols-rounded opacity-25 fs-1">database_off</span>
                                <p class="text-muted mt-2">No se encontraron registros de auditoría.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4 px-3 text-muted" style="font-size: 0.75rem;">
        <div>Generado automáticamente por el Sistema de Seguridad Dental UH</div>
        <div>2026 Auditoría Interna</div>
    </div>
</div>

<script>
function exportarExcel() {
    // 1. Obtener la tabla
    const table = document.getElementById("tablaBitacora");
    
    // 2. Convertir tabla a libro de trabajo (Worksheet)
    const wb = XLSX.utils.table_to_book(table, { sheet: "Bitacora_DentalUH" });
    
    // 3. Generar nombre de archivo con fecha actual
    const fecha = new Date().toISOString().slice(0,10);
    const nombreArchivo = `Reporte_Bitacora_${fecha}.xlsx`;
    
    // 4. Descargar archivo
    XLSX.writeFile(wb, nombreArchivo);
}
</script>

</body>
</html>