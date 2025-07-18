<?php
// Archivo: /Gestion-Citas/core/Conexion.php

class Conexion {
    private $host = "localhost";        // Servidor (con XAMPP es localhost)
    private $db = "ges_citasdb";   // Nombre de tu base de datos
    private $user = "root";             // Usuario de XAMPP
    private $pass = "";                 // Contraseña (en XAMPP usualmente vacío)
    private $charset = "utf8mb4";       // Codificación

    public $pdo; // Conexión pública para poder usarse en modelos

    public function __construct() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mostrar errores
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Traer resultados como array asociativo
                PDO::ATTR_EMULATE_PREPARES => false, // Mejor seguridad
            ];
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>

