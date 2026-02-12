<?php include __DIR__ . '/../layouts/header.php'; ?>

<h3>Alumnos por Grupo</h3>

<form method="POST">
    <div class="row mb-3">
        <div class="col-md-4">
            <input
                type="text"
                name="claveGrupo"
                class="form-control"
                placeholder="Clave del grupo"
                required
            >
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Buscar</button>
        </div>
    </div>
</form>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($alumnos)): ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Género</th>
            <th>Estatus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?= htmlspecialchars($alumno['matricula']) ?></td>
            <td><?= htmlspecialchars($alumno['nombreCompleto']) ?></td>
            <td><?= htmlspecialchars($alumno['correoInstitucional']) ?></td>
            <td><?= htmlspecialchars($alumno['genero']) ?></td>
            <td><?= htmlspecialchars($alumno['estatus']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
