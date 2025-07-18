<?php
// Archivo: /Gestion-Citas/controllers/EspecialidadController.php

require_once __DIR__ . "/../models/Especialidad.php";
require_once __DIR__ . "/../core/Sesion.php";

class EspecialidadController {

    private $especialidadModelo;

    public function __construct() {
        $this->especialidadModelo = new Especialidad();
    }

    /**
     * Listar todas las especialidades
     */
    public function index() {
        Sesion::verificarSesionAdmin();
        $especialidades = $this->especialidadModelo->obtenerTodas();
        require_once __DIR__ . "/../views/especialidades/index.php";
    }

    /**
     * Registrar una nueva especialidad
     */
    public function registrar() {
        Sesion::verificarSesionAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (empty($nombre)) {
                $error = "El nombre de la especialidad no puede estar vacío.";
            } else {
                $this->especialidadModelo->registrarEspecialidad($nombre);
                $exito = "Especialidad registrada correctamente.";
            }
        }

        $especialidades = $this->especialidadModelo->obtenerTodas();
        require_once __DIR__ . "/../views/especialidades/registrar.php";
    }

    /**
     * Editar una especialidad
     */
    public function editar() {
        Sesion::verificarSesionAdmin();

        if (!isset($_GET['id'])) {
            header("Location: index.php?url=especialidad/index");
            exit();
        }

        $id = $_GET['id'];
        $especialidad = $this->especialidadModelo->obtenerPorId($id);

        if (!$especialidad) {
            header("Location: index.php?url=especialidad/index");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (empty($nombre)) {
                $error = "El nombre no puede estar vacío.";
            } else {
                $this->especialidadModelo->actualizarEspecialidad($id, $nombre);
                header("Location: index.php?url=especialidad/index");
                exit();
            }
        }

        require_once __DIR__ . "/../views/especialidades/editar.php";
    }

    /**
     * Eliminar especialidad
     */
    public function eliminar() {
        Sesion::verificarSesionAdmin();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->especialidadModelo->eliminarEspecialidad($id);
        }

        header("Location: index.php?url=especialidad/index");
        exit();
    }
}
?>
