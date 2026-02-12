<?php

class SolicitudExpediente {

    private $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';

        $this->db = new PDO(
            "mysql:host={$config['host']};dbname={$config['db']};charset=utf8",
            $config['user'],
            $config['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function pendientes() {
        return $this->db->query(
            "SELECT COUNT(*) FROM solicitudes_expediente WHERE estado = 'PENDIENTE'"
        )->fetchColumn();
    }
}
