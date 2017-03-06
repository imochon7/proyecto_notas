<?php

class ViewApp {

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
        $plantilla = './templates/html';
        $this->getModel()->addData('plantilla', $plantilla);
        return Util::renderFile($plantilla . '/index-app.html', $this->getModel()->getData());
    }

}