<?php
// Archivo: /Gestion-Citas/controllers/UsuarioController.php

require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Paciente.php";
require_once __DIR__ . "/../core/Sesion.php";

class UsuarioController {

    private $usuarioModelo;
    private $pacienteModelo;

    public function __construct() {
        $this->usuarioModelo = new Usuario();
        $this->pacienteModelo = new Paciente();
    }

    /**
     * Mostrar login
     */
    public function index() {
        require_once __DIR__ . "/../views/login.php";
    }

    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            $usuario = $this->usuarioModelo->obtenerUsuarioPorEmail($email);

            if ($usuario && $password == $usuario['password']) { // SIN HASH
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
                $_SESSION['usuario_rol'] = $usuario['rol_id'];
                
                // Redirigir según el rol
                switch ($_SESSION['usuario_rol']) {
                    case 1: // Admin
                        header("Location: index.php?url=admin/dashboard");
                        break;
                    case 2: // Médico
                        header("Location: index.php?url=medico/dashboard");
                        break;
                    case 3: // Enfermera
                        header("Location: index.php?url=enfermera/dashboard");
                        break;
                    case 4: // Recepcionista
                        header("Location: index.php?url=recepcionista/dashboard");
                        break;
                    case 5: // Paciente
                        header("Location: index.php?url=paciente/dashboard");
                        break;
                    case 6: //Especialista de Exámenes
                        header("Location: index.php?url=especial_examenes/dashboard");
                        break;
                    default:
                        header("Location: index.php?url=usuario/index");
                        break;
                }
                exit();
            } else {
                $error = "Credenciales incorrectas.";
                require_once __DIR__ . "/../views/login.php";
            }
        } else {
            require_once __DIR__ . "/../views/login.php";
        }
    }


    /**
     * Dashboard provisional
     */
    public function dashboard() {
        Sesion::verificarSesion();

        echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h2>";
        echo "<p>Rol ID: " . htmlspecialchars($_SESSION['usuario_rol']) . "</p>";
        echo "<a href='index.php?url=usuario/logout'>Cerrar sesión</a>";
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?url=usuario/index");
        exit();
    }

    /**
     * Registro de usuarios (solo pacientes)
     */
    public function registro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);
            $apellido = trim($_POST["apellido"]);
            $dni = trim($_POST["dni"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $confirmar_password = $_POST["confirmar_password"];
            $telefono = trim($_POST["telefono"]);
            $direccion = trim($_POST["direccion"]);
            $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);

            // Validaciones
            if ($password !== $confirmar_password) {
                $error = "Las contraseñas no coinciden.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Correo electrónico inválido.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            if (!preg_match('/^\d{8}$/', $dni)) {
                $error = "El DNI debe tener 8 dígitos.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            if (!preg_match('/^\d{9}$/', $telefono)) {
                $error = "El número de teléfono debe tener 9 dígitos.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            // Rol de paciente por defecto
            $rol_id = 5; // Si en tu tabla roles el id 5 es paciente

            // Validar duplicados
            if ($this->usuarioModelo->obtenerUsuarioPorEmail($email)) {
                $error = "El correo ya está registrado.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            if ($this->usuarioModelo->obtenerUsuarioPorDni($dni)) {
                $error = "El DNI ya está registrado.";
                require_once __DIR__ . "/../views/registro.php";
                return;
            }

            // Registrar usuario y obtener id
            $usuario_id = $this->usuarioModelo->registrarUsuario(
                $nombre,
                $apellido,
                $dni,
                $email,
                $password,
                $telefono,
                $direccion,
                $fecha_nacimiento,
                $rol_id
            );

            // Registrar en tabla paciente
            $this->pacienteModelo->crearPaciente($usuario_id);

            $exito = "Registro exitoso. Ahora puede iniciar sesión.";
            require_once __DIR__ . "/../views/registro.php";

        } else {
            require_once __DIR__ . "/../views/registro.php";
        }
    }
}
?>
