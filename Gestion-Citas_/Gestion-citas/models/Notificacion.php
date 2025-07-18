<?php
// Archivo: /Gestion-Citas/models/Notificacion.php

require_once __DIR__ . "/../core/Conexion.php";

class Notificacion {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Crear nueva notificación
     */
    public function crearNotificacion($usuario_id, $cita_id, $mensaje) {
        $sql = "INSERT INTO notificaciones (usuario_id, cita_id, mensaje) 
                VALUES (:usuario_id, :cita_id, :mensaje)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':cita_id' => $cita_id,
            ':mensaje' => $mensaje
        ]);
    }

    /**
     * Obtener todas las notificaciones de un usuario
     */
    public function obtenerPorUsuario($usuario_id) {
        $sql = "SELECT n.*, c.fecha, c.hora, e.nombre AS especialidad
                FROM notificaciones n
                INNER JOIN citas c ON n.cita_id = c.id
                INNER JOIN especialidades e ON c.especialidad_id = e.id
                WHERE n.usuario_id = :usuario_id
                ORDER BY n.fecha_envio DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll();
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida($id) {
        $sql = "UPDATE notificaciones SET estado = 'leida' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * Eliminar notificación
     */
    public function eliminarNotificacion($id) {
        $sql = "DELETE FROM notificaciones WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>
