<?php

class Controller {

    private $modelo, $sesion, $usuario;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('appNotas');
        
        if($this->sesion->isLogged()){
            $this->usuario=$this->sesion->getUser();
            
            if($this->usuario->getTipo()=== 'administrador'){
                $this->modelo->addFile('acceso', Util::renderFile('templates/materialize/htmlusuariologueado/htmladmin/accesoAdministrador.html'));
            } else {
                $this->modelo->addFile('acceso', Util::renderFile('templates/materialize/htmlusuariologueado/htmluser/accesoUsuario.html'));
            }
            
            $this->modelo->addFile('seccionMain', Util::renderFile('templates/materialize/htmlusuariologueado/mainLogueado.html'));
            $this->modelo->addFile('seccionVentanasModales', ' ');
        } else {
            $this->modelo->addFile('acceso', Util::renderFile('templates/materialize/htmlusuarionologueado/acceso.html'));
            $this->modelo->addFile('seccionMain', Util::renderFile('templates/materialize/htmlusuarionologueado/mainnologueado.html'));
            $this->modelo->addFile('seccionVentanasModales', Util::renderFile('templates/materialize/ventanasModalesNoLogueado.html'));
        }
        
        $this->modelo->addFile('logo', Util::renderFile('templates/materialize/logo.html'));
        $this->modelo->addData('titleIndex','MIMSOFT');
        $this->modelo->addData('titulo', '');
        
        
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
            if($this->usuario->getTipo()=== 'administrador'){
                $this->modelo->addFile('acceso', Util::renderFile('templates/materialize/htmlusuariologueado/htmladmin/accesoAdministrador.html'));
                $this->modelo->addFile('contenido', Util::renderFile('templates/materialize/htmlusuariologueado/htmladmin/contenidoAdmin.html'));
            } else {
                $this->modelo->addFile('acceso', Util::renderFile('templates/materialize/htmlusuariologueado/htmluser/accesoUsuario.html'));
                $this->modelo->addFile('contenido', Util::renderFile('templates/materialize/htmlusuariologueado/htmluser/contenidoUser.html'));
            }
            
        } else {
            $this->modelo->addData('contenido','no logueado');
        }
        
    }
    
}