<?php
session_start();

require_once __DIR__ . '/../models/ApiEscolar.php';
require_once __DIR__ . '/../models/Asignacion.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Bitacora.php'; // <--- Añadido el modelo de bitácora

class AsignacionesController {

    /**
     * PANTALLA PRINCIPAL DE ASIGNACIONES
     */
    public function index() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        header("Location: index.php?c=asignaciones&a=individual");
        exit;
    }

    /**
     * ASIGNACIÓN INDIVIDUAL (VISTA)
     */
    public function individual() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        $api = new ApiEscolar();
        $alumnos  = [];
        $docentes = [];

        $docRes = $api->obtenerDocentesPorFacultad('CIENCIAS DE LA SALUD');
        if (is_array($docRes)) {
            $docentes = $docRes;
        }

        if (!empty($_GET['buscar'])) {
            $res = $api->buscarAlumnosAEBR($_GET['buscar']);
            $alumnos = $res['alumnos'] ?? [];
        }

        require_once __DIR__ . '/../views/admin/asignaciones.php';
    }

    /**
     * GUARDAR ASIGNACIÓN INDIVIDUAL
     */
    public function guardarIndividual() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        // Validación de datos POST
        if (
            empty($_POST['matricula']) ||
            empty($_POST['nombre']) ||
            empty($_POST['docente_correo']) ||
            empty($_POST['docente_nombre'])
        ) {
            header("Location: index.php?c=asignaciones&a=individual&error=datos");
            exit;
        }

        $usuarioModel = new Usuario();
        $asignacion   = new Asignacion();
        $bitacora     = new Bitacora(); // <--- Instanciado dentro del método

        // Obtener o crear el docente
        $docenteId = $usuarioModel->obtenerOCrearDocente(
            $_POST['docente_correo'],
            $_POST['docente_nombre']
        );

        // Guardar asignación en la base de datos
        $resultado = $asignacion->asignarAlumno(
            'INDIVIDUAL',
            trim($_POST['matricula']),
            trim($_POST['nombre']),
            $docenteId
        );

        // REGISTRO EN BITÁCORA: Solo si la asignación fue exitosa
        $bitacora->registrar(
            $_SESSION['usuario']['id'], 
            'Asignaciones', 
            'Asignó alumno ' . $_POST['matricula'] . ' al docente ' . $_POST['docente_nombre']
        );

        header("Location: index.php?c=asignaciones&a=individual&ok=1");
        exit;
    }

} // <--- Cierre correcto de la clase