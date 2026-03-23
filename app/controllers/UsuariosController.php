<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

class UsuariosController {

    private function verificarAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php"); exit;
        }
    }

    public function index() {
        $this->verificarAdmin();
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarUsuarios();
        require_once __DIR__ . '/../views/admin/usuarios.php';
    }

    public function nuevo() {
        $this->verificarAdmin();
        $titulo = "Nuevo Personal Administrativo";
        require_once __DIR__ . '/../views/admin/usuario_perfil.php';
    }

    public function editar() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        $usuarioModel = new Usuario();
        $usuario_datos = $usuarioModel->buscarPorId($id);
        $titulo = "Editar Usuario";
        require_once __DIR__ . '/../views/admin/usuario_perfil.php';
    }

    public function guardar() {
        $this->verificarAdmin();
        $usuarioModel = new Usuario();

        $data = [
            'id'        => $_POST['id'] ?? null,
            'nombre'    => $_POST['nombre'],
            'correo'    => $_POST['correo'],
            'matricula' => $_POST['matricula'],
            'rol_id'    => $_POST['rol_id'], // Solo 1 o 2
        ];

        if ($data['id']) {
            $usuarioModel->actualizarUsuario($data);
        } else {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $usuarioModel->crearUsuario($data);
        }

        header("Location: index.php?c=usuarios");
        exit;
    }

    public function cambiarEstado() {
        $this->verificarAdmin();
        $id = $_POST['id'] ?? null;
        $estado = $_POST['estado'] ?? null;
        if ($id !== null) {
            $usuarioModel = new Usuario();
            $usuarioModel->cambiarEstado($id, $estado);
        }
        header("Location: index.php?c=usuarios");
        exit;
    }
}