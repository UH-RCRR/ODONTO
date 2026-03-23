<?php

require_once __DIR__ . '/Database.php';

class Asignacion {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * ASIGNAR ALUMNO
     * Registra la asignación y asegura que el correo del docente esté presente
     */
    public function asignarAlumno($tipo, $matricula, $nombre, $docenteId, $docenteCorreo) {
        $sql = "INSERT INTO asignaciones (tipo, alumno_matricula, alumno_nombre, docente_id, docente_correo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$tipo, $matricula, $nombre, $docenteId, $docenteCorreo]);
    }

    /**
     * OBTENER POR DOCENTE (Para la vista de tablas)
     */
    public function obtenerPorDocente($docenteId) {
        $sql = "SELECT a.*, u.correo AS docente_correo, u.nombre AS docente_nombre
                FROM asignaciones a
                INNER JOIN usuarios u ON u.id = a.docente_id
                WHERE a.docente_id = ?
                ORDER BY a.fecha_asignacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$docenteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * REPORTES POR FACULTAD (Para el Subadmin)
     * Conexión triple: Asignaciones -> Docentes -> Usuarios
     */
public function obtenerAsignacionesPorFacultad($facultad) {
    try {
        // Consultamos uniendo 'asignaciones' con 'usuarios' 
        // ya que vimos que 'docente_id' (3, 5, 6) apunta a la tabla usuarios
        $sql = "SELECT 
                    a.alumno_matricula, 
                    a.alumno_nombre, 
                    a.tipo, 
                    a.fecha_asignacion,
                    u.nombre as docente_nombre,
                    u.correo as docente_correo
                FROM asignaciones a
                INNER JOIN usuarios u ON a.docente_id = u.id
                ORDER BY u.nombre ASC, a.fecha_asignacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

    /**
     * OBTENER POR DOCENTE PARA EXPORTAR (Individual)
     */
    public function obtenerPorDocenteParaExportar($docenteId) {
        $sql = "SELECT a.*, u.nombre AS docente_nombre, u.correo AS docente_correo
                FROM asignaciones a
                INNER JOIN usuarios u ON u.id = a.docente_id
                WHERE a.docente_id = ?
                ORDER BY a.fecha_asignacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$docenteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * DOCENTES CON ASIGNACIONES (Para el Admin)
     */
    public function obtenerDocentesConAsignaciones() {
        $sql = "SELECT u.id, u.nombre AS docente_nombre, u.correo, COUNT(a.id) AS total_alumnos
                FROM usuarios u
                INNER JOIN asignaciones a ON u.id = a.docente_id
                WHERE u.rol_id = 2
                GROUP BY u.id, u.nombre, u.correo
                ORDER BY u.nombre ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Inserta al docente en la tabla 'docentes' si no existe.
 * Esto es lo que lee el reporte del Subadmin.
 */
public function registrarDocenteBase($nombre, $correo, $facultad) {
    $check = $this->db->prepare("SELECT correo FROM docentes WHERE correo = ?");
    $check->execute([$correo]);

    if ($check->rowCount() == 0) {
        $sql = "INSERT INTO docentes (nombre, correo, facultad) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$nombre, $correo, $facultad]);
    }
    return true;
}
}