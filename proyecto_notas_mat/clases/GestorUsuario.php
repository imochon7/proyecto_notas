<?php

class Gestorusuario {
    
    /**
     * 
     * Declaramos el nombre de la Tabla que vamos a utilizar.
     * 
     */
     
    const TABLA = 'usuario';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    /**
    *
    * Recibe un objeto de tipo Usuario y él obtiene cada uno de sus campos.
    *
    */

    private static function _getCampos(Usuario $objeto) {
        $campos = $objeto->get();
        return $campos;
    }

    /**
     * 
     * Le pasamos una variable 'objeto' de tipo Usuario.
     * Insertamos cada uno de los campos dentro de la tabla.
     * 
     */

    function add(Usuario $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    function delete($id) {
        return $this->db->deleteParameters(self::TABLA, array('id' => $id));
    }
    
    /**
     * 
     * Buscamos en la base de datos por el email, ya que es lo que el usuario
     * introduce cuando desea loguearse
     * 
     */
    
    function get($email) {
        $this->db->getCursorParameters(self::TABLA, '*', array('email' => $email));
        if ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            return $objeto;
        }
        return new Usuario();
    }
    
    function getId($id) {
        $this->db->getCursorParameters(self::TABLA, '*', array('id' => $id));
        if ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            return $objeto;
        }
        return new Usuario();
    }
    
    function getList() {
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    
    /**
     *
     * No se usa, lo escribio en una explicacion de clase.
     * 
     */
     
    function getListArray() {
         $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $respuesta[] = $fila;
        }
        return $respuesta;
    }
    
/*
    function save(Usuario $objeto, $id) {
        $campos = $this->_getCampos($objeto);
        unset($campos['falta']);
        if($objeto->getPassword() === null || $objeto->getPassword() === ''){
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('id' => $id));
        //return $this->db->updateParameters(self::TABLA, $this->_getCampos($objeto), array('email' => $correopk));
    }
*/
    
    /**
     * 
     * Guardamos los Valores modificados del usuario, recibe la variable de tipo Usuario y el id
     * Decimos que:
     *      -mantenemos igual el id
     *      -mantenemos igual la falta
     *      -mantenemos igual el tipo
     *      -mantenemos igual el estado
     * Si el password se encuentra vacío, también mantenemos igual el password
     * Encriptamos el Password con la función encriptar de la Clase Util
     * Una vez encriptado se lo añadimos a campos
     * Una vez tengamos todos los datos hacemos el update a la tabla, y lo hacemos buscando al usuario por su id
     * 
     */
    
    function saveUsuario(Usuario $objeto, $idpk) {
        $campos = $this->_getCampos($objeto);
        
        if ( empty($objeto->getId()) ) {
            unset($campos['id']);
        }
        
        if ( empty($objeto->getEmail()) ) {
            unset($campos['email']);
        }
        
        if ( empty($objeto->getPassword()) ) {
            unset($campos['password']);
        } else {
            $passEncriptado = Util::encriptar($objeto->getPassword());
            $campos['password'] = $passEncriptado;
        }
        
        if ( empty($objeto->getAlias()) ) {
            unset($campos['alias']);
        }
        
        if ( empty($objeto->getFalta()) ) {
            unset($campos['falta']);
        }
        
        if ( empty($objeto->getTipo()) ) {
            unset($campos['tipo']);
        }
        
        if ( empty($objeto->getEstado()) ) {
            unset($campos['estado']);
        }
        
        return $this->db->updateParameters(self::TABLA, $campos, array('id' => $idpk));
    }

}