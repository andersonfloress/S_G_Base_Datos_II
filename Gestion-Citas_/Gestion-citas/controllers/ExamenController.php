<?php

require_once __DIR__ . '/../models/ExamenPaciente.php';

class ExamenController {

    private $examenPacienteModelo;

    public function __construct() {
        $this->examenPacienteModelo = new ExamenPaciente();
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $examen = $this->examenPacienteModelo->obtenerPorId($id);
            if ($examen) {
                require_once __DIR__ . '/../views/pacientes/editar_examen.php';
            } else {
                echo "Examen no encontrado.";
            }
        } else {
            echo "ID no proporcionado.";
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $fecha = $_POST['fecha'] ?? null;
            $hora = $_POST['hora'] ?? null;
            $motivo_cita = $_POST['motivo_cita'] ?? null;
            
            if ($id && $fecha && $hora) {
                $datos = [
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'motivo_cita' => $motivo_cita
                ];
                
                $resultado = $this->examenPacienteModelo->actualizarExamen($id, $datos);
                
                if ($resultado) {
                    header("Location: index.php?url=cita/misCitas&mensaje=examen_actualizado");
                } else {
                    echo "Error al actualizar el examen.";
                }
            } else {
                echo "Datos incompletos para actualizar.";
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function cancelar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->examenPacienteModelo->cancelarExamen($id);
            header("Location: index.php?url=cita/misCitas");
        } else {
            echo "ID no proporcionado para cancelar.";
        }
    }
}