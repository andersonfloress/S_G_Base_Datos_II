<?php
// Archivo: /Gestion-Citas/controllers/EnfermeraController.php

require_once __DIR__ . "/../models/Enfermera.php";
require_once __DIR__ . "/../models/Paciente.php";
require_once __DIR__ . "/../core/Sesion.php";

class EnfermeraController {

    private $enfermeraModelo;
    private $pacienteModelo;

    public function __construct() {
        $this->enfermeraModelo = new Enfermera();
        $this->pacienteModelo = new Paciente();
    }

    /**
     * Dashboard de enfermera
     */
    public function dashboard() {
        Sesion::verificarSesionEnfermera();
        require_once __DIR__ . "/../views/enfermera/dashboard.php";
    }

    /**
     * Ver citas del día para la enfermera
     */
    public function citas_del_dia() {
        Sesion::verificarSesionEnfermera();

        $citas = $this->enfermeraModelo->obtenerCitasDelDia();
        require_once __DIR__ . "/../views/enfermera/ver_citas.php";
    }

    public function seleccionar_turno() {
        Sesion::verificarSesionEnfermera();

        $enfermera_id = $_SESSION['usuario_id'];
        $disponibilidad = $this->enfermeraModelo->obtenerDisponibilidadPorEnfermera($enfermera_id);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $dia_semana = $_POST["dia_semana"];
            $turno = $_POST["turno"];

            $dias_validos = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            $turnos_validos = ['Mañana', 'Tarde'];

            if (!in_array($dia_semana, $dias_validos) || !in_array($turno, $turnos_validos)) {
                $error = "Día de semana o turno inválido.";
            } else {
                $this->enfermeraModelo->registrarDisponibilidad($enfermera_id, $dia_semana, $turno);
                $exito = "Disponibilidad registrada correctamente.";
                $disponibilidad = $this->enfermeraModelo->obtenerDisponibilidadPorEnfermera($enfermera_id);
            }
        }

        require_once __DIR__ . "/../views/enfermera/seleccionar_turno.php";
    }


    /**
     * Registrar signos vitales de un paciente
     */
    public function registrar_signos() {
        Sesion::verificarSesionEnfermera();

        $cita_id = isset($_GET['cita_id']) ? intval($_GET['cita_id']) : null;
        $paciente_id = isset($_GET['paciente_id']) ? intval($_GET['paciente_id']) : null;

        if (!$paciente_id || !$cita_id) {
            header("Location: index.php?url=enfermera/citas_del_dia");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $presion = $_POST["presion"];
            $temperatura = $_POST["temperatura"];
            $frecuencia_cardiaca = $_POST["frecuencia_cardiaca"];
            $frecuencia_respiratoria = $_POST["frecuencia_respiratoria"];
            $observaciones = $_POST["observaciones"];
            $enfermera_id = $_SESSION['usuario_id'];

            if (!$presion || !$temperatura || !$frecuencia_cardiaca || !$frecuencia_respiratoria) {
                $error = "Todos los campos son obligatorios.";
            } else {
                $this->enfermeraModelo->registrarSignosVitales(
                    $paciente_id,
                    $cita_id,
                    $presion,
                    $temperatura,
                    $frecuencia_cardiaca,
                    $frecuencia_respiratoria,
                    $observaciones,
                    $enfermera_id
                );
                $exito = "Signos vitales registrados correctamente.";

                // Redirigir de regreso a citas del día con mensaje de éxito
                header("Location: index.php?url=enfermera/citas_del_dia&exito=1");
                exit();
            }
        }

        // Obtener datos del paciente para mostrar
        $paciente = $this->pacienteModelo->obtenerPorId($paciente_id);
        $paciente_seleccionado = $paciente; // Para usar en la vista

        require_once __DIR__ . "/../views/enfermera/registrar_signos.php";

    }

}
?>
