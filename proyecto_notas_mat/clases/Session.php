<?php

class Session {

    private static $instancia = null;

    private function __construct() {
    }
    
    function close() {
        $this->delete("_usuario");
    }

    function delete($nombre) {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }

    /**
    *
    * Cierra la sesion actual.
    * 
    */
    function destroy() {
        session_destroy();
    }

    function get($nombre) {
        if (isset($_SESSION[$nombre])) {
            return $_SESSION[$nombre];
        }
        return null;
    }

    static function getInstance($nombre = null) {
        if (self::$instancia === null) {
            if ($nombre !== null) {
                session_name($nombre);
            }
            session_start();
            self::$instancia = new Session();
        }
        return self::$instancia;
    }
    
    /**
    *
    * Devuelve el usuario de la sesion.
    * 
    */
    function getUser() {
        return $this->get("_usuario");
    }

    /**
    *
    * Devuelve true si el usuario ha iniciado la sesion, false si usuario es 
    * nulo.
    * 
    */
    function isLogged() {
        return $this->getUser() !== null;
    }

    function sendRedirect($destino = "index.php") {
        header("Location: $destino");
        exit();
    }

    function set($nombre, $valor) {
        $_SESSION[$nombre] = $valor;
    }

    /**
    *
    * Asigna el usuario a la sesion.
    * (usa la funcion set($nombre, $valor))
    * 
    */
    function setUser($usuario) {
        $this->set("_usuario", $usuario);
    }

}