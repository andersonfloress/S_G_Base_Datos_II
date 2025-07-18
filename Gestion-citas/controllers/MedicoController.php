<?php
// Archivo: /Gestion-Citas/controllers/MedicoController.php

require_once __DIR__ . "/../core/Sesion.php";

class MedicoController {

    public function __construct() {
        // Inicializaciones futuras si necesitas
    }

    public function dashboard() {
        Sesion::verificarSesionMedico();
        require_once __DIR__ . "/../views/medico/dashboard.php";
    }

    // Mostrar citas del día actual
    public function citas() {
        Sesion::verificarSesionMedico();
        require_once __DIR__ . "/../models/Cita.php";
        $citaModelo = new Cita();
        $medico_id = $_SESSION['usuario_id'];

        $citas = $citaModelo->obtenerCitasDelDiaPorMedico($medico_id);

        require_once __DIR__ . "/../views/medico/citas_asignadas.php";
    }

    // Mostrar citas de próximos días
    public function citas_semana() {
        Sesion::verificarSesionMedico();
        require_once __DIR__ . "/../models/Cita.php";
        $citaModelo = new Cita();
        $medico_id = $_SESSION['usuario_id'];

        $citas = $citaModelo->obtenerCitasProximasPorMedico($medico_id);

        require_once __DIR__ . "/../views/medico/citas_asignadas.php";
    }

    public function disponibilidad() {
        Sesion::verificarSesionMedico();

        require_once __DIR__ . "/../models/DisponibilidadMedico.php";
        $disponibilidadModelo = new DisponibilidadMedico();

        // ID del médico logueado
        $medico_id = $_SESSION['usuario_id'];

        // Si envió el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $dia_semana = $_POST["dia_semana"];
            $turno = $_POST["turno"];

            // Validar datos
            if (in_array($dia_semana, ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo']) &&
                in_array($turno, ['Mañana', 'Tarde'])) {

                $disponibilidadModelo->registrarDisponibilidad($medico_id, $dia_semana, $turno);
                $exito = "Disponibilidad registrada correctamente.";
            } else {
                $error = "Datos inválidos.";
            }
        }

        // Obtener todas las disponibilidades de este médico
        $disponibilidades = $disponibilidadModelo->obtenerDisponibilidadesPorMedico($medico_id);

        require_once __DIR__ . "/../views/medico/disponibilidad.php";
    }

    public function historiales() {
        Sesion::verificarSesionMedico();
        $medico_id = $_SESSION['usuario_id'];

        require_once __DIR__ . "/../models/Medico.php";
        $medicoModelo = new Medico();

        $filtro = [];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($_GET['nombre'])) $filtro['nombre'] = trim($_GET['nombre']);
            if (!empty($_GET['apellido'])) $filtro['apellido'] = trim($_GET['apellido']);
            if (!empty($_GET['fecha'])) $filtro['fecha'] = trim($_GET['fecha']);
        }

        $historiales = $medicoModelo->obtenerHistorialPacientes($medico_id, $filtro);

        require_once __DIR__ . "/../views/medico/historial_paciente.php";
    }

    public function registrar_diagnostico() {
        Sesion::verificarSesionMedico();

        require_once __DIR__ . "/../models/Diagnostico.php";
        require_once __DIR__ . "/../models/Paciente.php";
        require_once __DIR__ . "/../models/Cita.php";

        $diagnosticoModelo = new Diagnostico();
        $pacienteModelo = new Paciente();
        $citaModelo = new Cita();

        // Recibir cita_id y paciente_id por GET
        $cita_id = isset($_GET['cita_id']) ? intval($_GET['cita_id']) : null;
        $paciente_id = isset($_GET['paciente_id']) ? intval($_GET['paciente_id']) : null;

        if (!$cita_id || !$paciente_id) {
            header("Location: index.php?url=medico/citas");
            exit();
        }

        // Obtener datos del paciente
        $paciente = $pacienteModelo->obtenerPorId($paciente_id);
        // Obtener datos de la cita
        $cita = $citaModelo->obtenerPorId($cita_id);

        if (!$paciente || !$cita) {
            header("Location: index.php?url=medico/citas");
            exit();
        }

        // Si se envía el formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $diagnostico = trim($_POST["diagnostico"]);
            $tratamiento = trim($_POST["tratamiento"]);
            $observaciones = trim($_POST["observaciones"]);

            if ($diagnostico && $tratamiento) {
                $diagnosticoModelo->registrarDiagnostico(
                    $cita_id,
                    $paciente_id,
                    $_SESSION['usuario_id'], // id del médico
                    $diagnostico,
                    $tratamiento,
                    $observaciones
                );

                $citaModelo->marcarComoAtendida($cita_id);

                // Redirigir con mensaje de éxito
                header("Location: index.php?url=medico/citas&exito=Diagnóstico registrado correctamente");
                exit();
            } else {
                $error = "El diagnóstico y tratamiento son obligatorios.";
            }
        }

        // Mostrar formulario
        require_once __DIR__ . "/../views/medico/registrar_diagnostico.php";
    }



}
?>
