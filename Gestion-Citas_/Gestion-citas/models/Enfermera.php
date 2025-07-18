<?php
// Archivo: /Gestion-Citas/models/Enfermera.php

require_once __DIR__ . "/../core/Conexion.php";

class Enfermera {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar enfermera con turno
     */
    public function registrarEnfermera($usuario_id, $turno, $estado = 'activo') {
        $sql = "INSERT INTO enfermeras (usuario_id, turno, estado)
                VALUES (:usuario_id, :turno, :estado)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':turno' => $turno,
            ':estado' => $estado
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Actualizar turno y estado de la enfermera
     */
    public function actualizarEnfermera($id, $turno, $estado) {
        $sql = "UPDATE enfermeras SET turno = :turno, estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':turno' => $turno,
            ':estado' => $estado
        ]);
    }

    /**
     * Registrar signos vitales del paciente
     */
    public function registrarSignosVitales($paciente_id, $cita_id, $presion, $temperatura, $frecuencia_cardiaca, $frecuencia_respiratoria, $observaciones, $enfermera_id) {
        $stmt = $this->pdo->prepare("
            INSERT INTO signos_vitales 
            (paciente_id, cita_id, enfermera_id, fecha, hora, presion_arterial, frecuencia_cardiaca, frecuencia_respiratoria, temperatura, observaciones)
            VALUES (?, ?, ?, CURDATE(), CURTIME(), ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $paciente_id,
            $cita_id,
            $enfermera_id,
            $presion,
            $frecuencia_cardiaca,
            $frecuencia_respiratoria,
            $temperatura,
            $observaciones
        ]);
    }


    /**
     * Obtener citas del día (puede filtrarse por médico si deseas)
     */
    public function obtenerCitasDelDia() {
        $hoy = date('Y-m-d');
        $sql = "
        SELECT c.id, c.fecha, c.hora, c.motivo_cita, 
            u.nombre, u.apellido, u.dni, u.fecha_nacimiento
        FROM citas c
        INNER JOIN pacientes p ON c.paciente_id = p.id
        INNER JOIN usuarios u ON p.usuario_id = u.id
        WHERE c.fecha = :hoy
        ORDER BY c.hora ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['hoy' => $hoy]);
        return $stmt->fetchAll();
    }

    public function verificarSignosRegistrados($cita_id, $paciente_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM signos_vitales WHERE paciente_id = ? AND cita_id = ?");
        $stmt->execute([$paciente_id, $cita_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function registrarDisponibilidad($enfermera_id, $dia_semana, $turno) {
        $sql = "INSERT INTO disponibilidad_enfermeras (enfermera_id, dia_semana, turno) VALUES (:enfermera_id, :dia_semana, :turno)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':enfermera_id', $enfermera_id);
        $stmt->bindParam(':dia_semana', $dia_semana);
        $stmt->bindParam(':turno', $turno);
        $stmt->execute();
    }

    public function obtenerDisponibilidadPorEnfermera($enfermera_id) {
        $sql = "SELECT * FROM disponibilidad_enfermeras WHERE enfermera_id = :enfermera_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':enfermera_id', $enfermera_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?>
