<?php
// Archivo: /Gestion-Citas/models/Medico.php

require_once __DIR__ . "/../core/Conexion.php";

class Medico {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Obtener todos los médicos activos con sus nombres y especialidades (para vistas de admin)
     */
    public function obtenerTodos() {
        $sql = "SELECT m.id, m.usuario_id, u.nombre AS nombre_medico, e.nombre AS especialidad, m.pacientes_atendidos
                FROM medicos m
                INNER JOIN usuarios u ON m.usuario_id = u.id
                INNER JOIN especialidades e ON m.especialidad_id = e.id
                WHERE m.estado = 'activo'
                ORDER BY u.nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener médico por ID (para vistas de admin)
     */
    public function obtenerPorId($id) {
        $sql = "SELECT m.*, u.nombre AS nombre_medico, e.nombre AS especialidad
                FROM medicos m
                INNER JOIN usuarios u ON m.usuario_id = u.id
                INNER JOIN especialidades e ON m.especialidad_id = e.id
                WHERE m.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Incrementar pacientes atendidos (útil si deseas actualizar estadísticas)
     */
    public function incrementarPacientesAtendidos($id) {
        $sql = "UPDATE medicos SET pacientes_atendidos = pacientes_atendidos + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    // ================== FUNCIONES PARA EL PANEL DEL MÉDICO ==================

    /**
     * Obtener citas asignadas al médico
     */
    public function obtenerCitasAsignadas($usuario_id) {
        $sql = "SELECT c.id, c.fecha, c.hora, c.estado, 
                       p.nombre AS nombre_paciente, p.apellido AS apellido_paciente
                FROM citas c
                INNER JOIN usuarios p ON c.paciente_id = p.id
                WHERE c.medico_id = :usuario_id
                ORDER BY c.fecha, c.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener historiales clínicos de pacientes atendidos por este médico
     */
    public function obtenerHistorialesPorMedico($usuario_id) {
        $sql = "SELECT h.id, h.fecha, h.descripcion, 
                       p.nombre AS nombre_paciente, p.apellido AS apellido_paciente
                FROM historiales h
                INNER JOIN usuarios p ON h.paciente_id = p.id
                WHERE h.medico_id = :usuario_id
                ORDER BY h.fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll();
    }

    /**
     * Registrar diagnóstico (se registra como historial clínico)
     */
    public function registrarDiagnostico($paciente_id, $medico_id, $descripcion) {
        $sql = "INSERT INTO historiales (paciente_id, medico_id, descripcion, fecha)
                VALUES (:paciente_id, :medico_id, :descripcion, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':paciente_id' => $paciente_id,
            ':medico_id' => $medico_id,
            ':descripcion' => $descripcion
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function obtenerHistorialPacientes($medico_id, $filtro = []) {
        $sql = "SELECT u.nombre, u.apellido, u.dni, u.fecha_nacimiento, c.fecha 
                FROM citas c
                INNER JOIN usuarios u ON c.paciente_id = u.id
                WHERE c.medico_id = :medico_id AND c.fecha <= CURDATE()";

        $params = [':medico_id' => $medico_id];

        if (!empty($filtro['nombre'])) {
            $sql .= " AND u.nombre LIKE :nombre";
            $params[':nombre'] = '%' . $filtro['nombre'] . '%';
        }
        if (!empty($filtro['apellido'])) {
            $sql .= " AND u.apellido LIKE :apellido";
            $params[':apellido'] = '%' . $filtro['apellido'] . '%';
        }
        if (!empty($filtro['fecha'])) {
            $sql .= " AND c.fecha = :fecha";
            $params[':fecha'] = $filtro['fecha'];
        }

        $sql .= " ORDER BY c.fecha DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($usuario_id, $especialidad)
    {
        $sql = "INSERT INTO medicos (usuario_id, especialidad, estado) VALUES (:usuario_id, :especialidad, 'activo')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':especialidad', $especialidad);
        return $stmt->execute();
    }

    public function obtenerPorTurno($turno) {
        $sql = "SELECT m.*, u.nombre 
                FROM medicos m 
                INNER JOIN usuarios u ON m.usuario_id = u.id
                WHERE LOWER(m.turno) = LOWER(:turno) AND m.estado = 'activo'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':turno' => $turno]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener médicos por especialidad y turno (para citas)
     */
    public function obtenerPorEspecialidadYTurno($especialidad_id, $turno) {
        $sql = "SELECT m.id, m.usuario_id, u.nombre, u.apellido, e.nombre AS especialidad, m.turno
                FROM medicos m 
                INNER JOIN usuarios u ON m.usuario_id = u.id
                INNER JOIN especialidades e ON m.especialidad_id = e.id
                WHERE m.especialidad_id = :especialidad_id 
                AND LOWER(m.turno) = LOWER(:turno) 
                AND m.estado = 'activo'
                ORDER BY u.nombre ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':especialidad_id' => $especialidad_id,
            ':turno' => $turno
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}
?>
