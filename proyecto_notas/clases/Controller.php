<?php

class Controller {

    private $modelo, $sesion, $usuario;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('appNotas');
        
        if($this->sesion->isLogged()){
            $this->usuario=$this->sesion->getUser();
            
            if($this->usuario->getTipo() === 'administrador'){
                $this->modelo->addFile('administrar', Util::renderFile('templates/html/html-admin/administrar.html'));
                $this->modelo->addData('aliasUsuario', $this->usuario->getAlias());
            } else {
                $this->modelo->addFile('administrar', Util::renderFile('templates/html/html-user/administrar.html'));
                $this->modelo->addData('aliasUsuario', $this->usuario->getAlias());
            }
        }
        
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getSession() {
        return $this->sesion;
    }

    function getUser(){
        return $this->usuario;
    }
    
    /* acciones */

    function main() {
        
        if($this->sesion->isLogged()){
            if($this->usuario->getTipo() === 'administrador'){
                $this->modelo->addFile('administrar', Util::renderFile('templates/html/html-admin/administrar.html'));
                $this->modelo->addFile('contenido', Util::renderFile('templates/html/contenido.html'));
                $this->modelo->addData('aliasUsuario', $this->usuario->getAlias());
            } else {
                $this->modelo->addFile('administrar', Util::renderFile('templates/html/html-user/administrar.html'));
                $this->modelo->addFile('contenido', Util::renderFile('templates/html/contenido.html'));
                $this->modelo->addData('aliasUsuario', $this->usuario->getAlias());
            }
            
        }
        
    }
    
}