<?php
session_start();

require_once __DIR__ . '/../models/Asignacion.php';

class DocentesController {

    /**
     * VER ALUMNOS ASIGNADOS A UN DOCENTE (ADMIN)
     */
   public function alumnos() {

    // Solo ADMIN
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
        header("Location: index.php");
        exit;
    }

    $asignacion = new Asignacion();

    //  Docentes que SÍ tienen alumnos asignados
    $docentes = $asignacion->obtenerDocentesConAsignaciones();

    $alumnos = [];
    if (!empty($_GET['docente'])) {
        $alumnos = $asignacion->obtenerPorDocente($_GET['docente']);
    }

    require_once __DIR__ . '/../views/admin/alumnos_docente.php';
}


    /**
     * VER MIS ALUMNOS (DOCENTE)
     */
    public function misAlumnos() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 2) {
            header("Location: index.php");
            exit;
        }

        $asignacion = new Asignacion();

        $correoDocente = $_SESSION['usuario']['correo'];
        $alumnos = $asignacion->obtenerPorDocente($correoDocente);

        require_once __DIR__ . '/../views/docente/mis_alumnos.php';
    }

    public function exportar() {

    // 🔐 Solo ADMIN
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
        exit('Acceso denegado');
    }

    if (empty($_GET['docente'])) {
        exit('Docente no especificado');
    }

    $docenteId = $_GET['docente'];

    $asignacion = new Asignacion();
    $alumnos = $asignacion->obtenerPorDocenteParaExportar($docenteId);

    if (empty($alumnos)) {
        exit('No hay alumnos para exportar');
    }

    // Nombre del archivo
    $nombreArchivo = 'alumnos_docente_' . date('Ymd_His') . '.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $nombreArchivo);

    $output = fopen('php://output', 'w');

    // Encabezados
    fputcsv($output, [
        'Matrícula',
        'Alumno',
        'Tipo',
        'Fecha asignación',
        'Docente',
        'Correo docente'
    ]);

    // Datos
    foreach ($alumnos as $a) {
        fputcsv($output, [
            $a['alumno_matricula'],
            $a['alumno_nombre'],
            $a['tipo'],
            $a['fecha_asignacion'],
            $a['docente_nombre'],
            $a['docente_correo']
        ]);
    }

    fclose($output);
    exit;
}

}
