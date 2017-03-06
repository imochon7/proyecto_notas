<?php

class View {

    private $modelo;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
    }

    function getModel() {
        return $this->modelo;
    }

    /**
    *
    * Trabaja con un objeto de la clase modelo.
    * @ $plantilla: Contiene la ruta donde se encuentran las plantillas.
    * Aqui se coloca nuestro index.html. 
    * 
    */
    function render() {
        $plantilla = './templates/materialize';
        $this->getModel()->addData('plantilla', $plantilla);
        return Util::renderFile($plantilla . '/index.html', $this->getModel()->getData());
    }

}