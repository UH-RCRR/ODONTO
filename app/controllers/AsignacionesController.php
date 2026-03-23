<?php
session_start();

require_once __DIR__ . '/../models/ApiEscolar.php';
require_once __DIR__ . '/../models/Asignacion.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Bitacora.php';

class AsignacionesController {

   private function verificarAdmin() {
    // Permitimos entrar si es Admin (1) O Subadmin (4)
    if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['rol_id'] != 1 && $_SESSION['usuario']['rol_id'] != 4)) {
        header("Location: index.php?c=auth");
        exit;
    }
}

    public function index() {
        $this->verificarAdmin();
        header("Location: index.php?c=asignaciones&a=individual");
        exit;
    }

    /**
     * ASIGNACIÓN INDIVIDUAL
     */
    public function individual() {
        $this->verificarAdmin();
        $api = new ApiEscolar();
        $alumnos = [];
        $docentes = [];

        $docRes = $api->obtenerDocentesPorFacultad('CIENCIAS DE LA SALUD');
        if (is_array($docRes)) { $docentes = $docRes; }

        if (!empty($_GET['buscar'])) {
            $res = $api->buscarAlumnosAEBR($_GET['buscar']);
            // Ajuste según estructura real de tu API
            $alumnos = (isset($res['alumnos'])) ? $res['alumnos'] : (is_array($res) ? $res : []);
        }

        require_once __DIR__ . '/../views/admin/asignaciones.php';
    }

    /**
     * ASIGNACIÓN GRUPAL (NUEVA)
     */
    public function grupal() {
        $this->verificarAdmin();
        $api = new ApiEscolar();
        $alumnos = [];
        $docentes = [];

        $docRes = $api->obtenerDocentesPorFacultad('CIENCIAS DE LA SALUD');
        if (is_array($docRes)) { $docentes = $docRes; }

        if (!empty($_GET['grupo'])) {
            // Usamos la nueva función que añadimos al modelo ApiEscolar
            $alumnos = $api->obtenerAlumnosPorGrupo($_GET['grupo']);
        }

        require_once __DIR__ . '/../views/admin/asignar_grupo.php';
    }

    /**
     * GUARDAR ASIGNACIÓN INDIVIDUAL
     */
    public function guardarIndividual() {
        $this->verificarAdmin();

        if (empty($_POST['matricula']) || empty($_POST['docente_correo'])) {
            header("Location: index.php?c=asignaciones&a=individual&error=datos");
            exit;
        }

        $usuarioModel = new Usuario();
        $asignacion   = new Asignacion();
        $bitacora     = new Bitacora();

        $docenteId = $usuarioModel->obtenerOCrearDocente($_POST['docente_correo'], $_POST['docente_nombre']);

        $asignacion->asignarAlumno('INDIVIDUAL', trim($_POST['matricula']), trim($_POST['nombre']), $docenteId);

        $bitacora->registrar($_SESSION['usuario']['id'], 'Asignaciones', 'Asignó alumno ' . $_POST['matricula'] . ' al docente ' . $_POST['docente_nombre']);

        header("Location: index.php?c=asignaciones&a=individual&ok=1");
        exit;
    }

    
 /**
 * GUARDAR ASIGNACIÓN GRUPO COMPLETO
 * Procesa el array de alumnos seleccionados y los vincula a un docente
 */
public function guardarGrupal() {
    $this->verificarAdmin();

    // 1. Validamos que existan los datos del docente
    if (empty($_POST['docente_correo'])) {
        die("Error: No se seleccionó un docente.");
    }

    $usuarioModel = new Usuario();
    $asignacion   = new Asignacion();

    // 2. Aseguramos que el docente exista y nos de un ID
    $docenteCorreo = $_POST['docente_correo'];
    $docenteNombre = $_POST['docente_nombre'] ?? 'Docente Genérico';
    $docenteId = $usuarioModel->obtenerOCrearDocente($docenteCorreo, $docenteNombre);

    if (!$docenteId) {
        die("Error Crítico: No se pudo obtener el ID del docente en la base de datos.");
    }

    $exitos = 0;
    if (!empty($_POST['alumnos']) && is_array($_POST['alumnos'])) {
        foreach ($_POST['alumnos'] as $alumnoJson) {
            $alumno = json_decode($alumnoJson, true);
            if ($alumno) {
                // Sincronización exacta con los datos de la API (image_c49d7d.png)
                $matricula = $alumno['matricula'] ?? null;
                $nombre    = $alumno['nombreAlumno'] ?? null; // llave exacta de tu API

                if ($matricula && $nombre) {
                    // 3. Ejecutamos el guardado
                    $res = $asignacion->asignarAlumno('GRUPAL', $matricula, $nombre, $docenteId);
                    if ($res) $exitos++;
                }
            }
        }
    }

    header("Location: index.php?c=asignaciones&a=grupal&ok=1&total=" . $exitos);
    exit;
}

public function guardar() {
    // 1. Recibir datos del formulario
    $tipo = $_POST['tipo'];
    $matricula = $_POST['matricula'];
    $nombreAlumno = $_POST['nombre_alumno'];
    $nombreDocente = $_POST['nombre_docente'];
    $correoDocente = $_POST['correo_docente'];

    $asignacionModel = new Asignacion();
    $usuarioModel = new Usuario(); // Necesitarás este modelo

    try {
        // 2. ASEGURAR QUE EL DOCENTE EXISTA COMO USUARIO (ROL 2)
        // Buscamos si ya existe por correo
        $usuario = $usuarioModel->obtenerPorCorreo($correoDocente);
        
        if (!$usuario) {
            // Si no existe, lo creamos automáticamente
            $idDocente = $usuarioModel->crear([
                'nombre' => $nombreDocente,
                'correo' => $correoDocente,
                'password' => password_hash($matricula, PASSWORD_DEFAULT), // Pass inicial: matrícula del alumno
                'rol_id' => 2
            ]);
            
            // 3. REGISTRAR EN LA TABLA 'DOCENTES' (Para que el Subadmin tenga facultad)
            $asignacionModel->registrarDocenteBase($nombreDocente, $correoDocente, 'CIENCIAS DE LA SALUD');
        } else {
            $idDocente = $usuario['id'];
        }

        // 4. GUARDAR LA ASIGNACIÓN FINAL
        $asignacionModel->asignarAlumno($tipo, $matricula, $nombreAlumno, $idDocente, $correoDocente);

        header("Location: index.php?c=asignaciones&a=exito");
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
}