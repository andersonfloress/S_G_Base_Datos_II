<?php
// Archivo: /Gestion-Citas/controllers/CitaController.php

require_once __DIR__ . "/../models/Cita.php";
require_once __DIR__ . "/../core/Sesion.php";
require_once __DIR__ . "/../models/ExamenPaciente.php";

class CitaController {

    private $citaModelo;

    public function __construct() {
        $this->citaModelo = new Cita();
    }

    /**
     * Mostrar formulario de reserva de cita y procesar reserva
     */
    public function reservar() {
        Sesion::verificarSesion();

        if ($_SESSION['usuario_rol'] != 5) { // Solo rol Paciente
            header("Location: index.php?url=usuario/dashboard");
            exit("Solo los pacientes pueden crear citas.");
        }

        require_once __DIR__ . "/../models/Paciente.php";
        require_once __DIR__ . "/../models/Medico.php";
        require_once __DIR__ . "/../models/Especialidad.php";
        require_once __DIR__ . "/../models/ExamenPaciente.php";
        require_once __DIR__ . "/../models/EspecialistaExamen.php";
        require_once __DIR__ . "/../models/EspecialidadExamen.php"; // NUEVO
        require_once __DIR__ . "/../models/TipoExamen.php"; // NUEVO

        $pacienteModelo = new Paciente();
        $medicoModelo = new Medico();
        $especialidadModelo = new Especialidad();
        $examenPacienteModelo = new ExamenPaciente();
        $especialistaExamenModelo = new EspecialistaExamen();
        $especialidadExamenModelo = new EspecialidadExamen(); // NUEVO
        $tipoExamenModelo = new TipoExamen(); // NUEVO

        // OBTENER el ID real del paciente
        $paciente = $pacienteModelo->obtenerPorUsuarioId($_SESSION['usuario_id']);
        if (!$paciente) {
            $error = "No se encontró el paciente vinculado a este usuario.";
            require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
            return;
        }
        $paciente_id = $paciente['id'];

        $especialidades = $especialidadModelo->obtenerTodas();
        $especialidades_examenes = $especialidadExamenModelo->obtenerTodas(); // NUEVO
        $medicos = [];
        $tipos_examen = [];
        $especialistas_examen = $especialistaExamenModelo->obtenerTodos();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tipo_atencion = $_POST['tipo_atencion'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $hora = $_POST['hora'] ?? '';
            $motivo = trim($_POST['motivo'] ?? '');

            // Validación de formato de fecha y hora
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha) || !preg_match('/^\d{2}:\d{2}$/', $hora)) {
                $error = "Formato de fecha u hora inválido.";
                require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
                return;
            }

            // Determinar turno
            function determinarTurno($hora) {
                [$hh, $mm] = explode(':', $hora);
                $totalMin = intval($hh) * 60 + intval($mm);
                if ($totalMin >= 360 && $totalMin <= 720) {
                    return 'Mañana';
                } elseif ($totalMin >= 721 && $totalMin <= 1080) {
                    return 'Tarde';
                } else {
                    return null;
                }
            }

            $turno = determinarTurno($hora);
            if (!$turno) {
                $error = "La hora seleccionada no está dentro del rango de turnos permitidos (06:00-18:00).";
                require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
                return;
            }

