<?php
// Archivo: /Gestion-Citas/models/DisponibilidadMedico.php

require_once __DIR__ . "/../core/Conexion.php";

class DisponibilidadMedico {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar una disponibilidad para el médico
     */
    public function registrarDisponibilidad($medico_id, $dia_semana, $turno) {
        $sql = "INSERT INTO disponibilidad_medicos (medico_id, dia_semana, turno) VALUES (:medico_id, :dia_semana, :turno)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':medico_id' => $medico_id,
            ':dia_semana' => $dia_semana,
            ':turno' => $turno
        ]);
    }

    /**
     * Obtener todas las disponibilidades de un médico
     */
    public function obtenerDisponibilidadesPorMedico($medico_id) {
        $sql = "SELECT * FROM disponibilidad_medicos WHERE medico_id = :medico_id ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':medico_id' => $medico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar disponibilidad por ID (si deseas dar opción de eliminar)
     */
    public function eliminarDisponibilidad($id, $medico_id) {
        $sql = "DELETE FROM disponibilidad_medicos WHERE id = :id AND medico_id = :medico_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':medico_id' => $medico_id
        ]);
    }
}
?>
