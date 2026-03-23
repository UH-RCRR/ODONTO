<?php
session_start();

require_once __DIR__ . '/../models/Expediente.php';

class ExpedientesController {

    private $expedienteModel;

    public function __construct() {
        // Instanciamos el modelo para poder usar sus métodos
        $this->expedienteModel = new Expediente();
    }

    public function index() {
        // 1. Verificación de sesión
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        // 2. OBTENER LOS DATOS: Llamamos al método que creamos en el modelo
        // Esto es lo que permite que el Administrador VEA los expedientes
        $expedientes = $this->expedienteModel->listarTodo();

        // 3. Cargar la vista y pasarle la variable $expedientes
        require_once __DIR__ . '/../views/admin/expedientes.php';
    }
}