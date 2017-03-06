<?php

class Router {

    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Route('Model', 'View', 'Controller');
        $this->rutas['nota'] = new Route('ModelNota', 'View', 'ControllerNota');
        $this->rutas['usuario'] = new Route('ModelUsuario', 'View', 'ControllerUsuario');
        $this->rutas['notalista'] = new Route('ModelNotaLista', 'View', 'ControllerNotaLista');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }

}