<?php
// Archivo: /Gestion-Citas/models/Especialidad.php

require_once __DIR__ . "/../core/Conexion.php";

class Especialidad {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Obtener todas las especialidades
     * @return array
     */
    public function obtenerTodas() {
        $sql = "SELECT id, nombre FROM especialidades ORDER BY nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Registrar una nueva especialidad
     */
    public function registrarEspecialidad($nombre) {
        $sql = "INSERT INTO especialidades (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Eliminar especialidad
     */
    public function eliminarEspecialidad($id) {
        $sql = "DELETE FROM especialidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Actualizar especialidad
     */
    public function actualizarEspecialidad($id, $nombre) {
        $sql = "UPDATE especialidades SET nombre = :nombre WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':id' => $id
        ]);
    }

    /**
     * Obtener especialidad por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM especialidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
?>
