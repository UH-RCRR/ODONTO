<?php

class SubadminController {
    private $usuarioModel;
    private $asignacionModel;

    public function __construct() {
        // Evitamos error de sesión ya iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificamos que sea Subadmin (Rol 4 según image_eab7dc.png)
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 4) {
            header("Location: index.php?c=auth&a=login");
            exit;
        }
        
        // --- CORRECCIÓN DE RUTAS CON __DIR__ ---
        require_once __DIR__ . '/../models/Usuario.php';
        require_once __DIR__ . '/../models/Asignacion.php';
        require_once __DIR__ . '/../models/Expediente.php';
        
        $this->usuarioModel = new Usuario();
        $this->asignacionModel = new Asignacion();
    }

    public function dashboard() {
        // Obtenemos métricas para los reportes
        $data['total_alumnos'] = $this->usuarioModel->totalAlumnos();
        $data['total_docentes'] = $this->usuarioModel->totalDocentes();
        $data['asignaciones_recientes'] = $this->asignacionModel->obtenerDocentesConAsignaciones();
        
        require_once __DIR__ . '/../views/subadmin/dashboard.php';
    }

    public function expedientes() {
    // 1. Instanciamos el modelo de Expediente (asegúrate de haberlo requerido al inicio del archivo)
    // require_once __DIR__ . '/../models/Expediente.php';
    $this->expedienteModel = new Expediente();

    // 2. Cambiamos la llamada para usar el modelo correcto y el método que sí existe
    // El Subadmin ahora jala los datos de la tabla 'expedientes' que viste en phpMyAdmin
    $data['alumnos'] = $this->expedienteModel->listarTodo(); 

    // 3. Cargamos la vista
    require_once __DIR__ . '/../views/subadmin/expedientes.php';
}

    public function vincular() {
    // 1. Cargamos la API para que aparezcan los docentes en el select
    require_once __DIR__ . '/../models/ApiEscolar.php';
    $api = new ApiEscolar();
    
    $docentes = $api->obtenerDocentesPorFacultad('CIENCIAS DE LA SALUD') ?: [];
    $alumnos = [];

    // 2. Lógica para el buscador de alumnos
    if (!empty($_GET['buscar'])) {
        $res = $api->buscarAlumnosAEBR($_GET['buscar']);
        $alumnos = $res['alumnos'] ?? (is_array($res) ? $res : []);
    }

    // 3. Cargamos la vista de vinculación
    // NOTA: Asegúrate de copiar el archivo asignaciones.php de la carpeta admin 
    // a la carpeta views/subadmin/vincular.php
    require_once __DIR__ . '/../views/subadmin/vincular.php';
}
public function reporteDocentes() {
    // 1. Verificamos que sea subadmin
    if ($_SESSION['usuario']['rol_id'] != 4) {
        header("Location: index.php?c=auth");
        exit;
    }

    // 2. Importamos el controlador de docentes para reutilizar su lógica de PDF
    require_once __DIR__ . '/DocentesController.php';
    $docController = new DocentesController();
    
    // 3. Ejecutamos la exportación
    $docController->exportar();
}
}