<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asignación | Dental UH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">

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

    .search-container {
        background: var(--primary-dark);
        border-radius: 30px;
        padding: 30px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .search-container form {
        position: relative;
        z-index: 5;
    }

    .search-container::after {
        content: '\f5c9';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 10rem;
        color: rgba(255, 255, 255, 0.05);
        z-index: 1;
        pointer-events: none;
    }

    .form-control-dental {
        border-radius: 15px;
        border: none;
        padding: 15px 25px;
    }

    .btn-assign-dental {
        background: linear-gradient(135deg, var(--dental-blue), #0284c7);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 20px;
        width: 100%;
        cursor: pointer;
    }

    .student-card {
        background: white;
        border: none;
        border-radius: 24px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 31, 63, 0.1);
        border-color: var(--dental-blue);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: var(--dental-light);
        color: var(--dental-blue);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
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
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="index.php?c=subadmin&a=dashboard" class="btn-back-main shadow-sm">
                <i class="fas fa-chevron-left"></i>
                REGRESAR AL PANEL
            </a>
            <div class="text-end">
                <h2 class="fw-bold mb-0" style="color: var(--primary-dark)">Gestión de Clínicas</h2>
                <span class="dental-badge"><i class="fas fa-tooth me-1"></i> Control de Expedientes</span>
            </div>
        </div>

        <div class="search-container shadow-lg text-white">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h4 class="mb-1 fw-bold">Buscar Paciente/Alumno</h4>
                    <p class="small opacity-75 mb-0">Ingrese la matrícula o nombre para vincular con un docente.</p>
                </div>
                <div class="col-lg-6">
                    <form id="searchForm" class="d-flex gap-2" method="GET" action="index.php">
                        <input type="hidden" name="c" value="subadmin">
                        <input type="hidden" name="a" value="vincular">
                        <input type="text" name="buscar" class="form-control form-control-dental"
                            placeholder="Ej: 2024001..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
                            required>

                        <button type="submit" class="btn btn-info px-4 fw-bold text-white shadow"
                            style="border-radius: 15px; z-index: 20; position: relative;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($alumnos) && is_array($alumnos)): ?>
            <?php foreach ($alumnos as $a): 
                    // Normalización de datos basada en respuesta real de API
                    $nombre = $a['nombreCompleto'] ?? $a['NombreCompleto'] ?? 'Nombre no disponible';
                    $matricula = trim($a['Matricula'] ?? $a['matricula'] ?? '000000');
                ?>
            <div class="col-md-6 mb-4">
                <div class="student-card p-4 shadow-sm">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-box">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($nombre) ?></h5>
                                <span class="badge bg-light text-primary border">ID:
                                    <?= htmlspecialchars($matricula) ?></span>
                            </div>
                            <p class="text-muted small mb-3">Licenciatura en Odontología</p>

                            <form method="POST" action="index.php?c=asignaciones&a=guardarIndividual">
                                <input type="hidden" name="matricula" value="<?= htmlspecialchars($matricula) ?>">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                                <input type="hidden" name="docente_nombre" value="">

                                <div class="row g-2">
                                    <div class="col-8">
                                        <select class="form-select border-0 bg-light" name="docente_correo" required
                                            style="border-radius: 10px;"
                                            onchange="this.form.docente_nombre.value=this.selectedOptions[0].dataset.nombre">
                                            <option value="">Seleccionar Dr./Dra...</option>
                                            <?php foreach ($docentes as $d): ?>
                                            <option value="<?= htmlspecialchars($d['correoInstitucional']) ?>"
                                                data-nombre="<?= htmlspecialchars($d['nombreCompleto']) ?>">
                                                Dr. <?= htmlspecialchars($d['nombreCompleto']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-assign-dental shadow-sm">
                                            <i class="fas fa-link me-1"></i> Asignar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php elseif (isset($_GET['buscar'])): ?>
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/3773/3773919.png" alt="No encontrado"
                    style="width: 80px; opacity: 0.5;">
                <h5 class="mt-3 text-muted">No se encontró al alumno "<?= htmlspecialchars($_GET['buscar']) ?>"</h5>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>