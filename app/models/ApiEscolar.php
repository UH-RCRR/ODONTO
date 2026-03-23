<?php

class ApiEscolar {

    private $endpointAlumnos;
    private $endpointDocentes;
    private $endpointGrupos; // Nueva variable para grupos
    private $user;
    private $password;

    public function __construct() {
        $config = require __DIR__ . '/../../config/api.php';

        $this->endpointAlumnos  = $config['endpoint_alumnos_aebr'];
        $this->endpointDocentes = $config['endpoint_docentes'];
        // Asegúrate de que esta llave exista en tu config/api.php
        $this->endpointGrupos   = $config['endpoint_grupos'] ?? 'https://www.mi-escuelamx.com/UHIPOCRATESAPI/api/AlumnoPorGrupo';
        
        $this->user             = $config['user'];
        $this->password         = $config['password'];
    }

    /**
     * BUSCAR ALUMNOS POR GRUPO (NUEVA FUNCIÓN)
     */
public function obtenerAlumnosPorGrupo($claveGrupo) {
    // 1. Definir el payload
    $payload = json_encode(['claveGrupo' => $claveGrupo]);

    // 2. INICIALIZAR EL MANEJADOR (Aquí estaba el error)
    $ch = curl_init($this->endpointGrupos); 

    // 3. Configurar opciones
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

    // 4. Ejecutar y cerrar
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return [];
    }

    curl_close($ch);

    // 5. Decodificar y extraer según tu imagen de Insomnia
    $data = json_decode($response, true);

    // Accedemos a [0]['alumnosGrupo'] como vimos en image_c49d7d.png
    if (isset($data[0]['alumnosGrupo'])) {
        return $data[0]['alumnosGrupo'];
    }

    return [];
}

    /**
     * Buscar alumnos (nombre, matrícula, etc.) - YA FUNCIONA
     */
    public function buscarAlumnosAEBR($cadenaAlumno) {
        $payload = json_encode(['cadenaAlumno' => $cadenaAlumno]);
        $ch = curl_init($this->endpointAlumnos);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_USERPWD        => $this->user . ':' . $this->password,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Accept: */*'],
            CURLOPT_TIMEOUT        => 20
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Obtener docentes - YA FUNCIONA
     */
    public function obtenerDocentesPorFacultad($facultad) {
        $payload = json_encode(['facultad' => $facultad]);
        $ch = curl_init($this->endpointDocentes);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_USERPWD        => $this->user . ':' . $this->password,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Accept: */*'],
            CURLOPT_TIMEOUT        => 20
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        return $data[0]['docentes'] ?? [];
    }
}