            if ($tipo_atencion === 'cita_medica') {
                $especialidad_id = $_POST['especialidad_id'] ?? '';
                $medico_id = $_POST['medico_id'] ?? '';

                if (!is_numeric($especialidad_id)) {
                    $error = "Debe seleccionar una especialidad.";
                    require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
                    return;
                }

                // Cargar médicos disponibles por especialidad y turno
                $medicos = $medicoModelo->obtenerPorEspecialidadYTurno($especialidad_id, $turno);

                if (!is_numeric($medico_id)) {
                    $error = "Debe seleccionar un médico disponible.";
                    require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
                    return;
                }

                // Crear la cita
                $this->citaModelo->crearCita(
                    $paciente_id,
                    $medico_id,
                    $especialidad_id,
                    null, // sala_id eliminado
                    $fecha,
                    $hora,
                    $motivo
                );

                $exito = "Cita médica reservada correctamente.";

            } elseif ($tipo_atencion === 'examen_medico') {
                $especialidad_examen_id = $_POST['especialidad_examen_id'] ?? '';
                $tipo_examen_id = $_POST['tipo_examen'] ?? '';
                $especialista_examen_id = $_POST['especialista_examen_id'] ?? '';

                if (!is_numeric($especialidad_examen_id) || !is_numeric($tipo_examen_id) || !is_numeric($especialista_examen_id)) {
                    $error = "Debe seleccionar especialidad, tipo de examen y especialista correctamente.";
                    require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
                    return;
                }

                $examenPacienteModelo->crearExamenPaciente(
                    $paciente_id,
                    $tipo_examen_id,
                    $especialista_examen_id,
                    $fecha,
                    $hora,
                    $motivo
                );

                $exito = "Examen médico reservado correctamente.";
            } else {
                $error = "Seleccione un tipo de atención válido.";
            }
        }

        require_once __DIR__ . "/../views/pacientes/reservar_cita.php";
    }

    /**
     * Obtener médicos disponibles por especialidad y turno (para AJAX)
     */
    public function obtenerMedicosDisponibles() {
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $especialidad_id = $_POST['especialidad_id'] ?? '';
            $hora = $_POST['hora'] ?? '';
            
            if (!$especialidad_id || !$hora) {
                echo json_encode(['error' => 'Faltan datos']);
                return;
            }
            
            // Determinar turno
            function determinarTurno($hora) {
                [$hh, $mm] = explode(':', $hora);
                $totalMin = intval($hh) * 60 + intval($mm);
                if ($totalMin >= 360 && $totalMin <= 720) {
                    return 'Mañana';
                } elseif ($totalMin >= 721 && $totalMin <= 1080) {
                    return 'Tarde';
                } else {
                    return null;
                }
            }
            
            $turno = determinarTurno($hora);
            if (!$turno) {
                echo json_encode(['error' => 'Hora fuera de rango']);
                return;
            }
            
            require_once __DIR__ . "/../models/Medico.php";
            $medicoModelo = new Medico();
            
            // Obtener médicos por especialidad Y turno
            $medicos = $medicoModelo->obtenerPorEspecialidadYTurno($especialidad_id, $turno);
            
            echo json_encode($medicos);
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    /**
     * NUEVO: Obtener tipos de examen por especialidad de examen (para AJAX)
     */
    public function obtenerTiposExamen() {
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $especialidad_examen_id = $_POST['especialidad_examen_id'] ?? '';
            
            if (!$especialidad_examen_id) {
                echo json_encode(['error' => 'Falta especialidad de examen']);
                return;
            }
            
            require_once __DIR__ . "/../models/TipoExamen.php";
            $tipoExamenModelo = new TipoExamen();
            
            // Obtener tipos de examen por especialidad
            $tipos_examen = $tipoExamenModelo->obtenerPorEspecialidadExamen($especialidad_examen_id);
            
            echo json_encode($tipos_examen);
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    /**
     * ACTUALIZADO: Obtener especialistas de examen disponibles por especialidad y turno (para AJAX)
     */
    public function obtenerEspecialistasExamenDisponibles() {
        header('Content-Type: application/json');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $hora = $_POST['hora'] ?? '';
            $especialidad_examen_id = $_POST['especialidad_examen_id'] ?? '';

            if (empty($hora) || empty($especialidad_examen_id)) {
                echo json_encode(['error' => 'Faltan datos requeridos (hora o especialidad)']);
                return;
            }

            // ✅ Determinar turno según hora
            [$hh, $mm] = explode(':', $hora);
            $totalMin = intval($hh) * 60 + intval($mm);
            if ($totalMin >= 360 && $totalMin <= 720) {
                $turno = 'Mañana';
            } elseif ($totalMin >= 721 && $totalMin <= 1080) {
                $turno = 'Tarde';
            } else {
                echo json_encode(['error' => 'Hora fuera de rango (06:00-18:00)']);
                return;
            }

            // ✅ Llamar al modelo
            require_once __DIR__ . "/../models/EspecialistaExamen.php";
            $especialistaExamenModelo = new EspecialistaExamen();

            try {
                $especialistas = $especialistaExamenModelo->obtenerPorEspecialidadYTurno($especialidad_examen_id, $turno);

                if (empty($especialistas)) {
                    echo json_encode([]);
                } else {
                    echo json_encode($especialistas);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al consultar especialistas: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
    }


    /**
     * Ver citas del paciente actual
     */
    public function misCitas() {
        Sesion::verificarSesion();

        require_once __DIR__ . '/../models/Paciente.php';
        $pacienteModelo = new Paciente();
        $paciente = $pacienteModelo->obtenerPorUsuarioId($_SESSION['usuario_id']);
        $paciente_id = $paciente ? $paciente['id'] : null;

        // Obtener citas
        $citas = $this->citaModelo->obtenerCitasPorPaciente($paciente_id);

        // Obtener exámenes
        require_once __DIR__ . '/../models/ExamenPaciente.php';
        $examenPacienteModelo = new ExamenPaciente();
        $examenes = $examenPacienteModelo->obtenerExamenesPorPaciente($paciente_id);

        require_once __DIR__ . "/../views/pacientes/mis_citas.php";
    }


    /**
     * Gestionar citas según rol:
     * Admin: todas las citas
     * Médico: solo sus citas
     * Otros: redirigir al dashboard
     */
    public function gestionarCitas() {
        Sesion::verificarSesion();

        $rol_id = $_SESSION['usuario_rol'];

        if ($rol_id == 1) { // admin
            $citas = $this->citaModelo->obtenerTodasCitas();
        } elseif ($rol_id == 3) { // medico
            $medico_id = $_SESSION['usuario_id'];
            $citas = $this->citaModelo->obtenerCitasPorMedico($medico_id);
        } else {
            header("Location: index.php?url=usuario/dashboard");
            exit();
        }

        require_once __DIR__ . "/../views/gestionar_citas.php";
    }

    /**
     * Cambiar el estado de una cita
     */
    public function cambiarEstado() {
        Sesion::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cita_id = $_POST['cita_id'];
            $nuevo_estado = $_POST['nuevo_estado'];

            $this->citaModelo->cambiarEstadoCita($cita_id, $nuevo_estado);

            header("Location: index.php?url=cita/gestionarCitas");
            exit();
        } else {
            header("Location: index.php?url=cita/gestionarCitas");
            exit();
        }
    }

    public function editar() {
        Sesion::verificarSesion();

        if (!isset($_GET['id'])) {
            echo "ID de cita no proporcionado.";
            return;
        }

        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = $_POST['fecha'] ?? '';
            $hora = $_POST['hora'] ?? '';
            $motivo_cita = $_POST['motivo_cita'] ?? '';

            $this->citaModelo->actualizarCita($id, $fecha, $hora, $motivo_cita);

            header('Location: index.php?url=cita/misCitas');
            exit;
        } else {
            $cita = $this->citaModelo->obtenerCitaPorId($id);
            require_once __DIR__ . '/../views/pacientes/editar_cita.php';
        }
    }

    public function cancelar() {
        Sesion::verificarSesion();

        if (!isset($_GET['id'])) {
            die('ID de cita no especificado.');
        }

        $cita_id = $_GET['id'];

        // Cancelar la cita en la base de datos
        if ($this->citaModelo->cancelarCita($cita_id)) {
            header('Location: index.php?url=cita/misCitas');
            exit;
        } else {
            die('Error al cancelar la cita.');
        }
    }


}
?>