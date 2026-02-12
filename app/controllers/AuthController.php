<?php
session_start();

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/ApiEscolar.php';
require_once __DIR__ . '/../models/Bitacora.php'; // Asegúrate de que el archivo exista

class AuthController {

    public function form() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $correo   = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($correo === '' || $password === '') {
            header("Location: index.php?error=1");
            exit;
        }

        $usuarioModel = new Usuario();
        $bitacora = new Bitacora(); // Instanciamos la bitácora

        // BUSCAR EN BD LOCAL
        $usuario = $usuarioModel->buscarPorCorreo($correo);

        if ($usuario) {
            if (!password_verify($password, $usuario['password'])) {
                header("Location: index.php?error=1");
                exit;
            }

            session_regenerate_id(true);

            $_SESSION['usuario'] = [
                'id'     => $usuario['id'],
                'correo' => $usuario['correo'],
                'rol_id' => $usuario['rol_id']
            ];

            // REGISTRO EN BITÁCORA: Inicio de sesión exitoso
            $bitacora->registrar($usuario['id'], 'Autenticación', 'Inicio de sesión');

            if (in_array($usuario['rol_id'], [1, 4])) {
                header("Location: index.php?c=admin");
            } else {
                header("Location: index.php?c=dashboard");
            }
            exit;
        }

        // NO EXISTE EN LOCAL → BUSCAR EN API
        $api = new ApiEscolar();
        $alumno  = $api->buscarAlumno($correo);
        $docente = $api->buscarDocente($correo);

        if (!$alumno && !$docente) {
            header("Location: index.php?error=1");
            exit;
        }

        $rolId = $alumno ? 3 : 2;

        // Crear usuario y obtener el ID insertado
        $nuevoId = $usuarioModel->crearUsuario(
            $correo,
            password_hash($password, PASSWORD_DEFAULT),
            $rolId
        );

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id'     => $nuevoId, // Importante guardar el ID
            'correo' => $correo,
            'rol_id' => $rolId
        ];

        // REGISTRO EN BITÁCORA: Nuevo usuario creado desde API
        $bitacora->registrar($nuevoId, 'Autenticación', 'Primer inicio de sesión (Registro automático)');

        header("Location: index.php?c=dashboard");
        exit;
    }

    public function logout() {
        if (isset($_SESSION['usuario']['id'])) {
            $bitacora = new Bitacora();
            $bitacora->registrar($_SESSION['usuario']['id'], 'Autenticación', 'Cierre de sesión');
        }
        
        session_destroy();
        header("Location: index.php");
        exit;
    }
} // <--- Aquí termina la clase, ya no hay nada suelto afuera.