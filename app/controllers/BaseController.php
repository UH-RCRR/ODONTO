<?php

class BaseController {

    protected function render($view, $data = []) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Extraer variables para usarlas en la vista
        extract($data);

        // Ruta de la vista
        $view = __DIR__ . '/../views/' . $view . '.php';

        // Cargar layout
        require_once __DIR__ . '/../views/layouts/app.php';
    }
}