<?php
// Archivo: /Gestion-Citas/controllers/SalaController.php

require_once __DIR__ . "/../models/Sala.php";
require_once __DIR__ . "/../core/Sesion.php";

class SalaController {

    private $salaModelo;

    public function __construct() {
        $this->salaModelo = new Sala();
    }

    /**
     * Mostrar todas las salas
     */
    public function index() {
        Sesion::verificarSesion();

        $salas = $this->salaModelo->obtenerTodas();

        require_once __DIR__ . "/../views/salas/index.php";
    }

    /**
     * Registrar nueva sala
     */
    public function registrar() {
        Sesion::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (empty($nombre)) {
                $error = "El nombre de la sala no puede estar vacío.";
                require_once __DIR__ . "/../views/salas/registrar.php";
                return;
            }

            $this->salaModelo->registrarSala($nombre);
            $exito = "Sala registrada correctamente.";

            require_once __DIR__ . "/../views/salas/registrar.php";
        } else {
            require_once __DIR__ . "/../views/salas/registrar.php";
        }
    }

    /**
     * Editar sala
     */
    public function editar() {
        Sesion::verificarSesion();

        if (!isset($_GET["id"])) {
            header("Location: index.php?url=sala/index");
            exit();
        }

        $id = $_GET["id"];
        $sala = $this->salaModelo->obtenerSalaPorId($id);

        if (!$sala) {
            header("Location: index.php?url=sala/index");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (empty($nombre)) {
                $error = "El nombre de la sala no puede estar vacío.";
                require_once __DIR__ . "/../views/salas/editar.php";
                return;
            }

            $this->salaModelo->actualizarSala($id, $nombre);
            $exito = "Sala actualizada correctamente.";

            // Recargar datos actualizados
            $sala = $this->salaModelo->obtenerSalaPorId($id);
        }

        require_once __DIR__ . "/../views/salas/editar.php";
    }

    /**
     * Eliminar sala
     */
    public function eliminar() {
        Sesion::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
            $id = $_POST["id"];
            $this->salaModelo->eliminarSala($id);
        }

        header("Location: index.php?url=sala/index");
        exit();
    }
}
?>
