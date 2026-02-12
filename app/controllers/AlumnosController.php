<?php
session_start();
require_once __DIR__ . '/../models/ApiEscolar.php';

class AlumnosController {

    public function porGrupo() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?c=login");
            exit;
        }

        $alumnos = [];
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $claveGrupo = $_POST['claveGrupo'];

            $api = new ApiEscolar();
            $respuesta = $api->obtenerAlumnosPorGrupo($claveGrupo);

            if (!$respuesta['error']) {
                $alumnos = $respuesta['alumnos'];
            } else {
                $error = $respuesta['descripcion'];
            }
        }

        require_once __DIR__ . '/../views/alumnos/por_grupo.php';
    }
}
