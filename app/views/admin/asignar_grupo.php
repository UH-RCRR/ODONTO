<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación Grupal | Dental UH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --primary: #001f3f;
        --dental-blue: #0ea5e9;
        --bg: #f8fafc;
    }

    body {
        background-color: var(--bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .btn-dental {
        background: var(--primary);
        color: white;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-dental:hover {
        background: var(--dental-blue);
        color: white;
        transform: translateY(-2px);
    }

    .table thead {
        background: var(--primary);
        color: white;
    }

    .checkbox-lg {
        width: 22px;
        height: 22px;
        cursor: pointer;
    }

    .sticky-card {
        position: sticky;
        top: 20px;
    }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php?c=asignaciones&a=individual" class="btn btn-outline-dark border-2 fw-bold"
                style="border-radius: 12px;">
                <i class="fas fa-arrow-left me-2"></i> Regresar a Individual
            </a>
            <div class="text-end">
                <h2 class="fw-bold mb-0" style="color: var(--primary)">Asignación por Grupo</h2>
                <p class="text-muted small">Vincule grupos completos a un docente</p>
            </div>
        </div>

        <div class="card card-custom p-4 mb-4" style="background: var(--primary);">
            <form method="GET" action="index.php" class="row g-3 align-items-center">
                <input type="hidden" name="c" value="asignaciones">
                <input type="hidden" name="a" value="grupal">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-users text-muted"></i></span>
                        <input type="text" name="grupo" class="form-control border-0 py-3"
                            placeholder="Ingrese Clave de Grupo (Ej: BG4A...)"
                            value="<?= htmlspecialchars($_GET['grupo'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info w-100 py-3 fw-bold text-white shadow-sm"
                        style="border-radius: 12px;">
                        <i class="fas fa-search me-2"></i> BUSCAR ALUMNOS
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($alumnos)): ?>
        <form action="index.php?c=asignaciones&a=guardarGrupal" method="POST" id="formAsignacion">
            <input type="hidden" name="clave_grupo" value="<?= htmlspecialchars($_GET['grupo']) ?>">
            <input type="hidden" name="docente_nombre" id="docente_nombre_input">

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card card-custom p-4 sticky-card">
                        <h5 class="fw-bold mb-3"><i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Docente
                            Supervisor</h5>

                        <select class="form-select mb-3 py-3 border-light bg-light" name="docente_correo"
                            id="docente_select" required>
                            <option value="">Seleccione al Doctor(a)...</option>
                            <?php foreach ($docentes as $d): ?>
                            <option value="<?= $d['correoInstitucional'] ?>" data-nombre="<?= $d['nombreCompleto'] ?>">
                                <?= $d['nombreCompleto'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="d-grid gap-2">
                            <button type="button" id="btnSelectAll" class="btn btn-outline-primary btn-sm mb-2">
                                <i class="fas fa-check-double me-1"></i> Seleccionar todo el grupo
                            </button>

                            <button type="submit" class="btn btn-dental py-3 shadow">
                                <i class="fas fa-save me-2"></i> PROCESAR ASIGNACIÓN
                            </button>
                        </div>

                        <div id="statusCount" class="text-center mt-3 small text-muted">
                            Alumnos seleccionados: <span id="countDisplay" class="fw-bold">0</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card card-custom overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4" width="60">
                                            <input type="checkbox" id="checkAllHeader"
                                                class="form-check-input checkbox-lg">
                                        </th>
                                        <th width="150">Matrícula</th>
                                        <th>Nombre del Alumno</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alumnos as $a): 
                                        $nombre = $a['nombreAlumno'] ?? ($a['nombreCompleto'] ?? 'Sin nombre');
                                        $matricula = trim($a['matricula'] ?? '000000');
                                        // Guardamos los datos en JSON para que el controlador los procese fácil
                                        $alumnoData = json_encode(['matricula' => $matricula, 'nombre' => $nombre]);
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="alumnos[]"
                                                value='<?= htmlspecialchars($alumnoData, ENT_QUOTES) ?>'
                                                class="form-check-input checkbox-lg alumno-check">
                                        </td>
                                        <td class="fw-bold text-primary"><?= $matricula ?></td>
                                        <td class="text-uppercase"><?= $nombre ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php elseif (isset($_GET['grupo'])): ?>
        <div class="card card-custom p-5 text-center">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No hay resultados para "<?= htmlspecialchars($_GET['grupo']) ?>"</h4>
            <p>Verifica la clave o asegúrate de que el grupo tenga alumnos inscritos.</p>
        </div>
        <?php endif; ?>
    </div>

    <script>
    const selectDocente = document.getElementById('docente_select');
    const inputNombreDocente = document.getElementById('docente_nombre_input');
    const headerCheck = document.getElementById('checkAllHeader');
    const alumnoChecks = document.querySelectorAll('.alumno-check');
    const btnSelectAll = document.getElementById('btnSelectAll');
    const countDisplay = document.getElementById('countDisplay');

    // 1. Sincronizar nombre del docente
    selectDocente.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        inputNombreDocente.value = selectedOption.getAttribute('data-nombre') || '';
    });

    // 2. Función para actualizar contador
    function updateCount() {
        const checked = document.querySelectorAll('.alumno-check:checked').length;
        countDisplay.innerText = checked;
    }

    // 3. Checkbox maestro (Header)
    headerCheck.addEventListener('change', function() {
        alumnoChecks.forEach(ck => ck.checked = this.checked);
        updateCount();
    });

    // 4. Botón "Seleccionar todo el grupo"
    btnSelectAll.addEventListener('click', function() {
        alumnoChecks.forEach(ck => ck.checked = true);
        headerCheck.checked = true;
        updateCount();
    });

    // 5. Listener individual para los alumnos
    alumnoChecks.forEach(ck => {
        ck.addEventListener('change', updateCount);
    });

    // 6. Validación antes de enviar
    document.getElementById('formAsignacion').addEventListener('submit', function(e) {
        const selected = document.querySelectorAll('.alumno-check:checked').length;
        if (selected === 0) {
            e.preventDefault();
            alert('❌ Error: Debe seleccionar al menos un alumno para procesar.');
        }
    });
    </script>
</body>

</html>