<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$url_base = "index.php?c="; // Usamos ruta relativa para evitar conflictos
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Dental UH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    :root {
        --sb-accent: #0284c7;
        --primary-dark: #0f172a;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .main-content-sigouh {
        margin-left: 280px;
        padding: 40px;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .btn-nuevo {
        background: linear-gradient(135deg, var(--primary-dark), var(--sb-accent));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    @media (max-width: 992px) {
        .main-content-sigouh {
            margin-left: 0;
            padding: 20px;
        }
    }
    </style>
</head>

<body>

    <?php include_once dirname(__DIR__) . '/layouts/sidebar.php'; ?>

    <div class="main-content-sigouh">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-800 mb-0" style="font-weight: 800; color: var(--primary-dark);">Usuarios</h2>
                <p class="text-muted mb-0">Administración de personal y accesos</p>
            </div>

            <a href="index.php?c=Usuarios&a=nuevo" class="btn-nuevo shadow-sm">
                <span class="material-symbols-rounded">person_add</span>
                NUEVO USUARIO
            </a>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold">USUARIO</th>
                            <th class="border-0 text-muted small fw-bold">ROL</th>
                            <th class="border-0 text-muted small fw-bold">ESTADO</th>
                            <th class="text-center border-0 text-muted small fw-bold">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($u['correo']) ?></div>
                            </td>
                            <td>
                                <span class="badge border text-secondary px-2"><?= htmlspecialchars($u['rol']) ?></span>
                            </td>
                            <td>
                                <?php if ($u['activo']): ?>
                                <span
                                    class="status-badge bg-success bg-opacity-10 text-success border border-success-subtle">Activo</span>
                                <?php else: ?>
                                <span
                                    class="status-badge bg-danger bg-opacity-10 text-danger border border-danger-subtle">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="index.php?c=Usuarios&a=editar&id=<?= $u['id'] ?>"
                                        class="btn btn-sm btn-light rounded-circle" title="Editar">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 20px; vertical-align: middle;">edit</span>
                                    </a>

                                    <form method="POST" action="index.php?c=Usuarios&a=cambiarEstado"
                                        style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <input type="hidden" name="estado" value="<?= $u['activo'] ? 0 : 1 ?>">
                                        <button type="submit"
                                            class="btn btn-sm <?= $u['activo'] ? 'btn-outline-danger' : 'btn-success' ?> rounded-pill px-3 fw-bold">
                                            <?= $u['activo'] ? 'Inactivar' : 'Activar' ?>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>