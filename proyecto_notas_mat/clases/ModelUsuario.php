<?php

class ModelUsuario extends Model {
    
    /**
     *
     * Optenemos el Usuario a través de la función get de la clase GestorUsurio
     * pasándole el email, ya que es lo que le pedimos al usuario que inserte 
     * para iniciar sesión.
     *
     */

    function getUsuario($email){
        $gestor = new GestorUsuario();
        return $gestor->get($email);
    }
    
    
    /**
     *
     * Optenemos el Usuario a través de la función get de la clase GestorUsurio
     * pasándole el id, ya que es nuestra Primary Key.
     *
     */
    
    function getUsuarioId($id){
        $gestor = new GestorUsuario();
        return $gestor->getId($id);
    }
    
    
    /**
     *
     * Recibimos los campos que el usuario escribe, y el resto los rellenamos nosotros mismos.
     * 
     * ID: Lo ponemos null ya que es auto_increment y él mismo al hacer la inserción sumará uno
     * Email: La recibimos de $usuario
     * Password: La recibimos de $usuario
     *   Pero además la añadimos a la BD encriptada, desde la función encriptar de la clase Util
     * Alias: Lo recibimos de $usuario
     * Fecha(yyyy-mm-dd): cogemos la fecha Actual, con horario de Europa/Madrid
     * Tipo: Por defecto ponemos que todos los usuarios al registrarse son 'usuarios'
     * Estado: Por defecto ponemos 0 hasta que la cambie con el correo
     * 
     * Una vez tengas todos los datos desde la clase GestorUsuario añades al usuario 
     * a la Base de Datos
     *
     */
    
    function insertUsuario(Usuario $usuario){
        date_default_timezone_set('Europe/Madrid');
        $usuario->setId(null);
        $usuario->setFalta(date('Y-m-d'));
        $usuario->setTipo('usuario');
        $usuario->setEstado(0);
        $usuario->setPassword(Util::encriptar($usuario->getPassword()));
        $gestor = new GestorUsuario();
        return $gestor->add($usuario);
    }
    
    
    /**
     * 
     * Leemos el usuario, solo con los campos que han sido modificados, y además el id
     * Le pasamos toda esa información a la función saveUsuario de la Clase GestorUsuario
     * 
     */
    
    function editUsuario(Usuario $usuario, $idpk){
        $gestor = new GestorUsuario();
        return $gestor->saveUsuario($usuario, $idpk);
    }
    
    
    /**
     * 
     * Llamamos a la función getList de la Clase GestorUsuario para listar a todos
     * los usuarios de la Base de Datos.
     * 
     */
    
    function getList(){
        $gestor = new GestorUsuario();
        return $gestor->getList();
    }
    
    
    /**
     * 
     * Llamamos a la función delete de la Clase GestorUsuario, y le pasamos el 
     * id del usuario para saber a qué usuario debemos eliminar 
     * 
     */
    
    function deleteUsuario($id){
        $gestor=new GestorUsuario();
        return $gestor->delete($id);
    }
    
}