<?php

class Gestornotaimagen{
    
    /**
     * 
     * Declaramos el nombre de la tabla que vamos a utilizar.
     * 
     */
     
    const TABLA = 'notaimagen';
    private $db;
     
    function __construct(){
        $this->db = new DataBase();
    }
    
    /**
     *
     * Recibe un objeto de tipo NotaImagen y él obtiene cada uno de sus campos.
     *
     */
    
    private static function _getCampos(NotaImagen $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    
    /**
     * 
     * Recibimos un objeto de la clase NotaLista, y la añadimos a la tabla
     * 
     */
    
    function add(NotaImagen $objeto){
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    
    /**
     * 
     * Recibimos el id de la nota, y buscamos que filas contienen como idnota ese id
     * 
     */
    
    function get($id){
        $this->db->getCursorParameters(self::TABLA, '*', array('idnota' => $id));
        if($fila = $this->db->getRow()){
            $objeto = new NotaImagen();
            $objeto->set($fila);
            return $objeto;
        }
        return new NotaImagen();
    }
    
    /**
     * 
     * Obtenemos un objeto de tipo NotaLista y el idnotalista. Una vez, obtenidos éstos 
     * campos editamos en la tabla la fila con ese id con los campos del objeto
     * 
     */
    
    function saveNotaImagen(NotaImagen $objeto){
        $campos = $this->_getCampos($objeto);
        unset($campos['idnotaimagen']);
        unset($campos['idnota']);
        
        if ( empty($objeto->getPath()) ) {
            unset($campos['path']);
            unset($campos['tipo']);
        }
        
        return $this->db->updateParameters(self::TABLA, $campos, array('idnotaimagen' => $objeto->getIdNotaImagen()));
    }
    
}