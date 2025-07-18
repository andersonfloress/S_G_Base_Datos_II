<?php

require_once __DIR__ . '/../core/Conexion.php';

class ResultadoExamen
{
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Guardar un nuevo resultado de examen con archivo PDF.
     */
    public function guardarResultado($examen_programado_id, $nombre_archivo) {
        $sql = "INSERT INTO resultados_examenes (cita_examen_id, nombre_archivo, estado, fecha_resultado)
                VALUES (:examen_programado_id, :nombre_archivo, 'listo', NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':examen_programado_id', $examen_programado_id);
        $stmt->bindParam(':nombre_archivo', $nombre_archivo);
        return $stmt->execute();
    }

    /**
     * Obtener resultados de exámenes de un paciente con nombre de examen.
     */
    public function obtenerResultadosPorPaciente($paciente_id) {
        $sql = "SELECT re.id, re.nombre_archivo, re.fecha_resultado, e.nombre AS nombre_examen
                FROM resultados_examenes re
                INNER JOIN citas_examenes ce ON re.cita_examen_id = ce.id
                INNER JOIN examenes e ON ce.examen_id = e.id
                WHERE ce.paciente_id = :paciente_id
                AND re.estado = 'listo'
                ORDER BY re.fecha_resultado DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si ya existe un resultado asociado al examen programado.
     */
    public function existeResultadoPorExamenProgramado($examen_programado_id) {
        $sql = "SELECT COUNT(*) FROM resultados_examenes WHERE cita_examen_id = :examen_programado_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':examen_programado_id', $examen_programado_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Actualizar archivo PDF de un resultado de examen existente.
     */
    public function actualizarArchivoResultado($examen_programado_id, $nombre_archivo) {
        $sql = "UPDATE resultados_examenes 
                SET nombre_archivo = :nombre_archivo, fecha_resultado = NOW()
                WHERE cita_examen_id = :examen_programado_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':examen_programado_id', $examen_programado_id);
        $stmt->bindParam(':nombre_archivo', $nombre_archivo);
        return $stmt->execute();
    }
}

?>
