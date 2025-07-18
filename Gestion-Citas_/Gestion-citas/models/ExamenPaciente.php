<?php
// Archivo: /Gestion-Citas/models/ExamenPaciente.php

require_once __DIR__ . "/../core/Conexion.php";

class ExamenPaciente {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Crear un nuevo examen para el paciente
     */
    public function crearExamenPaciente($paciente_id, $examen_id, $especialista_examen_id, $fecha, $hora, $motivo) {
        $sql = "INSERT INTO citas_examenes (paciente_id, examen_id, especialista_examen_id, fecha, hora, estado, motivo_cita)
                VALUES (:paciente_id, :examen_id, :especialista_examen_id, :fecha, :hora, 'reservada', :motivo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':paciente_id' => $paciente_id,
            ':examen_id' => $examen_id,
            ':especialista_examen_id' => $especialista_examen_id,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':motivo' => $motivo
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Verificar disponibilidad del especialista de examen en fecha y hora
     */
    public function verificarDisponibilidad($fecha, $hora, $especialista_examen_id) {
        $sql = "SELECT * FROM citas_examenes
                WHERE fecha = :fecha AND hora = :hora AND especialista_examen_id = :especialista_examen_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':especialista_examen_id' => $especialista_examen_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT ce.*, e.nombre AS nombre_examen, ee.nombre AS nombre_especialidad, u.nombre AS nombre_especialista, u.apellido AS apellido_especialista
                FROM citas_examenes ce
                INNER JOIN examenes e ON ce.examen_id = e.id
                LEFT JOIN especialidad_examenes ee ON e.especialidad_id = ee.id
                LEFT JOIN especialista_examenes ese ON ce.especialista_examen_id = ese.id
                LEFT JOIN usuarios u ON ese.usuario_id = u.id
                WHERE ce.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelarExamen($id) {
        $sql = "UPDATE citas_examenes SET estado = 'cancelada' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function actualizarExamen($id, $datos) {
        try {
            $query = "UPDATE citas_examenes SET 
                    fecha = :fecha, 
                    hora = :hora, 
                    motivo_cita = :motivo_cita,
                    fecha_actualizacion = CURRENT_TIMESTAMP
                    WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $datos['fecha'], PDO::PARAM_STR);
            $stmt->bindParam(':hora', $datos['hora'], PDO::PARAM_STR);
            $stmt->bindParam(':motivo_cita', $datos['motivo_cita'], PDO::PARAM_STR);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error al actualizar examen: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerResultadoPorExamen($examen_id)
    {
        $sql = "SELECT re.nombre_archivo, re.estado, e.tipo_resultado 
                FROM resultados_examenes re 
                INNER JOIN citas_examenes ce ON re.cita_examen_id = ce.id 
                INNER JOIN examenes e ON ce.examen_id = e.id 
                WHERE ce.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$examen_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerExamenesPorPaciente($paciente_id) 
    {
        $sql = "
            SELECT ce.id,
                e.nombre AS nombre_examen,
                e.tipo_resultado,
                ee.nombre AS nombre_especialidad,
                u.nombre AS nombre_especialista,
                ce.fecha,
                ce.hora,
                ce.estado,
                re.nombre_archivo,
                re.estado as estado_resultado
            FROM citas_examenes ce
            INNER JOIN examenes e ON ce.examen_id = e.id
            LEFT JOIN resultados_examenes re ON ce.id = re.cita_examen_id
            LEFT JOIN especialidad_examenes ee ON e.especialidad_id = ee.id
            LEFT JOIN especialista_examenes ese ON ce.especialista_examen_id = ese.id
            LEFT JOIN usuarios u ON ese.usuario_id = u.id
            WHERE ce.paciente_id = :paciente_id
            ORDER BY ce.fecha DESC, ce.hora DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':paciente_id', $paciente_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
