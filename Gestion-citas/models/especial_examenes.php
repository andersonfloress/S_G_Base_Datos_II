<?php

class EspecialistaExamen
{
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    // Obtener próximas citas asignadas al especialista (por ID)
    public function obtenerProximasCitas($especialista_id){
        $sql = "SELECT ce.id, u.nombre AS nombre_paciente, u.apellido AS apellido_paciente,
                    ce.fecha, ce.hora, e.nombre AS motivo, e.tipo_resultado
                FROM citas_examenes ce
                INNER JOIN pacientes p ON ce.paciente_id = p.id
                INNER JOIN usuarios u ON p.usuario_id = u.id
                INNER JOIN examenes e ON ce.examen_id = e.id
                INNER JOIN especialista_examenes ee ON ce.especialista_examen_id = ee.id
                WHERE ee.usuario_id = :usuario_id
                AND ce.estado = 'reservada'
                AND ce.fecha BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
                ORDER BY ce.fecha, ce.hora ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $especialista_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Marcar examen como completado
    public function marcarExamenHecho($cita_id)
    {
        // Actualizar estado de la cita
        $sql = "UPDATE citas_examenes SET estado = 'completada', fecha_actualizacion = NOW()
                WHERE id = :cita_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cita_id', $cita_id);
        $stmt->execute();

        // Crear entrada en resultados_examenes para exámenes presenciales
        $sql2 = "INSERT INTO resultados_examenes (cita_examen_id, estado, fecha_resultado)
                VALUES (:cita_id, 'listo', NOW())";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindParam(':cita_id', $cita_id);
        return $stmt2->execute();
    }

    // Guardar PDF de resultados
    public function guardarResultados($cita_id, $nombre_archivo)
    {
        $sql = "INSERT INTO resultados_examenes (cita_examen_id, nombre_archivo, estado, fecha_resultado)
                VALUES (:cita_id, :nombre_archivo, 'listo', NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cita_id', $cita_id);
        $stmt->bindParam(':nombre_archivo', $nombre_archivo);
        return $stmt->execute();
    }

    // Verificar si ya existe el especialista por usuario_id
    public function existePorUsuarioId($usuario_id)
    {
        $sql = "SELECT COUNT(*) FROM especialista_examenes WHERE usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Crear especialista en exámenes
    public function crear($usuario_id, $especialidad)
    {
        $sql = "INSERT INTO especialista_examenes (usuario_id, especialidad, estado) VALUES (:usuario_id, :especialidad, 'activo')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':especialidad', $especialidad);
        return $stmt->execute();
    }

    // Obtener todos los especialistas de exámenes con datos del usuario
    public function obtenerTodos()
    {
        $sql = "SELECT 
                    ee.id,
                    u.nombre,
                    u.apellido,
                    u.dni,                -- AÑADIR ESTA LÍNEA
                    u.email,
                    u.password,
                    u.telefono,
                    u.direccion,
                    u.fecha_nacimiento
                FROM especialista_examenes ee
                INNER JOIN usuarios u ON ee.usuario_id = u.id
                ORDER BY u.apellido, u.nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Notificar resultado listo para recojo presencial
    public function notificarResultadoListo($cita_id)
    {
        // Obtener datos del paciente desde la cita
        $sql = "SELECT p.usuario_id, u.nombre, u.apellido, e.nombre as examen_nombre
                FROM citas_examenes ce
                INNER JOIN pacientes p ON ce.paciente_id = p.id
                INNER JOIN usuarios u ON p.usuario_id = u.id
                INNER JOIN examenes e ON ce.examen_id = e.id
                WHERE ce.id = :cita_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cita_id', $cita_id);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($datos) {
            // Insertar notificación
            $mensaje = "Su examen {$datos['examen_nombre']} está listo para recojo presencial.";
            $sql2 = "INSERT INTO notificaciones (usuario_id, cita_id, mensaje, fecha_envio, estado)
                    VALUES (:usuario_id, :cita_id, :mensaje, NOW(), 'pendiente')";
            
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->bindParam(':usuario_id', $datos['usuario_id']);
            $stmt2->bindParam(':cita_id', $cita_id);
            $stmt2->bindParam(':mensaje', $mensaje);
            return $stmt2->execute();
        }
        
        return false;
    }


}

?>
