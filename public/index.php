<?php

$c = strtolower($_GET['c'] ?? 'login');
$a = $_GET['a'] ?? null;

switch ($c) {

    case 'auth':
        require_once '../app/controllers/AuthController.php';
        $controller = new AuthController();

        if ($a && method_exists($controller, $a)) {
            $controller->$a();
        } else {
            $controller->form();
        }
        break;

    case 'admin':
        require_once '../app/controllers/AdminController.php';
        (new AdminController())->dashboard();
        break;

    // --- AGREGAMOS ESTE NUEVO CASO ---
    case 'subadmin':
        require_once '../app/controllers/SubadminController.php';
        $controller = new SubadminController();
        // Si no hay acción (a), por defecto va al dashboard
        $accion = $a ?? 'dashboard'; 
        if (method_exists($controller, $accion)) {
            $controller->$accion();
        } else {
            $controller->dashboard();
        }
        break;

    case 'dashboard':
        require_once '../app/controllers/DashboardController.php';
        (new DashboardController())->index();
        break;

    case 'usuarios':
        require_once '../app/controllers/UsuariosController.php';
        $controller = new UsuariosController();

        if ($a) {
            switch ($a) {
                case 'nuevo':          $controller->nuevo(); break;
                case 'editar':         $controller->editar(); break;
                case 'guardar':        $controller->guardar(); break;
                case 'cambiarEstado':  $controller->cambiarEstado(); break;
                default:               $controller->index(); break;
            }
        } else {
            $controller->index();
        }
        break;

    case 'asignaciones':
        require_once '../app/controllers/AsignacionesController.php';
        $controller = new AsignacionesController();
        $a = $_GET['a'] ?? 'index';

        switch ($a) {
            case 'individual':        $controller->individual(); break;
            case 'grupal':            $controller->grupal(); break; 
            case 'guardarIndividual': $controller->guardarIndividual(); break;
            case 'guardarGrupo':      $controller->guardarGrupo(); break; 
            default:                  $controller->index(); break;
        }
        break;

   case 'docentes':
        require_once '../app/controllers/DocentesController.php';
        $controller = new DocentesController();
        
        // Obtenemos la acción (a), si no hay, por defecto es dashboard
        $accion = $_GET['a'] ?? 'dashboard';

        // Verificamos si el método existe en el controlador
        if (method_exists($controller, $accion)) {
            $controller->$accion(); // Ejecuta misAlumnos(), exportar(), etc.
        } else {
            // Si la acción no existe, nos manda al dashboard por seguridad
            $controller->dashboard();
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

    case 'login':
    default:
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->form();
        break;
}