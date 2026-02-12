<?php

class ApiEscolar {

    private $endpointAlumnos;
    private $endpointDocentes;
    private $user;
    private $password;

    public function __construct() {

        $config = require __DIR__ . '/../../config/api.php';

        $this->endpointAlumnos  = $config['endpoint_alumnos_aebr'];
        $this->endpointDocentes = $config['endpoint_docentes'];
        $this->user             = $config['user'];
        $this->password         = $config['password'];
    }

    /**
     * Buscar alumnos (nombre, matrícula, grupo, etc.)
     */
    public function buscarAlumnosAEBR($cadenaAlumno) {

        $payload = json_encode([
            'cadenaAlumno' => $cadenaAlumno
        ]);

        $ch = curl_init($this->endpointAlumnos);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_USERPWD        => $this->user . ':' . $this->password,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: */*'
            ],
            CURLOPT_TIMEOUT        => 20
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return [];
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Obtener TODOS los docentes de la facultad
     */
    public function obtenerDocentesPorFacultad($facultad) {

        $payload = json_encode([
            'facultad' => $facultad
        ]);

        $ch = curl_init($this->endpointDocentes);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_USERPWD        => $this->user . ':' . $this->password,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: */*'
            ],
            CURLOPT_TIMEOUT        => 20
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return [];
        }

        curl_close($ch);
        $data = json_decode($response, true);

        return $data[0]['docentes'] ?? [];
    }
}
