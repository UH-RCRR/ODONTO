<?php
session_start();

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/ApiEscolar.php';
require_once __DIR__ . '/../models/Bitacora.php'; 

class AuthController {

    /**
     * Muestra el formulario de login
     */
    public function form() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesa el inicio de sesión
     */
    public function login() {
        // Limpiamos los datos de entrada
        $correoOriginal = trim($_POST['correo'] ?? ''); 
        $password       = $_POST['password'] ?? '';

        // Si los campos están vacíos, regresamos al login con error
        if ($correoOriginal === '' || $password === '') {
            header("Location: index.php?c=auth&a=form&error=1");
            exit;
        }

        $usuarioModel = new Usuario();
        $bitacora     = new Bitacora(); 

        // 1. BUSCAR EN BASE DE DATOS LOCAL
        // Nota: Los docentes ya deben existir aquí (creados al asignarles alumnos)
        $usuario = $usuarioModel->buscarPorCorreo($correoOriginal);

        if ($usuario) {
            // Verificación de contraseña (ajusta a password_verify si usas hashes)
            if ($password !== $usuario['password']) {
                header("Location: index.php?c=auth&a=form&error=1");
                exit;
            }

            // Inicio de sesión exitoso
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id'     => $usuario['id'],
                'correo' => $usuario['correo'],
                'rol_id' => $usuario['rol_id'],
                'nombre' => $usuario['nombre'] ?? 'Usuario'
            ];

            $bitacora->registrar($usuario['id'], 'Autenticación', 'Inicio de sesión');

            // --- REDIRECCIONES SEGÚN ROL ---
            if ($usuario['rol_id'] == 1) {
                header("Location: index.php?c=admin");
            } elseif ($usuario['rol_id'] == 4) {
                header("Location: index.php?c=subadmin&a=dashboard");
            } elseif ($usuario['rol_id'] == 2) {
                header("Location: index.php?c=docentes&a=dashboard");
            } else {
                header("Location: index.php?c=dashboard");
            }
            exit;
        }

        // 2. SI NO EXISTE EN LOCAL → Intento de Registro Automático (Solo para Alumnos)
        $api = new ApiEscolar();
        
        $partes = explode('@', $correoOriginal);
        $nombreUsuario = $partes[0];

        // Lógica: Si el correo tiene más de 3 números, asumimos que es una matrícula de Alumno
        if (preg_match_all('/\d/', $nombreUsuario) > 3) {
            $identificadorParaAPI = preg_replace('/\D/', '', $nombreUsuario);
            
            // Buscamos solo en la API de alumnos
            $alumno = $api->buscarAlumno($identificadorParaAPI);

            if ($alumno) {
                $rolId = 3; // Rol de Alumno
                
                // Creamos el usuario automáticamente en la BD local
                $nuevoId = $usuarioModel->crearUsuario([
                    'correo'   => $correoOriginal,
                    'password' => $password, 
                    'rol_id'   => $rolId,
                    'nombre'   => $alumno['nombre'] ?? 'Alumno API',
                    'matricula'=> $identificadorParaAPI
                ]);

                $_SESSION['usuario'] = [
                    'id'     => $nuevoId,
                    'correo' => $correoOriginal,
                    'rol_id' => $rolId,
                    'nombre' => $alumno['nombre'] ?? 'Alumno API'
                ];

                $bitacora->registrar($nuevoId, 'Autenticación', 'Registro automático via API');
                header("Location: index.php?c=dashboard");
                exit;
            }
        }

        /* * Si el código llega aquí es porque:
         * - El usuario no existe en la BD local.
         * - No es un alumno registrado en la API.
         * - Es un docente que aún no tiene alumnos asignados (y por tanto no tiene cuenta).
         */
        header("Location: index.php?c=auth&a=form&error=1");
        exit;
    }

    /**
     * Muestra la vista de recuperación
     */
    public function recuperar() {
        require_once __DIR__ . '/../views/auth/recuperacionCONTRA.php';
    }

    /**
     * Cierra la sesión
     */
    public function logout() {
        if (isset($_SESSION['usuario']['id'])) {
            $bitacora = new Bitacora();
            $bitacora->registrar($_SESSION['usuario']['id'], 'Autenticación', 'Cierre de sesión');
        }
        
        session_destroy();
        header("Location: index.php?c=auth&a=form");
        exit;
    }
}