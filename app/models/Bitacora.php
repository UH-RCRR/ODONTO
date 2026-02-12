<?php

class Bitacora {

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

    public function registrar($usuario, $modulo, $accion) {

        $sql = "
            INSERT INTO bitacora
            (usuario_id, usuario_correo, rol, modulo, accion, ip)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $usuario['id'] ?? null,
            $usuario['correo'] ?? 'SISTEMA',
            $usuario['rol'] ?? 'SISTEMA',
            $modulo,
            $accion,
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    }

    public function listar($limit = 100) {

        $stmt = $this->db->prepare(
            "SELECT * FROM bitacora
             ORDER BY created_at DESC
             LIMIT ?"
        );

        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
