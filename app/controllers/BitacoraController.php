<?php
session_start();

require_once __DIR__ . '/../models/Bitacora.php';

class BitacoraController {

    public function index() {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 1) {
            header("Location: index.php");
            exit;
        }

        $bitacora = new Bitacora();
        $registros = $bitacora->listar(200);

        require_once __DIR__ . '/../views/admin/bitacora.php';
    }
}
