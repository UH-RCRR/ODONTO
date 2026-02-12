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
}
