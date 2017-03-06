<?php

class Router {

    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Route('Model', 'View', 'Controller');
        $this->rutas['nota'] = new Route('ModelNota', 'ViewApp', 'ControllerNota');
       $this->rutas['usuario'] = new Route('ModelUsuario', 'ViewApp', 'ControllerUsuario');
       $this->rutas['usuario2'] = new Route('ModelUsuario', 'ViewMensaje', 'ControllerUsuario');
        $this->rutas['notalista'] = new Route('ModelNota', 'ViewApp', 'ControllerNota');
        $this->rutas['notaimagen'] = new Route('ModelNota', 'ViewApp', 'ControllerNota');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }

}