<?php
// Archivo: /Gestion-Citas/controllers/NotificacionController.php

require_once __DIR__ . "/../models/Notificacion.php";
require_once __DIR__ . "/../core/Sesion.php";

class NotificacionController {

    private $notificacionModelo;

    public function __construct() {
        $this->notificacionModelo = new Notificacion();
    }

    /**
     * Mostrar todas las notificaciones del usuario actual
     */
    public function index() {
        Sesion::verificarSesion();

        $usuario_id = $_SESSION['usuario_id'];
        $notificaciones = $this->notificacionModelo->obtenerPorUsuario($usuario_id);

        require_once __DIR__ . "/../views/notificaciones/index.php";
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarLeida() {
        Sesion::verificarSesion();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->notificacionModelo->marcarLeida($id);
        }

        header("Location: index.php?url=notificacion/index");
        exit();
    }

    /**
     * Eliminar una notificación
     */
    public function eliminar() {
        Sesion::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->notificacionModelo->eliminarNotificacion($id);
        }

        header("Location: index.php?url=notificacion/index");
        exit();
    }
}
?>
