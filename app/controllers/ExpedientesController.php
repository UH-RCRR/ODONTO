<?php
session_start();

require_once __DIR__ . '/../models/Expediente.php';

class ExpedientesController {

    public function index() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/admin/expedientes.php';
    }
}
        