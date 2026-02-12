<?php

$c = $_GET['c'] ?? 'login';
$a = $_GET['a'] ?? null;

switch ($c) {

    /* ===================== AUTH ===================== */
    case 'auth':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController();

        if ($a && method_exists($controller, $a)) {
            $controller->$a();
        } else {
            $controller->form();
        }
        break;

    /* ===================== ADMIN ===================== */
    case 'admin':
        require_once '../app/controllers/AdminController.php';
        (new AdminController())->dashboard();
        break;

    /* ===================== DASHBOARD ===================== */
    case 'dashboard':
        require_once '../app/controllers/DashboardController.php';
        (new DashboardController())->index();
        break;

    /* ===================== USUARIOS ===================== */
    case 'usuarios':
        require_once '../app/controllers/UsuariosController.php';
        $controller = new UsuariosController();

        if ($a === 'cambiarEstado') {
            $controller->cambiarEstado();
        } else {
            $controller->index();
        }
        break;

    /* ===================== ASIGNACIONES ===================== */
    case 'asignaciones':
        require_once '../app/controllers/AsignacionesController.php';
        $controller = new AsignacionesController();

        if ($a) {
            switch ($a) {

                case 'individual':
                    $controller->individual();
                    break;

                case 'guardarIndividual':
                    $controller->guardarIndividual();
                    break;

                case 'guardarGrupo':
                    $controller->guardarGrupo();
                    break;

                default:
                    $controller->index();
                    break;
            }
        } else {
            $controller->index();
        }
        break;


        case 'docentes':
    require_once '../app/controllers/DocentesController.php';
    $controller = new DocentesController();

    $accion = $_GET['a'] ?? 'alumnos';

    switch ($accion) {

        case 'misAlumnos':
            $controller->misAlumnos();
            break;

        case 'exportar':
            $controller->exportar();
            break;

        case 'alumnos':
        default:
            $controller->alumnos();
            break;
    }

    break;

    case 'expedientes':
    require_once '../app/controllers/ExpedientesController.php';
    (new ExpedientesController())->index();
    break;


    case 'bitacora':
    require_once '../app/controllers/BitacoraController.php';
    (new BitacoraController())->index();
    break;





    /* ===================== LOGIN POR DEFECTO ===================== */
    case 'login':
    default:
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->form();
        break;
}