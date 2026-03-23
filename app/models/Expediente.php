<?php

require_once __DIR__ . '/Database.php';

class Expediente {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function obtenerOCrear($matricula, $nombre) {

        $stmt = $this->db->prepare(
            "SELECT * FROM expedientes WHERE alumno_matricula = ? LIMIT 1"
        );
        $stmt->execute([$matricula]);
        $expediente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($expediente) {
            return $expediente;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO expedientes (alumno_matricula, alumno_nombre)
             VALUES (?, ?)"
        );
        $stmt->execute([$matricula, $nombre]);

        return [
            'id' => $this->db->lastInsertId(),
            'alumno_matricula' => $matricula,
            'alumno_nombre' => $nombre
        ];
    }

    public function obtenerConsultas($expedienteId) {

        $stmt = $this->db->prepare(
            "SELECT c.*, u.nombre AS docente_nombre
             FROM consultas_clinicas c
             INNER JOIN usuarios u ON u.id = c.docente_id
             WHERE expediente_id = ?
             ORDER BY fecha_consulta DESC"
        );
        $stmt->execute([$expedienteId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarConsulta($expedienteId, $docenteId, $data) {

        $stmt = $this->db->prepare(
            "INSERT INTO consultas_clinicas
            (expediente_id, docente_id, motivo_consulta, diagnostico, tratamiento, observaciones)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        return $stmt->execute([
            $expedienteId,
            $docenteId,
            $data['motivo'],
            $data['diagnostico'],
            $data['tratamiento'],
            $data['observaciones']
        ]);
    }

    /**
     * LISTAR TODO (Para Administradores)
     * Obtiene todos los expedientes de la tabla con el nombre del alumno
     */
    public function listarTodo() {
        try {
            // Unimos con la tabla usuarios si necesitas el nombre real del alumno desde ahí, 
            // o usamos los campos de la tabla expedientes directamente.
            $sql = "SELECT * FROM expedientes ORDER BY fecha_apertura DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * OBTENER REPORTE DETALLADO
     * Para visualizar el estado de salud y consultas en los reportes
     */
    public function obtenerReporteGlobal() {
        $sql = "SELECT e.*, 
                COUNT(c.id) as total_consultas
                FROM expedientes e
                LEFT JOIN consultas_clinicas c ON e.id = c.expediente_id
                GROUP BY e.id
                ORDER BY e.fecha_apertura DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
