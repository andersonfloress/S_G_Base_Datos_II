<?php
// Archivo: /Gestion-Citas/controllers/RecepcionistaController.php

require_once __DIR__ . '/../models/Recepcionista.php';
require_once __DIR__ . '/../models/Medico.php';
require_once __DIR__ . '/../models/Especialidad.php';
require_once __DIR__ . '/../core/Sesion.php';

class RecepcionistaController {

    private $recepcionistaModelo;
    private $medicoModelo;
    private $especialidadModelo;

    public function __construct() {
        $this->recepcionistaModelo = new Recepcionista();
        $this->medicoModelo = new Medico();
        $this->especialidadModelo = new Especialidad();
    }

    /**
     * Dashboard del recepcionista
     */
    public function dashboard() {
        Sesion::verificarSesionRecepcionista();
        require_once __DIR__ . '/../views/recepcionista/dashboard.php';
    }

    /**
 * Registrar nueva cita (método simplificado)
    */
    public function registrar_cita() {
        Sesion::verificarSesionRecepcionista();

        require_once __DIR__ . '/../models/Cita.php';
        require_once __DIR__ . '/../models/Paciente.php';
        
        $citaModelo = new Cita();
        $pacienteModelo = new Paciente();
        
        $paciente = null;
        $exito = null;
        $error = null;

        $medicos = $this->medicoModelo->obtenerTodos();
        $especialidades = $this->especialidadModelo->obtenerTodas();

        // Buscar paciente
        if (isset($_POST['buscar_paciente'])) {
            $filtro = $_POST['filtro_paciente'] ?? '';
            $paciente = $this->recepcionistaModelo->buscarPacientePorDniONombre($filtro);
            if (!$paciente) {
                $error = "Paciente no encontrado.";
            }
        }

        // Registrar cita
        if (isset($_POST['registrar_cita'])) {
            $paciente_id = $_POST['paciente_id'];
            $medico_id = $_POST['medico_id'];
            $especialidad_id = $_POST['especialidad_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo_cita = $_POST['motivo_cita'];

            if ($paciente_id && $medico_id && $especialidad_id && $fecha && $hora && $motivo_cita) {
                try {
                    $citaModelo->crearCita($paciente_id, $medico_id, $especialidad_id, $fecha, $hora, $motivo_cita);
                    $exito = "Cita registrada correctamente.";
                } catch (Exception $e) {
                    $error = "Error al registrar la cita: " . $e->getMessage();
                }
            } else {
                $error = "Faltan datos para registrar la cita.";
            }
        }

        require_once __DIR__ . '/../views/recepcionista/registrar_cita.php';
    }

    /**
     * Gestionar citas: mostrar todas, con filtros opcionales
     */
    public function gestionar_citas() {
        Sesion::verificarSesionRecepcionista();

        $filtros = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $filtros['dni'] = $_POST['dni'] ?? '';
            $filtros['nombre'] = $_POST['nombre'] ?? '';
            $filtros['fecha'] = $_POST['fecha'] ?? '';
        }

        $citas = $this->recepcionistaModelo->obtenerTodasLasCitas($filtros);
        require_once __DIR__ . '/../views/recepcionista/gestionar_citas.php';
    }

    /**
     * Registrar nueva cita
     */
    public function registrar_cita_paciente() {
        Sesion::verificarSesionRecepcionista();

        $paciente = null;
        $exito = null;
        $error = null;

        if (isset($_GET['paciente_id'])) {
            $paciente_id = $_GET['paciente_id'];
            $paciente = $this->recepcionistaModelo->obtenerPacientePorId($paciente_id);
        }

        $medicos = $this->medicoModelo->obtenerTodos();
        $especialidades = $this->especialidadModelo->obtenerTodas();

        if (isset($_POST['buscar_paciente'])) {
            $filtro = $_POST['filtro_paciente'] ?? '';
            $paciente = $this->recepcionistaModelo->buscarPacientePorDniONombre($filtro);
            if (!$paciente) {
                $error = "Paciente no encontrado.";
            }
        }

        if (isset($_POST['registrar_cita'])) {
            $paciente_id = $_POST['paciente_id'];
            $medico_id = $_POST['medico_id'];
            $especialidad_id = $_POST['especialidad_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo_cita = $_POST['motivo_cita'];

            if ($paciente_id && $medico_id && $especialidad_id && $fecha && $hora && $motivo_cita) {
                $this->recepcionistaModelo->registrarCita($paciente_id, $medico_id, $especialidad_id, $fecha, $hora, $motivo_cita);
                $exito = "Cita registrada correctamente.";
            } else {
                $error = "Faltan datos para registrar la cita.";
            }
        }

        require_once __DIR__ . '/../views/recepcionista/registrar_cita_paciente.php';
    }

    public function registrar_paciente() {
        Sesion::verificarSesionRecepcionista();

        $exito = null;
        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $dni = $_POST['dni'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $telefono = $_POST['telefono'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;

            if ($nombre && $apellido && $dni && $email && $password) {
                $paciente_id = $this->recepcionistaModelo->registrarPaciente(
                    $nombre, $apellido, $dni, $email, $password, $telefono, $direccion, $fecha_nacimiento
                );
                if ($paciente_id) {
                    $exito = "Paciente registrado correctamente.";
                } else {
                    $error = "Error al registrar paciente.";
                }
            } else {
                $error = "Por favor completa los campos obligatorios.";
            }
        }

        require_once __DIR__ . '/../views/recepcionista/registrar_paciente.php';
    }


    /**
     * Ver pacientes registrados
     */
    public function ver_pacientes() {
        Sesion::verificarSesionRecepcionista();

        $pacientes = $this->recepcionistaModelo->obtenerTodosLosPacientes();
        require_once __DIR__ . '/../views/recepcionista/ver_pacientes.php';
    }

    // Cancela la cita cambiando su estado a 'cancelada'
    public function cancelar_cita() {
        Sesion::verificarSesionRecepcionista();

        if (isset($_GET['id'])) {
            $cita_id = $_GET['id'];
            $this->recepcionistaModelo->actualizarEstadoCita($cita_id, 'cancelada');
        }

        header("Location: index.php?url=recepcionista/gestionar_citas");
        exit();
    }

    // Muestra formulario de edición de cita
    public function editar_cita() {
        Sesion::verificarSesionRecepcionista();

        if (!isset($_GET['id'])) {
            header("Location: index.php?url=recepcionista/gestionar_citas");
            exit();
        }

        $cita_id = $_GET['id'];
        $cita = $this->recepcionistaModelo->obtenerCitaPorId($cita_id);
        $medicos = $this->medicoModelo->obtenerTodos();
        $especialidades = $this->especialidadModelo->obtenerTodas();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo_cita = $_POST['motivo_cita'];

            if ($fecha && $hora && $motivo_cita) {
                $this->recepcionistaModelo->actualizarCita($cita_id, $fecha, $hora, $motivo_cita);
                header("Location: index.php?url=recepcionista/gestionar_citas");
                exit();
            } else {
                $error = "Faltan datos para actualizar la cita.";
            }
        }

        require_once __DIR__ . '/../views/recepcionista/editar_cita.php';
    }

}
?>
