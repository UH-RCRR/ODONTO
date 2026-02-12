<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Dental UH</title>
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

        /* Título y Badge */
        .dental-badge {
            background: var(--dental-light);
            color: var(--dental-blue);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* Tarjeta de Tabla */
        .table-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 31, 0.05);
            margin-top: 20px;
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

        /* Badges de Estado Custom */
        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 10px;
        }

        /* Botones de acción */
        .btn-action {
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-activate {
            background-color: #22c55e;
            color: white;
        }

        .btn-activate:hover {
            background-color: #16a34a;
            color: white;
            transform: scale(1.05);
        }

        .btn-deactivate {
            background-color: #ef4444;
            color: white;
        }

        .btn-deactivate:hover {
            background-color: #dc2626;
            color: white;
            transform: scale(1.05);
        }

        .user-icon {
            width: 35px;
            height: 35px;
            background: var(--dental-light);
            color: var(--dental-blue);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <a href="index.php?c=admin" class="btn-back-main shadow-sm">
            <i class="fas fa-chevron-left"></i> 
            PANEL PRINCIPAL
        </a>
        <div class="text-end">
            <h2 class="fw-bold mb-0" style="color: var(--primary-dark)">Gestión de Usuarios</h2>
            <span class="dental-badge"><i class="fas fa-users-cog me-1"></i> Control de Acceso</span>
        </div>
    </div>

    <div class="table-card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 table-hover">
                <thead>
                    <tr>
                        <th>Usuario / Correo</th>
                        <th>Rol del Sistema</th>
                        <th>Estado Actual</th>
                        <th width="180" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($u['correo']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted"><i class="fas fa-user-shield me-1"></i> <?= htmlspecialchars($u['rol']) ?></span>
                            </td>
                            <td>
                                <?php if ($u['activo']): ?>
                                    <span class="status-badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle me-1"></i> Activo
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge bg-danger bg-opacity-10 text-danger">
                                        <i class="fas fa-times-circle me-1"></i> Inactivo
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <form method="POST" action="index.php?c=usuarios&a=cambiarEstado" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <input type="hidden" name="estado" value="<?= $u['activo'] ? 0 : 1 ?>">
                                    
                                    <?php if ($u['activo']): ?>
                                        <button type="submit" class="btn btn-action btn-deactivate btn-sm shadow-sm">
                                            <i class="fas fa-user-slash me-1"></i> Desactivar
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-action btn-activate btn-sm shadow-sm">
                                            <i class="fas fa-user-plus me-1"></i> Activar
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>