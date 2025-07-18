<?php
// Archivo: models/TipoExamen.php

require_once __DIR__ . '/../core/Conexion.php';

class TipoExamen
{
    private $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * ✅ Obtener todos los tipos de examen ordenados alfabéticamente
     */
    public function obtenerTodos()
    {
        $sql = "SELECT te.id, te.nombre, ee.nombre AS especialidad_examen 
                FROM tipos_examen te
                INNER JOIN especialidad_examenes ee ON te.especialidad_examen_id = ee.id
                ORDER BY te.nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ Obtener tipos de examen por especialidad de examen
     * @param int $especialidad_examen_id
     */
    public function obtenerPorEspecialidadExamen($especialidad_examen_id)
    {
        $sql = "SELECT te.id, te.nombre 
                FROM tipos_examen te
                WHERE te.especialidad_examen_id = :especialidad_examen_id
                ORDER BY te.nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':especialidad_examen_id', $especialidad_examen_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ Crear un tipo de examen con nombre y especialidad vinculada
     * @param string $nombre
     * @param int $especialidad_examen_id
     */
    public function crear($nombre, $especialidad_examen_id)
    {
        $sql = "INSERT INTO tipos_examen (nombre, especialidad_examen_id) VALUES (:nombre, :especialidad_examen_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':especialidad_examen_id', $especialidad_examen_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * ✅ Obtener un tipo de examen por ID
     * @param int $id
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT te.id, te.nombre, te.especialidad_examen_id, ee.nombre AS especialidad_examen
                FROM tipos_examen te
                INNER JOIN especialidad_examenes ee ON te.especialidad_examen_id = ee.id
                WHERE te.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ Actualizar un tipo de examen
     * @param int $id
     * @param string $nombre
     * @param int $especialidad_examen_id
     */
    public function actualizar($id, $nombre, $especialidad_examen_id)
    {
        $sql = "UPDATE tipos_examen SET nombre = :nombre, especialidad_examen_id = :especialidad_examen_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':especialidad_examen_id', $especialidad_examen_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * ✅ Eliminar un tipo de examen por ID
     * @param int $id
     */
    public function eliminar($id)
    {
        $sql = "DELETE FROM tipos_examen WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
