<?php
session_start();

require_once __DIR__ . '/../models/Usuario.php';

class UsuariosController {

    public function index() {

        //Seguridad
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarUsuarios();

        require_once __DIR__ . '/../views/admin/usuarios.php';
    }

    public function cambiarEstado() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        $id     = $_POST['id'] ?? null;
        $estado = $_POST['estado'] ?? null;

        if ($id === null || $estado === null) {
            header("Location: index.php?c=usuarios");
            exit;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->cambiarEstado($id, $estado);

        header("Location: index.php?c=usuarios");
        exit;
    }
}
