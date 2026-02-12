<?php

require_once __DIR__ . '/Database.php';

class Asignacion {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Asignar alumno a docente
     */
    public function asignarAlumno($tipo, $matricula, $nombre, $docenteId) {

        $sql = "
            INSERT INTO asignaciones 
            (tipo, alumno_matricula, alumno_nombre, docente_id)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tipo, $matricula, $nombre, $docenteId]);
    }

    /**
     * Obtener alumnos por correo del docente
     */
 public function obtenerPorDocente($docenteId) {

    $sql = "
        SELECT 
            a.alumno_matricula,
            a.alumno_nombre,
            a.tipo,
            a.fecha_asignacion,
            u.correo AS docente_correo,
            u.nombre AS docente_nombre
        FROM asignaciones a
        INNER JOIN usuarios u ON u.id = a.docente_id
        WHERE a.docente_id = ?
        ORDER BY a.fecha_asignacion DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$docenteId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /**
     * Obtener docentes con asignaciones
     */
  public function obtenerDocentesConAsignaciones() {

    $sql = "
        SELECT DISTINCT 
            u.id,
            u.correo,
            u.nombre
        FROM asignaciones a
        INNER JOIN usuarios u ON u.id = a.docente_id
        ORDER BY u.nombre
    ";

    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


public function obtenerPorDocenteParaExportar($docenteId) {

    $sql = "
        SELECT 
            a.alumno_matricula,
            a.alumno_nombre,
            a.tipo,
            a.fecha_asignacion,
            u.nombre AS docente_nombre,
            u.correo AS docente_correo
        FROM asignaciones a
        INNER JOIN usuarios u ON u.id = a.docente_id
        WHERE a.docente_id = ?
        ORDER BY a.fecha_asignacion DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$docenteId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}