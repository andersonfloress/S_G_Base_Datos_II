<?php
// Archivo: /Gestion-Citas/models/Cita.php

require_once __DIR__ . "/../core/Conexion.php";

class Cita {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Crear una nueva cita con motivo
     */
    public function crearCita($paciente_id, $medico_id, $especialidad_id, $sala_id, $fecha, $hora, $motivo) {
        $sql = "INSERT INTO citas (paciente_id, medico_id, especialidad_id, sala_id, fecha, hora, motivo_cita, estado)
                VALUES (:paciente_id, :medico_id, :especialidad_id, :sala_id, :fecha, :hora, :motivo_cita, 'reservada')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':paciente_id' => $paciente_id,
            ':medico_id' => $medico_id,
            ':especialidad_id' => $especialidad_id,
            ':sala_id' => $sala_id,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':motivo_cita' => $motivo
        ]);
        return $this->pdo->lastInsertId();
    }


    /**
     * Listar todas las citas con información relacionada
     */
    public function obtenerTodasCitas() {
        $sql = "SELECT c.*, 
                       p.id AS paciente_id, u_p.nombre AS paciente_nombre,
                       m.id AS medico_id, u_m.nombre AS medico_nombre,
                       e.nombre AS especialidad_nombre,
                       s.nombre AS sala_nombre
                FROM citas c
                INNER JOIN pacientes p ON c.paciente_id = p.id
                INNER JOIN usuarios u_p ON p.usuario_id = u_p.id
                INNER JOIN medicos m ON c.medico_id = m.id
                INNER JOIN usuarios u_m ON m.usuario_id = u_m.id
                INNER JOIN especialidades e ON c.especialidad_id = e.id
                LEFT JOIN salas s ON c.sala_id = s.id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Listar citas de un paciente
     */
    

    /**
     * Verificar disponibilidad de fecha, hora y sala
     */
    public function verificarDisponibilidad($fecha, $hora, $sala_id) {
        $sql = "SELECT * FROM citas 
                WHERE fecha = :fecha AND hora = :hora AND sala_id = :sala_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':sala_id' => $sala_id
        ]);
        return $stmt->fetch();
    }

    /**
     * Listar citas de un médico
     */
    public function obtenerCitasPorMedico($medico_id) {
        $sql = "SELECT c.*, 
                       p.id AS paciente_id, u_p.nombre AS paciente_nombre,
                       e.nombre AS especialidad_nombre,
                       s.nombre AS sala_nombre
                FROM citas c
                INNER JOIN pacientes p ON c.paciente_id = p.id
                INNER JOIN usuarios u_p ON p.usuario_id = u_p.id
                INNER JOIN especialidades e ON c.especialidad_id = e.id
                LEFT JOIN salas s ON c.sala_id = s.id
                WHERE c.medico_id = :medico_id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':medico_id' => $medico_id]);
        return $stmt->fetchAll();
    }

    /**
     * Cambiar estado de cita
     */
    public function cambiarEstadoCita($cita_id, $nuevo_estado) {
        $sql = "UPDATE citas SET estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':estado' => $nuevo_estado,
            ':id' => $cita_id
        ]);
    }

    /**
     * Obtener el ID de la última cita creada
     */
    public function obtenerUltimaCitaId() {
        return $this->pdo->lastInsertId();
    }

    // Obtener citas de hoy
    public function obtenerCitasDelDiaPorMedico($medico_id) {
        $sql = "SELECT c.*, u.nombre AS nombre_paciente, c.paciente_id
                FROM citas c
                INNER JOIN usuarios u ON c.paciente_id = u.id
                WHERE c.medico_id = :medico_id AND DATE(c.fecha) = CURDATE()
                ORDER BY c.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':medico_id' => $medico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener citas de próximos días
    public function obtenerCitasProximasPorMedico($medico_id) {
        $sql = "SELECT c.*, u.nombre AS nombre_paciente, c.paciente_id
                FROM citas c
                INNER JOIN usuarios u ON c.paciente_id = u.id
                WHERE c.medico_id = :medico_id AND DATE(c.fecha) > CURDATE()
                ORDER BY c.fecha ASC, c.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':medico_id' => $medico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM citas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function marcarComoAtendida($cita_id) {
        $sql = "UPDATE citas SET estado = 'atendida' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $cita_id]);
    }

    public function obtenerCitasPorPaciente($paciente_id) {
        $sql = "SELECT c.id, CONCAT(u.nombre, ' ', u.apellido) AS nombre_medico, e.nombre AS nombre_especialidad,
                    s.nombre AS nombre_sala, c.fecha, c.hora, c.estado
                FROM citas c
                INNER JOIN medicos m ON c.medico_id = m.id
                INNER JOIN usuarios u ON m.usuario_id = u.id
                INNER JOIN especialidades e ON c.especialidad_id = e.id
                LEFT JOIN salas s ON c.sala_id = s.id
                WHERE c.paciente_id = :paciente_id
                ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':paciente_id', $paciente_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCitaPorId($id) {
        $sql = "SELECT * FROM citas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarCita($id, $fecha, $hora, $motivo_cita) {
        $sql = "UPDATE citas SET fecha = :fecha, hora = :hora, motivo_cita = :motivo_cita WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo_cita' => $motivo_cita,
            'id' => $id
        ]);
    }

    public function cancelarCita($cita_id) {
        $sql = "UPDATE citas SET estado = 'cancelada' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $cita_id]);
    }

}
?>
