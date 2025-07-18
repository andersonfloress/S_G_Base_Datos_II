<?php
// Archivo: /Gestion-Citas/models/Usuario.php

require_once __DIR__ . "/../core/Conexion.php";

class Usuario {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    // Registrar un nuevo usuario (paciente, médico, recepcionista, admin)
    public function registrarUsuario($nombre, $apellido, $dni, $email, $password, $telefono, $direccion, $fecha_nacimiento, $rol_id) {
        $sql = "INSERT INTO usuarios (nombre, apellido, dni, email, password, telefono, direccion, fecha_nacimiento, rol_id) 
                VALUES (:nombre, :apellido, :dni, :email, :password, :telefono, :direccion, :fecha_nacimiento, :rol_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':dni' => $dni,
            ':email' => $email,
            ':password' => $password,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':rol_id' => $rol_id
        ]);
        return $this->pdo->lastInsertId();
    }

    // Obtener usuario por email (login)
    public function obtenerUsuarioPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // Obtener usuario por DNI (opcional para verificar duplicados)
    public function obtenerUsuarioPorDni($dni) {
        $sql = "SELECT * FROM usuarios WHERE dni = :dni";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetch();
    }

    // Obtener todos los usuarios (admin)
    public function obtenerTodosUsuarios() {
        $sql = "SELECT usuarios.*, roles.nombre AS rol_nombre 
                FROM usuarios 
                JOIN roles ON usuarios.rol_id = roles.id 
                ORDER BY usuarios.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Obtener usuario por ID
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Actualizar usuario
    public function actualizarUsuario($id, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento, $rol_id) {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email,
                    telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, rol_id = :rol_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':dni' => $dni,
            ':email' => $email,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':rol_id' => $rol_id
        ]);
    }
    
    // Actualizar datos de perfil del paciente (sin cambiar rol_id)
    public function actualizarUsuarioPerfil($id, $nombre, $apellido, $dni, $email, $telefono, $direccion, $fecha_nacimiento) {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email,
                    telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':dni' => $dni,
            ':email' => $email,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':fecha_nacimiento' => $fecha_nacimiento
        ]);
    }
    public function obtenerUsuariosPorRol($rol_id) {
        $sql = "SELECT * FROM usuarios WHERE rol_id = :rol_id ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':rol_id' => $rol_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    // Método para actualizar especialidad del médico
    public function actualizarEspecialidadMedico($usuario_id, $especialidad_id) {
        $sql = "UPDATE medicos SET especialidad_id = :especialidad_id WHERE usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':especialidad_id' => $especialidad_id,
            ':usuario_id' => $usuario_id
        ]);
    }

    // Método para actualizar especialidad del especialista en exámenes
    public function actualizarEspecialidadEspecialista($usuario_id, $especialidad_examen_id) {
        $sql = "UPDATE especialista_examenes SET especialidad_examen_id = :especialidad_examen_id WHERE usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':especialidad_examen_id' => $especialidad_examen_id,
            ':usuario_id' => $usuario_id
        ]);
    }

    // Obtener especialidades médicas
    public function obtenerEspecialidades() {
        $sql = "SELECT * FROM especialidades ORDER BY nombre";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener especialidades de exámenes
    public function obtenerEspecialidadesExamenes() {
        $sql = "SELECT * FROM especialidad_examenes ORDER BY nombre";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
