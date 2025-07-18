<?php
require_once __DIR__ . "/../core/Conexion.php";

class RegistroHorario
{
    private $pdo;
    private $ipsPermitidas = [
        '192.168.15.',   // Ejemplo de red local de hospital
            // Otra red local permitida si deseas
    ];

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * Verifica si el usuario está conectado a la red permitida.
     */
    private function redPermitida()
    {
        $ipUsuario = $_SERVER['REMOTE_ADDR'];

        foreach ($this->ipsPermitidas as $subred) {
            if (strpos($ipUsuario, $subred) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Registrar entrada y salida del personal SOLO si está en red permitida.
     */
    public function registrarHorario($usuario_id, $hora_entrada, $hora_salida)
    {
        if (!$this->redPermitida()) {
            return [
                "exito" => false,
                "mensaje" => "El registro de horario solo es posible desde la red del hospital."
            ];
        }

        $fecha_actual = date('Y-m-d');

        $sql = "INSERT INTO registro_horarios (usuario_id, fecha, hora_entrada, hora_salida)
                VALUES (:usuario_id, :fecha, :hora_entrada, :hora_salida)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':fecha' => $fecha_actual,
            ':hora_entrada' => $hora_entrada,
            ':hora_salida' => $hora_salida
        ]);

        return [
            "exito" => true,
            "mensaje" => "Horario registrado correctamente."
        ];
    }

    /**
     * Obtener horarios por usuario y fecha (opcional).
     */
    public function obtenerHorariosPorUsuario($usuario_id)
    {
        $sql = "SELECT * FROM registro_horarios WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los registros de horarios.
     */
    public function obtenerTodos()
    {
        $sql = "SELECT rh.*, u.nombre, u.apellido, u.rol_id
                FROM registro_horarios rh
                INNER JOIN usuarios u ON rh.usuario_id = u.id
                ORDER BY rh.fecha DESC, rh.hora_entrada ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarEntrada($usuario_id, $fecha, $hora_entrada) {
        // Verificar si ya hay un registro de entrada hoy
        $sql = "SELECT COUNT(*) FROM registro_horarios WHERE usuario_id = :usuario_id AND fecha = :fecha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id, ':fecha' => $fecha]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Ya tiene entrada hoy
        }

        // Insertar nuevo registro de entrada
        $sql = "INSERT INTO registro_horarios (usuario_id, fecha, hora_entrada) VALUES (:usuario_id, :fecha, :hora_entrada)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':fecha' => $fecha,
            ':hora_entrada' => $hora_entrada
        ]);
    }

    public function registrarSalida($usuario_id, $fecha, $hora_salida) {
        // Verificar si ya tiene salida registrada hoy
        $sql = "SELECT hora_salida FROM registro_horarios WHERE usuario_id = :usuario_id AND fecha = :fecha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id, ':fecha' => $fecha]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            return false; // No hay registro de entrada aún
        }

        if (!empty($resultado['hora_salida'])) {
            return false; // Ya registró salida
        }

        // Actualizar hora de salida
        $sql = "UPDATE registro_horarios SET hora_salida = :hora_salida WHERE usuario_id = :usuario_id AND fecha = :fecha";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':hora_salida' => $hora_salida,
            ':usuario_id' => $usuario_id,
            ':fecha' => $fecha
        ]);
    }

}
?>
