<?php

class GestorNotaLista{
    
    /**
     * 
     * Declaramos el nombre de la tabla que vamos a utilizar.
     * 
     */
     
    const TABLA = 'notalista';
    private $db;
     
    function __construct(){
        $this->db = new DataBase();
    }
    
    
    /**
     *
     * Recibe un objeto de tipo Notalista y con él obtenemos cada uno de sus campos.
     *
     */
    
    private static function _getCampos(NotaLista $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    /**
     * 
     * Recibimos un objeto de la clase NotaLista, y la añadimos a la tabla
     * 
     */
    
    function add(NotaLista $objeto){
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    
    /**
     * 
     * Recibimos el id de la nota y una vez la tengamos eliminamos cada una de las filas
     * que contienen ese id de nota
     * 
     */
     
    function deleteNotaLista($idnota){
        return $this->db->deleteParameters(self::TABLA, array('idnota' => $idnota));
    }
    
    /**
     * 
     * Recibimos el id de la nota, y buscamos que filas contienen como idnota ese id
     * 
     */
    
    function get($id){
        $this->db->getCursorParameters(self::TABLA, '*', array('idnota' => $id));
        if($fila = $this->db->getRow()){
            $objeto = new NotaLista();
            $objeto->set($fila);
            return $objeto;
        }
        return new NotaLista();
    }
    
    
    /**
     * 
     * Obtenemos un objeto de tipo NotaLista y el idnotalista. Una vez, obtenidos éstos 
     * campos editamos en la tabla la fila con ese id con los campos del objeto
     * 
     */
    
    function saveNotaLista(NotaLista $objeto){
        $campos = $this->_getCampos($objeto);
        unset($campos['idnotalista']);
        unset($campos['id_nota']);
        
        var_dump($objeto);
        
        return $this->db->updateParameters(self::TABLA, $campos, array('idnotalista' => $objeto->getIdNotaLista()));
    }
    
}