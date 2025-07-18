<?php
// Archivo: models/EspecialidadMedica.php

require_once __DIR__ . '/../core/Conexion.php';

class EspecialidadMedica
{
    private $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    // Obtener todas las especialidades de médicos ordenadas alfabéticamente
    public function obtenerTodas()
    {
        $sql = "SELECT * FROM especialidades ORDER BY nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva especialidad médica
    public function crear($nombre)
    {
        $sql = "INSERT INTO especialidades (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        return $stmt->execute();
    }

    // Obtener una especialidad por ID
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM especialidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una especialidad médica
    public function actualizar($id, $nombre)
    {
        $sql = "UPDATE especialidades SET nombre = :nombre WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar una especialidad médica
    public function eliminar($id)
    {
        $sql = "DELETE FROM especialidades WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
