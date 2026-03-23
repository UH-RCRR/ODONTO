<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$url_base = "/Odonto/public/index.php?c=";
// Simulamos si es edición o creación
$usuario_edit = $usuario_datos ?? null; 
$titulo = $usuario_edit ? "Editar Usuario" : "Nuevo Usuario";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $titulo ?> | Dental UH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
    :root {
        --sb-accent: #0284c7;
        --sb-text: #64748b;
        --bg-body: #f8fafc;
        --sidebar-width: 280px;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
    }

    /* CONTENEDOR AJUSTADO A TU SIDEBAR DE 280PX */
    .main-container-exclusive {
        position: relative;
        margin-left: var(--sidebar-width) !important;
        width: calc(100% - var(--sidebar-width)) !important;
        padding: 40px;
        z-index: 1;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        padding: 35px;
    }

    .btn-back-custom {
        background: white;
        color: var(--sb-text);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 25px;
        transition: all 0.2s;
    }

    .btn-back-custom:hover {
        background: var(--bg-body);
        color: var(--sb-accent);
        border-color: var(--sb-accent);
    }

    .form-label {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .form-control,
    .form-select {
        border-radius: 14px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        font-size: 0.95rem;
        color: #475569;
    }

    .form-control:focus {
        border-color: var(--sb-accent);
        box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #0f172a, var(--sb-accent));
        color: white;
        border-radius: 14px;
        padding: 14px 35px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(2, 132, 199, 0.3);
        color: white;
    }

    .header-icon {
        background: var(--sb-active-bg, #e0f2fe);
        color: var(--sb-accent);
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .main-container-exclusive {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 20px;
        }
    }
    </style>
</head>

<body>

    <?php include_once dirname(__DIR__) . '/layouts/sidebar.php'; ?>

    <div class="main-container-exclusive">

        <a href="<?= $url_base ?>Usuarios" class="btn-back-custom shadow-sm">
            <span class="material-symbols-rounded">arrow_back</span>
            <span>Volver a la lista</span>
        </a>

        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="form-card">
                    <div class="d-flex align-items-center gap-3 mb-5 border-bottom pb-4">
                        <div class="header-icon">
                            <span class="material-symbols-rounded">person_add</span>
                        </div>
                        <div>
                            <h2 class="fw-800 mb-0" style="color: #0f172a; font-weight: 800;"><?= $titulo ?></h2>
                            <p class="text-muted mb-0 small">Asigne los datos personales y el rol correspondiente.</p>
                        </div>
                    </div>

                    <form action="<?= $url_base ?>Usuarios&a=guardar" method="POST" class="row g-4">
                        <input type="hidden" name="id" value="<?= $usuario_edit['id'] ?? '' ?>">

                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Carlos Rivera"
                                value="<?= $usuario_edit['nombre'] ?? '' ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo Institucional</label>
                            <input type="email" name="correo" class="form-control" placeholder="carlos@dentaluh.com"
                                value="<?= $usuario_edit['correo'] ?? '' ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Matrícula / ID</label>
                            <input type="text" name="matricula" class="form-control" placeholder="U002456"
                                value="<?= $usuario_edit['matricula'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol Administrativo</label>
                            <select name="rol_id" class="form-select" required>
                                <option value="" selected disabled>Elija una opción</option>
                                <option value="1"
                                    <?= (isset($usuario_edit['rol_id']) && $usuario_edit['rol_id'] == 1) ? 'selected' : '' ?>>
                                    Administrador</option>
                                <option value="2"
                                    <?= (isset($usuario_edit['rol_id']) && $usuario_edit['rol_id'] == 2) ? 'selected' : '' ?>>
                                    Subadministrador</option>
                            </select>
                            <small class="text-muted text-info">Docentes y Alumnos se gestionan automáticamente por el
                                sistema.</small>
                        </div>

                        <?php if(!$usuario_edit): ?>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña de acceso</label>
                            <div class="input-group">
                                <input type="password" name="password" id="user_pass" class="form-control" required>
                                <button class="btn btn-outline-light border text-secondary" type="button"
                                    onclick="toggleView()">
                                    <span class="material-symbols-rounded" style="font-size: 20px;">visibility</span>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-12 mt-5 pt-3 d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-light px-4 fw-600 rounded-pill">Limpiar</button>
                            <button type="submit" class="btn btn-save px-5">
                                <span class="d-flex align-items-center gap-2">
                                    <span class="material-symbols-rounded">save</span>
                                    Guardar Cambios
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleView() {
        const p = document.getElementById('user_pass');
        p.type = p.type === 'password' ? 'text' : 'password';
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>