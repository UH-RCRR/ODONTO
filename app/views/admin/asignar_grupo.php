<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Alumnos por Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h3>Asignación de Alumnos por Grupo</h3>

    <!-- BUSCAR GRUPO -->
    <form method="GET" action="index.php" class="row g-3 mb-4">
        <input type="hidden" name="c" value="asignaciones">

        <div class="col-md-8">
            <input type="text" name="grupo" class="form-control"
                   placeholder="Clave del grupo (ej. AEBR-401)" required>
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary w-100">Buscar grupo</button>
        </div>
    </form>

    <?php if (!empty($alumnos)): ?>

        <form method="POST" action="index.php?c=asignaciones&a=guardarGrupo">

            <input type="hidden" name="grupo" value="<?= $_GET['grupo'] ?>">

            <!-- DOCENTE -->
            <div class="mb-3">
                <label class="form-label">Docente</label>
                <select name="docente" class="form-select" required>
                    <?php foreach ($docentes as $d): ?>
                        <option value="<?= $d['correoInstitucional'] ?>">
                            <?= $d['nombreCompleto'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- ALUMNOS -->
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Matrícula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $a): ?>
                        <tr>
                            <td><?= $a['nombreCompleto'] ?></td>
                            <td><?= $a['Matricula'] ?></td>
                        </tr>

                        <input type="hidden" name="alumnos[][matricula]"
                               value="<?= $a['Matricula'] ?>">
                        <input type="hidden" name="alumnos[][nombre]"
                               value="<?= $a['nombreCompleto'] ?>">
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button class="btn btn-success">
                Asignar grupo completo
            </button>
        </form>

    <?php endif; ?>

    <a href="index.php?c=admin" class="btn btn-secondary btn-sm mt-3">Volver</a>

</div>

</body>
</html>
