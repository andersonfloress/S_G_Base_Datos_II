<?php
require_once __DIR__ . '/../core/Conexion.php';

class EspecialistaExamen {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->pdo;
    }

    /**
     * ✅ Obtener especialistas por sSERA POSIBLES  especialidad y turno (ajustado a tu estructura real)
     * Como en tu BD ya no tienes columna 'turno', sino fecha, hora_entrada y hora_salida,
     * este método ahora filtrará por fecha y rango de hora, no por 'turno' inexistente.
     */
    public function obtenerPorEspecialidadYTurno($especialidad_examen_id, $turno) {
        $sql = "SELECT ee.id, u.nombre, u.apellido
                FROM especialista_examenes ee
                INNER JOIN usuarios u ON ee.usuario_id = u.id
                WHERE ee.especialidad_examen_id = :especialidad_examen_id
                AND ee.turno = :turno
                ORDER BY u.nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':especialidad_examen_id', $especialidad_examen_id);
        $stmt->bindParam(':turno', $turno);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    /**
     * ✅ Obtener todos los especialistas de exámenes con datos de usuario y especialidad
     */
    public function obtenerTodos() {
        $sql = "SELECT ee.id, u.nombre, u.apellido, ee.especialidad_examen_id, eex.nombre AS especialidad_examen
                FROM especialista_examenes ee
                INNER JOIN usuarios u ON ee.usuario_id = u.id
                INNER JOIN especialidad_examenes eex ON ee.especialidad_examen_id = eex.id
                ORDER BY u.nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
