<?php
session_start();

class DashboardController {

    public function index() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
