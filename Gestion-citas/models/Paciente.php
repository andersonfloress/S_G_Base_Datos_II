<?php
// Archivo: /Gestion-Citas/models/Paciente.php

require_once __DIR__ . "/../core/Conexion.php";

class Paciente {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar paciente
     * Se usa al momento de registrar un paciente tras crear su usuario.
     */
    public function registrarPaciente($usuario_id) {
        $sql = "INSERT INTO pacientes (usuario_id) VALUES (:usuario_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $this->pdo->lastInsertId();
    }


    /**
     * Obtener todos los pacientes
     * Útil para panel de administración o reportes.
     */
    public function obtenerTodosPacientes() {
        $sql = "SELECT p.*, u.nombre, u.email 
                FROM pacientes p 
                INNER JOIN usuarios u ON p.usuario_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener paciente por ID
     */
    public function obtenerPacientePorId($id) {
        $sql = "SELECT p.*, u.nombre, u.email 
                FROM pacientes p 
                INNER JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Obtener paciente por usuario_id
     * Útil si quieres obtener los datos de paciente desde el usuario en sesión.
     */
    public function obtenerPacientePorUsuarioId($usuario_id) {
        $sql = "SELECT p.*, u.nombre, u.email 
                FROM pacientes p 
                INNER JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetch();
    }

    /**
     * Actualizar datos de un paciente
     */
    public function actualizarPaciente($id, $telefono, $direccion, $fecha_nacimiento) {
        $sql = "UPDATE pacientes 
                SET telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento
        ]);
    }

    public function obtenerHistorialClinico($paciente_id) {
        $sql = "SELECT * FROM historial_clinico WHERE paciente_id = :paciente_id ORDER BY fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':paciente_id' => $paciente_id]);
        return $stmt->fetchAll();
    }


    /**
     * Eliminar paciente
     */
    public function eliminarPaciente($id) {
        $sql = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function crearPaciente($usuario_id) {
        $sql = "INSERT INTO pacientes (usuario_id) VALUES (:usuario_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $this->pdo->lastInsertId();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM pacientes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM pacientes";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function obtenerPorUsuarioId($usuario_id) {
        $sql = "SELECT * FROM pacientes WHERE usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

}
?>
