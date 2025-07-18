<?php
// Archivo: /Gestion-Citas/core/App.php

/**
 * Clase de enrutamiento central del sistema de gestión de citas.
 * Controla el controlador, método y parámetros de cada petición.
 *
 * @property object $controlador Instancia del controlador actual
 */
class App {
    /**
     * @var string|object
     */
    protected $controlador = "UsuarioController"; // Controlador por defecto

    /**
     * @var string
     */
    protected $metodo = "index"; // Método por defecto

    /**
     * @var array
     */
    protected $parametros = []; // Parámetros de la URL

    public function __construct() {
        $url = $this->parseUrl();

        // Verificar si el controlador existe en la URL
        if (isset($url[0])) {
            $controladorNombre = ucfirst($url[0]) . "Controller";
            $rutaControlador = __DIR__ . "/../controllers/" . $controladorNombre . ".php";

            if (file_exists($rutaControlador)) {
                $this->controlador = $controladorNombre;
                unset($url[0]);
            } else {
                die(" Error: El controlador <strong>$controladorNombre</strong> no existe.");
            }
        }

        // Incluir el archivo del controlador
        require_once __DIR__ . "/../controllers/" . $this->controlador . ".php";

        /** @var object $this->controlador Instancia del controlador actual */
        $this->controlador = new $this->controlador;

        // Verificar si el método existe en la URL
        if (isset($url[1])) {
            if (method_exists($this->controlador, $url[1])) {
                $this->metodo = $url[1];
                unset($url[1]);
            } else {
                die(" Error: El método <strong>{$url[1]}()</strong> no existe en el controlador <strong>" . get_class($this->controlador) . "</strong>.");
            }
        } else {
            // Verificar si el método por defecto existe
            if (!method_exists($this->controlador, $this->metodo)) {
                die(" Error: El método por defecto <strong>index()</strong> no existe en el controlador <strong>" . get_class($this->controlador) . "</strong>.");
            }
        }

        // El resto de la URL serán parámetros
        $this->parametros = $url ? array_values($url) : [];

        // Llamar al método del controlador con los parámetros
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
    }

    /**
     * Separa la URL en partes
     * @return array
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
?>
