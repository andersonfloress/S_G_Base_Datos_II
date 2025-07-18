<?php
// Archivo: models/EspecialidadExamen.php

require_once __DIR__ . "/../core/Conexion.php";

class EspecialidadExamen {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Obtener todas las especialidades de exámenes disponibles
     */
    public function obtenerTodas() {
        $sql = "SELECT id, nombre FROM especialidad_examenes ORDER BY nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear una nueva especialidad de examen
     */
    public function crear($nombre) {
        $sql = "INSERT INTO especialidad_examenes (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Eliminar una especialidad por ID
     */
    public function eliminar($id) {
        $sql = "DELETE FROM especialidad_examenes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Obtener una especialidad por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT id, nombre FROM especialidad_examenes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualizar una especialidad
     */
    public function actualizar($id, $nombre) {
        $sql = "UPDATE especialidad_examenes SET nombre = :nombre WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre
        ]);
    }
}
?>
