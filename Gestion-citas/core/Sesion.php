<?php
// Archivo: /Gestion-Citas/core/Sesion.php

class Sesion {

    /**
     * Iniciar sesión si aún no está iniciada.
     */
    public static function iniciar() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Verificar sesión para cualquier usuario logueado.
     */
    public static function verificarSesion() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Verificar sesión solo para administradores.
     */
    public static function verificarSesionAdmin() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 1) {
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Verificar sesión solo para médicos.
     */
    public static function verificarSesionMedico() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 2) {
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Verificar sesión solo para enfermeras.
     */
    public static function verificarSesionEnfermera() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 3) { // 3 es Enfermera
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Verificar sesión solo para recepcionistas.
     */
    public static function verificarSesionRecepcionista() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 4) {
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Verificar sesión solo para pacientes.
     */
    public static function verificarSesionPaciente() {
        self::iniciar();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 5) {
            header("Location: index.php?url=usuario/index");
            exit();
        }
    }

    /**
     * Cerrar sesión limpiamente.
     */
    public static function cerrar() {
        self::iniciar();
        session_unset();
        session_destroy();
    }
}
?>
