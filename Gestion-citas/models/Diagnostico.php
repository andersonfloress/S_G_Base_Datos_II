<?php
// Archivo: /Gestion-Citas/models/Diagnostico.php

require_once __DIR__ . "/../core/Conexion.php";

class Diagnostico {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar un diagnóstico
     */
    public function registrarDiagnostico($cita_id, $medico_id, $paciente_id, $diagnostico, $tratamiento, $observaciones) {
        $sql = "INSERT INTO diagnosticos (cita_id, medico_id, paciente_id, diagnostico, tratamiento, observaciones) 
                VALUES (:cita_id, :medico_id, :paciente_id, :diagnostico, :tratamiento, :observaciones)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':cita_id' => $cita_id,
            ':medico_id' => $medico_id,
            ':paciente_id' => $paciente_id,
            ':diagnostico' => $diagnostico,
            ':tratamiento' => $tratamiento,
            ':observaciones' => $observaciones
        ]);
    }

    /**
     * Obtener diagnósticos por paciente (útil para el historial)
     */
    public function obtenerDiagnosticosPorPaciente($paciente_id) {
        $sql = "SELECT d.*, u.nombre AS nombre_medico, u.apellido AS apellido_medico 
                FROM diagnosticos d
                INNER JOIN usuarios u ON d.medico_id = u.id
                WHERE d.paciente_id = :paciente_id
                ORDER BY d.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':paciente_id' => $paciente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
