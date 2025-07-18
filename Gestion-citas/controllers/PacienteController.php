<?php
// Archivo: /Gestion-Citas/controllers/PacienteController.php

require_once __DIR__ . "/../models/Paciente.php";
require_once __DIR__ . "/../models/Usuario.php"; // ✅ IMPORTANTE: Añadido para gestionar perfil
require_once __DIR__ . "/../core/Sesion.php";
require_once __DIR__ ."/../models/ExamenPaciente.php";
class PacienteController {

    private $pacienteModelo;
    private $usuarioModelo; // ✅ Añadido

    public function __construct() {
        $this->pacienteModelo = new Paciente();
        $this->usuarioModelo = new Usuario(); // ✅ Añadido
    }

    /**
     * Mostrar todos los pacientes (solo admin)
     */
    public function index() {
        Sesion::verificarSesionAdmin();

        $pacientes = $this->pacienteModelo->obtenerTodosPacientes();
        require_once __DIR__ . "/../views/pacientes/index.php";
    }

    /**
     * Ver perfil de un paciente por ID (admin)
     */
    public function ver() {
        Sesion::verificarSesionAdmin();

        if (!isset($_GET['id'])) {
            header("Location: index.php?url=paciente/index");
            exit();
        }

        $id = $_GET['id'];
        $paciente = $this->pacienteModelo->obtenerPacientePorId($id);

        if (!$paciente) {
            header("Location: index.php?url=paciente/index");
            exit();
        }

        require_once __DIR__ . "/../views/pacientes/ver.php";
    }

    /**
     * Editar paciente
     */
    public function editar() {
        Sesion::verificarSesionAdmin();

        if (!isset($_GET['id'])) {
            header("Location: index.php?url=paciente/index");
            exit();
        }

        $id = $_GET['id'];
        $paciente = $this->pacienteModelo->obtenerPacientePorId($id);

        if (!$paciente) {
            header("Location: index.php?url=paciente/index");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $telefono = trim($_POST["telefono"]);
            $direccion = trim($_POST["direccion"]);
            $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);

            $this->pacienteModelo->actualizarPaciente($id, $telefono, $direccion, $fecha_nacimiento);

            header("Location: index.php?url=paciente/index");
            exit();
        }

        require_once __DIR__ . "/../views/pacientes/editar.php";
    }

    /**
     * Historial clínico del paciente logueado
     */
    public function historial() {
        Sesion::verificarSesion();
        $paciente_id = $this->pacienteModelo->obtenerPacientePorUsuarioId($_SESSION['usuario_id'])['id'];
        $historial = $this->pacienteModelo->obtenerHistorialClinico($paciente_id);
        require_once __DIR__ . '/../views/pacientes/historial_clinico.php';
    }

    /**
     * Perfil del paciente logueado
     */
    public function perfil() {
        Sesion::verificarSesion();

        $usuario_id = $_SESSION['usuario_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);
            $apellido = trim($_POST["apellido"]);
            $dni = trim($_POST["dni"]);
            $telefono = trim($_POST["telefono"]);
            $direccion = trim($_POST["direccion"]);
            $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
            $email = trim($_POST["email"]);

            try {
                $this->usuarioModelo->actualizarUsuarioPerfil(
                    $usuario_id,
                    $nombre,
                    $apellido,
                    $dni,
                    $email,
                    $telefono,
                    $direccion,
                    $fecha_nacimiento
                );

                $mensaje = "Perfil actualizado correctamente.";
            } catch (Exception $e) {
                $error = "Error al actualizar el perfil: " . $e->getMessage();
            }
        }

        $paciente = $this->usuarioModelo->obtenerUsuarioPorId($usuario_id);
        require_once __DIR__ . "/../views/pacientes/perfil_paciente.php";
    }

    public function dashboard() {
        Sesion::verificarSesionPaciente();

        $paciente_id = $this->pacienteModelo->obtenerPacientePorUsuarioId($_SESSION['usuario_id'])['id'];

        require_once __DIR__ . '/../views/pacientes/dashboard.php';
    }


    /**
     * Eliminar paciente
     */
    public function eliminar() {
        Sesion::verificarSesionAdmin();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->pacienteModelo->eliminarPaciente($id);
        }

        header("Location: index.php?url=paciente/index");
        exit();
    }

    public function descargarResultado()
    {
        if (isset($_GET['id'])) {
            $examen_id = $_GET['id'];
            
            $modelExamen = new ExamenPaciente();
            $archivo = $modelExamen->obtenerResultadoPorExamen($examen_id);
            
            if ($archivo && file_exists("uploads/resultados/" . $archivo['nombre_archivo'])) {
                $ruta = "uploads/resultados/" . $archivo['nombre_archivo'];
                
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $archivo['nombre_archivo'] . '"');
                readfile($ruta);
                exit();
            }
        }
        
        header("Location: index.php?url=paciente/misCitas");
    }
}
?>
