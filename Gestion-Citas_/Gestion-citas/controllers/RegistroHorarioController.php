<?php
// /controllers/RegistroHorarioController.php

require_once __DIR__ . '/../models/RegistroHorario.php';
require_once __DIR__ . '/../core/Sesion.php';

class RegistroHorarioController
{

    private function ipEnRedPermitida($ip, $subredesPermitidas) {
        foreach ($subredesPermitidas as $subred) {
            if (strpos($ip, $subred) === 0) {
                return true;
            }
        }
        return false;
    }

    public function marcarEntrada()
    {
        Sesion::verificarSesion();

        $usuario_id = $_SESSION["usuario_id"];

        // Lista de subredes permitidas
        $ip_usuario = $_SERVER['REMOTE_ADDR'];
        $ip_permitida = '192.168.15.';

        if ($ip_usuario !== '::1' && $ip_usuario !== '127.0.0.1' && strpos($ip_usuario, $ip_permitida) !== 0) {
            $error = "Solo puedes marcar tu entrada dentro de la red institucional.";
            require_once __DIR__ . '/../views/horarios/mensaje.php';
            exit();
        }


        $modelo = new RegistroHorario();
        $fecha = date('Y-m-d');
        $hora_entrada = date('H:i:s');

        if ($modelo->registrarEntrada($usuario_id, $fecha, $hora_entrada)) {
            $mensaje = "Entrada registrada correctamente a las $hora_entrada.";
        } else {
            $mensaje = "Ya registraste tu entrada hoy o hubo un error.";
        }

        require_once __DIR__ . '/../views/horarios/mensaje.php';
    }


    public function marcarSalida()
    {
        Sesion::verificarSesion();

        $usuario_id = $_SESSION["usuario_id"];

        // Validar IP de red interna
        $ip_usuario = $_SERVER['REMOTE_ADDR'];
        $ip_permitida = '192.168.15.';

        if ($ip_usuario !== '::1' && $ip_usuario !== '127.0.0.1' && strpos($ip_usuario, $ip_permitida) !== 0) {
            $error = "Solo puedes marcar tu salida dentro de la red institucional.";
            require_once __DIR__ . '/../views/horarios/mensaje.php';
            exit();
        }




        $modelo = new RegistroHorario();
        $fecha = date('Y-m-d');
        $hora_salida = date('H:i:s');

        if ($modelo->registrarSalida($usuario_id, $fecha, $hora_salida)) {
            $mensaje = "Salida registrada correctamente a las $hora_salida.";
        } else {
            $mensaje = "No puedes registrar salida antes de la entrada o ya registraste salida.";
        }

        require_once __DIR__ . '/../views/horarios/mensaje.php';
    }
}
?>
