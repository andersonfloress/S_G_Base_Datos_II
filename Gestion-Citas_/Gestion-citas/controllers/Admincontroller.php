<?php
// Archivo: /Gestion-Citas/controllers/AdminController.php

require_once __DIR__ . "/../core/Sesion.php";
require_once __DIR__ . "/../models/Especialidad.php";
require_once __DIR__ . "/../models/especial_examenes.php";


class AdminController {

    public function dashboard() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../views/admin/dashboard.php";
    }

    public function usuarios() {
        Sesion::verificarSesionAdmin();

        // Cargar modelo de Usuario
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();

        // Obtener todos los usuarios
        $usuarios = $usuarioModelo->obtenerTodosUsuarios();

        // Cargar la vista con la variable
        require_once __DIR__ . "/../views/admin/usuarios.php";
    }


    public function especialidades() {
        Sesion::verificarSesionAdmin();
        $especialidadModelo = new Especialidad();
        $especialidades = $especialidadModelo->obtenerTodas(); // ✅ CORRECTO
        require_once __DIR__ . '/../views/admin/especialidades.php';
    }


    public function reportes() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../views/admin/reportes.php";
    }

    public function agregarEspecialidad() {
        Sesion::verificarSesionAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (!empty($nombre)) {
                $especialidadModelo = new Especialidad();
                $especialidadModelo->registrarEspecialidad($nombre);
                header("Location: index.php?url=admin/especialidades");
                exit();
            } else {
                $error = "El nombre de la especialidad no puede estar vacío.";
            }
        }

        require_once __DIR__ . "/../views/admin/agregar_especialidad.php";
    }

    public function editarEspecialidad($id) {
        Sesion::verificarSesionAdmin();
        $especialidadModelo = new Especialidad();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);

            if (!empty($nombre)) {
                $especialidadModelo->actualizarEspecialidad($id, $nombre);
                header("Location: index.php?url=admin/especialidades");
                exit();
            } else {
                $error = "El nombre de la especialidad no puede estar vacío.";
            }
        } else {
            $especialidad = $especialidadModelo->obtenerPorId($id);
        }

        require_once __DIR__ . "/../views/admin/editar_especialidad.php";
    }

    public function eliminarEspecialidad($id) {
        Sesion::verificarSesionAdmin();
        $especialidadModelo = new Especialidad();
        $especialidadModelo->eliminarEspecialidad($id);
        header("Location: index.php?url=admin/especialidades");
        exit();
    }

    // Crear usuario (admin crea cuentas de médico, enfermera, recepcionista)
    public function crearUsuario() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        require_once __DIR__ . "/../models/EspecialistaExamen.php";
        require_once __DIR__ . "/../models/Medico.php";
        require_once __DIR__ . "/../models/EspecialidadMedica.php";
        require_once __DIR__ . "/../models/EspecialidadExamen.php";

        $usuarioModelo = new Usuario();
        $especialidadMedicaModelo = new EspecialidadMedica();
        $especialidadExamenModelo = new EspecialidadExamen();

        // Para cargar especialidades en el combo
        $especialidades_medicas = $especialidadMedicaModelo->obtenerTodas();
        $especialidades_examenes = $especialidadExamenModelo->obtenerTodas();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST["nombre"]);
            $apellido = trim($_POST["apellido"]);
            $dni = trim($_POST["dni"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $telefono = trim($_POST["telefono"]);
            $direccion = trim($_POST["direccion"]);
            $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
            $rol_id = intval($_POST["rol_id"]);

            if (!empty($nombre) && !empty($apellido) && !empty($dni) && !empty($email) && !empty($password)) {
                $usuario_id = $usuarioModelo->registrarUsuario(
                    $nombre, $apellido, $dni, $email, $password,
                    $telefono, $direccion, $fecha_nacimiento, $rol_id
                );

                // Si es médico (rol_id = 2), actualizar especialidad
                if ($rol_id == 2 && isset($_POST['especialidad_id'])) {
                    $usuarioModelo->actualizarEspecialidadMedico($usuario_id, $_POST['especialidad_id']);
                }

                // Si es especialista en exámenes (rol_id = 6), actualizar especialidad
                if ($rol_id == 6 && isset($_POST['especialidad_examen_id'])) {
                    $usuarioModelo->actualizarEspecialidadEspecialista($usuario_id, $_POST['especialidad_examen_id']);
                }

                header("Location: index.php?url=admin/usuarios");
                exit();
            } else {
                $error = "Todos los campos obligatorios deben estar completos.";
            }
        }

        require_once __DIR__ . "/../views/admin/crear_usuario.php";
    }


    // Editar usuario
    public function editarUsuario($id) {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST["nombre"]);
        $apellido = trim($_POST["apellido"]);
        $dni = trim($_POST["dni"]);
        $email = trim($_POST["email"]);
        $telefono = trim($_POST["telefono"]);
        $direccion = trim($_POST["direccion"]);
        $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
        $rol_id = intval($_POST["rol_id"]);

        $usuarioModelo->actualizarUsuario($id, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento, $rol_id);

        if ($rol_id == 6) { // Si es especialista de exámenes
            $especialistaExamenModelo = new EspecialistaExamen(6);
            if (!$especialistaExamenModelo->existePorUsuarioId($id)) {
                $especialistaExamenModelo->crear($id, "Sin especialidad");
            }
        }

        header("Location: index.php?url=admin/usuarios");
        exit();
    } else {
        $usuario = $usuarioModelo->obtenerUsuarioPorId($id);
    }


        require_once __DIR__ . "/../views/admin/editar_usuario.php";
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();
        $usuarioModelo->eliminarUsuario($id);
        header("Location: index.php?url=admin/usuarios");
        exit();
    }

    // Ver pacientes
    public function pacientes() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();
        $pacientes = $usuarioModelo->obtenerUsuariosPorRol(5);
        require_once __DIR__ . "/../views/admin/pacientes.php";
    }

    // Ver médicos
    public function medicos() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();
        $medicos = $usuarioModelo->obtenerUsuariosPorRol(2);
        require_once __DIR__ . "/../views/admin/medicos.php";
    }

    // Ver enfermeras
    public function enfermeras() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();
        $enfermeras = $usuarioModelo->obtenerUsuariosPorRol(3);
        require_once __DIR__ . "/../views/admin/enfermeras.php";
    }

    // Ver recepcionistas
    public function recepcionistas() {
        Sesion::verificarSesionAdmin();
        require_once __DIR__ . "/../models/Usuario.php";
        $usuarioModelo = new Usuario();
        $recepcionistas = $usuarioModelo->obtenerUsuariosPorRol(4);
        require_once __DIR__ . "/../views/admin/recepcionistas.php";
    }

    // Ver especialistas de exámenes
    public function especialistas_examenes() {
        Sesion::verificarSesionAdmin();
        $especialistaExamenModelo = new EspecialistaExamen(6);
        $especialistas = $especialistaExamenModelo->obtenerTodos();
        require_once __DIR__ . "/../views/admin/especialistas_examenes.php";
    }


    public function backup() {
        $dbUser = 'root'; // Usuario MySQL
        $dbPass = '123456';     // Contraseña MySQL
        $dbName = 'ges_citasdb'; // Cambiar por el nombre de tu base de datos

        $backupDir = 'backups/';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $command = "mysqldump --user={$dbUser} --password={$dbPass} {$dbName} > {$backupFile}";
        system($command, $output);

        if ($output === 0) {
            echo "<script>alert('Backup realizado correctamente.'); window.location='index.php?controller=admin&action=dashboard';</script>";
        } else {
            echo "<script>alert('Error al realizar el backup.'); window.location='index.php?controller=admin&action=dashboard';</script>";
        }
    }
    

}
?>
