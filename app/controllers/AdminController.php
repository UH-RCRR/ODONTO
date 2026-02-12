<?php
session_start();

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/SolicitudExpediente.php';

class AdminController {

    public function dashboard() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        $usuarioModel = new Usuario();
        $solicitudModel = new SolicitudExpediente();

        $data = [
            'usuarios'   => $usuarioModel->totalUsuarios(),
            'alumnos'    => $usuarioModel->totalAlumnos(),
            'docentes'   => $usuarioModel->totalDocentes(),
            'pendientes' => $solicitudModel->pendientes()
        ];

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}
