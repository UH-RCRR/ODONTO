<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DashboardController {

  public function index() {
    if (!isset($_SESSION['usuario']['rol_id'])) {
        header("Location: index.php?c=auth");
        exit;
    }

    $rol = $_SESSION['usuario']['rol_id'];

    // REDIRECCIÓN DINÁMICA:
    // Si es Subadmin, lo mandamos a su propio controlador
    if ($rol == 4) {
        header("Location: index.php?c=subadmin&a=dashboard");
        exit;
    }

    // Si es Docente, a su lista de alumnos
    if ($rol == 2) {
        header("Location: index.php?c=docentes&a=alumnos");
        exit;
    }

    // Solo el Admin (Rol 1) llega aquí abajo
    $data = [
        'usuarios'   => $_SESSION['total_usuarios'] ?? 0,
        'alumnos'    => $_SESSION['total_alumnos'] ?? 0,
        'docentes'   => $_SESSION['total_docentes'] ?? 0,
        'pendientes' => $_SESSION['total_pendientes'] ?? 0
    ];

    $view = __DIR__ . '/../views/admin/dashboard.php';
    require_once __DIR__ . '/../views/layouts/app.php';
}
}