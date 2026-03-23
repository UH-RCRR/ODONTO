<?php

class Usuario {

    private $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';

        $this->db = new PDO(
            "mysql:host={$config['host']};dbname={$config['db']};charset=utf8",
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    /* =====================
       LOGIN
    ===================== */
    public function buscarPorCorreo($correo) {
        $stmt = $this->db->prepare(
            "SELECT * FROM usuarios WHERE correo = ? AND activo = 1 LIMIT 1"
        );
        $stmt->execute([$correo]);
        return $stmt->fetch();
    }

    /* =====================
       MÉTRICAS ADMIN
    ===================== */
    public function totalUsuarios() {
        return $this->db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }

    public function totalAlumnos() {
        return $this->db->query(
            "SELECT COUNT(*) FROM usuarios WHERE rol_id = 3"
        )->fetchColumn();
    }

    public function totalDocentes() {
        return $this->db->query(
            "SELECT COUNT(*) FROM usuarios WHERE rol_id = 2"
        )->fetchColumn();
    }

    /* =====================
       LISTAR USUARIOS
    ===================== */
    public function listarUsuarios() {
        $sql = "
            SELECT 
                u.id,
                u.nombre,
                u.correo,
                u.activo,
                r.nombre AS rol
            FROM usuarios u
            INNER JOIN roles r ON r.id = u.rol_id
            WHERE u.rol_id IN (2,4)
            ORDER BY r.nombre, u.correo
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /* =====================
       DOCENTE (API → LOCAL)
    ===================== */
    public function obtenerOCrearDocente($correo, $nombre) {

        // Buscar por correo
        $stmt = $this->db->prepare(
            "SELECT id FROM usuarios WHERE correo = ? LIMIT 1"
        );
        $stmt->execute([$correo]);
        $docente = $stmt->fetch();

        // Si existe, regresamos su ID
        if ($docente) {
            return $docente['id'];
        }

        // --- CORRECCIÓN AQUÍ ---
        // Si NO existe, lo creamos con contraseña en TEXTO PLANO
        $passwordTemporal = 'Docente123'; 

        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, correo, password, rol_id, activo)
             VALUES (?, ?, ?, 2, 1)"
        );

        $stmt->execute([
            $nombre,
            $correo,
            $passwordTemporal
        ]);

        return $this->db->lastInsertId();
    }

    public function cambiarEstado($id, $estado) {
        $stmt = $this->db->prepare(
            "UPDATE usuarios 
             SET activo = ? 
             WHERE id = ?"
        );
        return $stmt->execute([$estado, $id]);
    }


    public function buscarPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario (Subadmin, Docente o Alumno)
     */
    public function crearUsuario($data) {
        // Se inserta el password tal cual viene en el array $data
        $sql = "INSERT INTO usuarios (nombre, correo, matricula, rol_id, password, activo) 
                VALUES (:nombre, :correo, :matricula, :rol_id, :password, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nombre'    => $data['nombre'],
            'correo'    => $data['correo'],
            'matricula' => $data['matricula'] ?? null,
            'rol_id'    => $data['rol_id'],
            'password'  => $data['password'] // TEXTO PLANO
        ]);
    }

    /**
     * Actualiza los datos de un usuario existente
     */
    public function actualizarUsuario($data) {
        $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, 
                matricula = :matricula, rol_id = :rol_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nombre'    => $data['nombre'],
            'correo'    => $data['correo'],
            'matricula' => $data['matricula'],
            'rol_id'    => $data['rol_id'],
            'id'        => $data['id']
        ]);
    }
}