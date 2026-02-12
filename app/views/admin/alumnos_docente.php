<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos por Docente | Dental UH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-dark: #001f3f;
            --dental-blue: #0ea5e9;
            --dental-light: #e0f2fe;
            --bg-body: #f1f5f9;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Botón Volver */
        .btn-back-main {
            background: white;
            color: var(--primary-dark);
            border: 2px solid var(--primary-dark);
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back-main:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateX(-5px);
        }

        /* Contenedor de Filtro (Estilo igual al buscador) */
        .filter-container {
            background: var(--primary-dark);
            border-radius: 30px;
            padding: 30px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 31, 63, 0.1);
        }

        .filter-container form {
            position: relative;
            z-index: 5;
        }

        .filter-container::after {
            content: '\f0c0'; /* Icono de usuarios */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8rem;
            color: rgba(255,255,255,0.05);
            pointer-events: none;
        }

        .form-select-dental {
            border-radius: 15px;
            border: none;
            padding: 12px 20px;
            height: 100%;
        }

        /* Estilo de Tabla Modernizada */
        .table-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .table thead {
            background-color: #f8fafc;
        }

        .table thead th {
            color: var(--primary-dark);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 20px;
            border: none;
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            color: #475569;
            border-color: #f1f5f9;
        }

        .dental-badge {
            background: var(--dental-light);
            color: var(--dental-blue);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .btn-export {
            background-color: #22c55e;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            background-color: #16a34a;
            color: white;
            transform: translateY(-2px);
        }

        .btn-view {
            background: var(--dental-blue);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <a href="index.php?c=admin" class="btn-back-main shadow-sm">
            <i class="fas fa-chevron-left"></i> 
            VOLVER
        </a>
        <div class="text-end">
            <h2 class="fw-bold mb-0" style="color: var(--primary-dark)">Lista de Asignados</h2>
            <span class="dental-badge"><i class="fas fa-chalkboard-teacher me-1"></i> Reporte por Docente</span>
        </div>
    </div>

    <div class="filter-container text-white">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-3 mb-lg-0">
                <h4 class="mb-1 fw-bold">Consulta de Alumnos</h4>
                <p class="small opacity-75 mb-0">Seleccione un docente para ver su carga académica.</p>
            </div>
            <div class="col-lg-7">
                <form method="GET" action="index.php" class="row g-2">
                    <input type="hidden" name="c" value="docentes">
                    <input type="hidden" name="a" value="alumnos">
                    
                    <div class="col-md-8">
                        <select name="docente" class="form-select form-select-dental" required>
                            <option value="">Seleccione docente...</option>
                            <?php foreach ($docentes as $d): ?>
                                <option value="<?= $d['id'] ?>" <?= (isset($_GET['docente']) && $_GET['docente'] == $d['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d['nombre']) ?> — <?= htmlspecialchars($d['correo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-view shadow">
                            <i class="fas fa-search me-2"></i>Ver alumnos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($_GET['docente'])): ?>
        <div class="mb-4 d-flex justify-content-end">
            <a href="index.php?c=docentes&a=exportar&docente=<?= htmlspecialchars($_GET['docente']) ?>" class="btn-export shadow-sm">
                <i class="fas fa-file-excel"></i> Exportar a Excel (CSV)
            </a>
        </div>
    <?php endif; ?>

    <div class="table-card shadow-sm">
        <?php if (!empty($alumnos)): ?>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-card me-2"></i>Matrícula</th>
                            <th><i class="fas fa-user me-2"></i>Alumno</th>
                            <th><i class="fas fa-tag me-2"></i>Tipo</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Fecha asignación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumnos as $a): ?>
                            <tr>
                                <td class="fw-bold text-primary"><?= htmlspecialchars($a['alumno_matricula']) ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($a['alumno_nombre']) ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark border">
                                        <?= htmlspecialchars($a['tipo']) ?>
                                    </span>
                                </td>
                                <td class="text-muted"><?= htmlspecialchars($a['fecha_asignacion']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (isset($_GET['docente'])): ?>
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-folder-open fa-3x opacity-25"></i>
                </div>
                <h5 class="text-muted">No hay alumnos asignados a este docente.</h5>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted mb-0">Seleccione un docente arriba para mostrar los datos.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>