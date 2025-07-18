<?php
// Archivo: /Gestion-Citas/models/Recepcionista.php

require_once __DIR__ . "/../core/Conexion.php";

class Recepcionista {

    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Registrar recepcionista tras crear el usuario
     */
    public function registrarRecepcionista($usuario_id, $turno) {
        $sql = "INSERT INTO recepcionistas (usuario_id, turno)
                VALUES (:usuario_id, :turno)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':turno' => $turno
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Obtener todos los recepcionistas
     */
    public function obtenerTodosRecepcionistas() {
        $sql = "SELECT r.*, u.nombre, u.email
                FROM recepcionistas r
                INNER JOIN usuarios u ON r.usuario_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener recepcionista por ID
     */
    public function obtenerRecepcionistaPorId($id) {
        $sql = "SELECT r.*, u.nombre, u.email
                FROM recepcionistas r
                INNER JOIN usuarios u ON r.usuario_id = u.id
                WHERE r.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Obtener recepcionista por usuario_id
     */
    public function obtenerRecepcionistaPorUsuarioId($usuario_id) {
        $sql = "SELECT r.*, u.nombre, u.email
                FROM recepcionistas r
                INNER JOIN usuarios u ON r.usuario_id = u.id
                WHERE r.usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetch();
    }

    /**
     * Actualizar datos del recepcionista
     */
    public function actualizarRecepcionista($id, $turno) {
        $sql = "UPDATE recepcionistas 
                SET turno = :turno
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':turno' => $turno
        ]);
    }

    /**
     * Eliminar recepcionista
     */
    public function eliminarRecepcionista($id) {
        $sql = "DELETE FROM recepcionistas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function obtenerTodasLasCitas($filtros = []) {
        $sql = "
            SELECT c.*, u.nombre, u.apellido, u.dni, e.nombre AS especialidad
            FROM citas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN usuarios u ON p.usuario_id = u.id
            INNER JOIN especialidades e ON c.especialidad_id = e.id
            WHERE 1
        ";

        $params = [];

        if (!empty($filtros['dni'])) {
            $sql .= " AND u.dni = :dni";
            $params['dni'] = $filtros['dni'];
        }
        if (!empty($filtros['nombre'])) {
            $sql .= " AND u.nombre LIKE :nombre";
            $params['nombre'] = '%' . $filtros['nombre'] . '%';
        }
        if (!empty($filtros['fecha'])) {
            $sql .= " AND c.fecha = :fecha";
            $params['fecha'] = $filtros['fecha'];
        }

        $sql .= " ORDER BY c.fecha, c.hora";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function actualizarEstadoCita($cita_id, $estado) {
        $sql = "UPDATE citas SET estado = :estado WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $cita_id,
            'estado' => $estado
        ]);
    }

    public function eliminarCita($cita_id) {
        $sql = "DELETE FROM citas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $cita_id]);
    }

    public function registrarCita($paciente_id, $medico_id, $especialidad_id, $fecha, $hora, $motivo_cita) {
        $sql = "
            INSERT INTO citas (paciente_id, medico_id, especialidad_id, fecha, hora, motivo_cita)
            VALUES (:paciente_id, :medico_id, :especialidad_id, :fecha, :hora, :motivo_cita)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'paciente_id' => $paciente_id,
            'medico_id' => $medico_id,
            'especialidad_id' => $especialidad_id,
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo_cita' => $motivo_cita
        ]);
    }

    public function buscarPacientePorDniONombre($filtro) {
        $sql = "SELECT * FROM vista_pacientes_con_edad
                WHERE dni = :filtro OR nombre LIKE :filtro_like
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'filtro' => $filtro,
            'filtro_like' => '%' . $filtro . '%'
        ]);
        return $stmt->fetch();
    }


    public function registrarPaciente($nombre, $apellido, $dni, $email, $password, $telefono, $direccion, $fecha_nacimiento) {
        $this->pdo->beginTransaction();

        $sql_usuario = "
            INSERT INTO usuarios (nombre, apellido, dni, email, password, telefono, direccion, fecha_nacimiento, rol_id)
            VALUES (:nombre, :apellido, :dni, :email, :password, :telefono, :direccion, :fecha_nacimiento, 5)
        ";
        $stmt_usuario = $this->pdo->prepare($sql_usuario);
        $stmt_usuario->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'telefono' => $telefono,
            'direccion' => $direccion,
            'fecha_nacimiento' => $fecha_nacimiento
        ]);

        $usuario_id = $this->pdo->lastInsertId();

        $sql_paciente = "INSERT INTO pacientes (usuario_id) VALUES (:usuario_id)";
        $stmt_paciente = $this->pdo->prepare($sql_paciente);
        $stmt_paciente->execute(['usuario_id' => $usuario_id]);

        $this->pdo->commit();

        return $this->pdo->lastInsertId();
    }

    public function obtenerTodosLosPacientes() {
        $sql = "
            SELECT *
            FROM vista_pacientes_datos
            ORDER BY apellido, nombre
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }


    public function obtenerPacientePorId($paciente_id) {
        $sql = "
            SELECT *
            FROM vista_pacientes_con_edad
            WHERE paciente_id = :paciente_id
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['paciente_id' => $paciente_id]);
        return $stmt->fetch();
    }

    public function obtenerCitaPorId($cita_id) {
        $sql = "
            SELECT c.*, u.nombre, u.apellido, u.dni, e.nombre AS especialidad
            FROM citas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN usuarios u ON p.usuario_id = u.id
            INNER JOIN especialidades e ON c.especialidad_id = e.id
            WHERE c.id = :id
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $cita_id]);
        return $stmt->fetch();
    }

    public function actualizarCita($cita_id, $fecha, $hora, $motivo_cita) {
        $sql = "UPDATE citas SET fecha = :fecha, hora = :hora, motivo_cita = :motivo_cita WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo_cita' => $motivo_cita,
            'id' => $cita_id
        ]);
    }


}
?>
