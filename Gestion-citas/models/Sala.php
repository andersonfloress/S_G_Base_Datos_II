<?php
// Archivo: /Gestion-Citas/models/Sala.php

require_once __DIR__ . "/../core/Conexion.php";

class Sala {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar nueva sala
     */
    public function registrarSala($nombre) {
        $sql = "INSERT INTO salas (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Obtener todas las salas
     */
    public function obtenerTodas() {
        $sql = "SELECT id, nombre FROM salas ORDER BY nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener sala por ID
     */
    public function obtenerSalaPorId($id) {
        $sql = "SELECT id, nombre FROM salas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Actualizar sala
     */
    public function actualizarSala($id, $nombre) {
        $sql = "UPDATE salas SET nombre = :nombre WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre
        ]);
    }

    /**
     * Eliminar sala
     */
    public function eliminarSala($id) {
        $sql = "DELETE FROM salas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>
