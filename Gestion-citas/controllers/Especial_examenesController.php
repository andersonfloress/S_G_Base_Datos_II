<?php
require_once __DIR__ . "/../core/Conexion.php";
require_once __DIR__ . "/../core/Sesion.php";
require_once __DIR__ ."/../models/especial_examenes.php";

class Especial_ExamenesController{
    private $model;

    public function __construct()
    {
        $this->model = new EspecialistaExamen();
    }

    // Mostrar el dashboard
    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?url=auth/login");
            exit();
        }
        require_once 'views/espe_examenes/dashboard.php';
    }

    // Mostrar próximas citas
    public function verProximasCitas(){
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?url=especial_examenes/verProximasCitas");
            exit();
        }

        $especialista_id = $_SESSION['usuario_id'];
        $citas = $this->model->obtenerProximasCitas($especialista_id);
        
        require_once 'views/espe_examenes/verProximasCitas.php';
    }
    // Marcar examen como hecho
    public function marcarExamenHecho(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cita_id'])) {
            $cita_id = $_POST['cita_id'];
            $this->model->marcarExamenHecho($cita_id);
        }
        header("Location: index.php?url=especial_examenes/verProximasCitas");
    }

    // Subir resultados PDF
    public function subirResultados()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cita_id']) && isset($_FILES['archivo_pdf'])) {
            $cita_id = $_POST['cita_id'];
            $archivo = $_FILES['archivo_pdf'];

            if ($archivo['error'] === UPLOAD_ERR_OK) {
                $nombre_archivo = uniqid() . "_" . basename($archivo['name']);
                $ruta_destino = "uploads/resultados/" . $nombre_archivo;

                if (!file_exists("uploads/resultados")) {
                    mkdir("uploads/resultados", 0777, true);
                }

                if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                    $this->model->guardarResultados($cita_id, $nombre_archivo);

                    // Aquí podrías enviar notificación al paciente si deseas
                }
            }
        }
        header("Location: index.php?url=especial_examenes/verProximasCitas");
    }

    // Notificar resultado listo para recojo presencial
    public function notificarResultadoListo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cita_id'])) {
            $cita_id = $_POST['cita_id'];
            $this->model->notificarResultadoListo($cita_id);
        }
        header("Location: index.php?url=especial_examenes/verProximasCitas");
    }
    }
?>