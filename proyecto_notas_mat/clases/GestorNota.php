<?php

class Gestornota{
    
    /**
     * 
     * Declaramos el nombre de la tabla que vamos a utilizar.
     * 
     */
     
    const TABLA = 'nota';
    private $db;
     
    function __construct(){
        $this->db = new DataBase();
    }
    
    /**
     *
     * Recibe un objeto de tipo Nota y él obtiene cada uno de sus campos.
     *
     */
    
    private static function _getCampos(Nota $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    /**
     * 
     * Le pasamos una variable 'objeto' de tipo Nota.
     * Insertamos cada uno de los campos dentro de la tabla.
     * 
     */
    
    function add(Nota $objeto){
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), false);
    }
    
    
    /**
     * 
     * Recibimos el id de una nota para luego buscar en la tabla donde está ese id,
     * una vez encontrado lo eliminamos.
     * 
     */
    
    function deleteNotaUsuario($id){
        return $this->db->deleteParameters(self::TABLA, array('id' => $id));
    }
    
    
    /**
     * 
     * Obtenemos el id de una nota, una vez lo encontremos en la tabla
     * listamos cada uno de sus campos, y se los devolvemos.
     * 
     */
    
    function get($id){
        $this->db->getCursorParameters(self::TABLA, '*', array('id' => $id));
        if($fila = $this->db->getRow()){
            $objeto = new Nota();
            $objeto->set($fila);
            return $objeto;
        }
        return new Nota();
    }
    
    
    /**
     * 
     * Recibimos el id del propietario de una nota, lo buscamos en la tabla, y
     * buscamos cada una de las notas que tienen a ese propietario. Una vez
     * lo hayamos encontrado, los listamos.
     * 
     */
    
    function getList($id_propietario){
        $this->db->getCursorParameters(self::TABLA, '*', array('id_propietario' => $id_propietario), fecha, DESC);
        $respuesta = array();
        while($fila = $this->db->getRow()){
            $objeto = new Nota();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    
    /**
     * 
     * Obtenemos el id de una nota, y con eso lo buscamos en la tabla para luego
     * listar cada uno de sus campos
     * 
     */
    
    function getNotaId($id){
        $this->db->getCursorParameters(self::TABLA, '*', array('id' => $id));
        $respuesta = array();
        while($fila = $this->db->getRow()){
            $objeto = new Nota();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    /**
     * 
     * Guardamos los Valores modificados de una nota, recibe la variable de 
     * tipo nota y el id.
     * Decimos que:
     *      -mantenemos igual el id
     *      -mantenemos igual el propietario
     *      -mantenemos igual la fecha
     * Una vez tengamos todos los datos hacemos el update a la tabla, buscando
     * la nota por su id.
     * 
     */
    
    function saveNota(Nota $objeto){
        $campos = $this->_getCampos($objeto);
        
        unset($campos['id']);
        unset($campos['id_propietario']);
        unset($campos['fecha']);
        
        return $this->db->updateParameters(self::TABLA, $campos, array('id' => $objeto->getId()));
    }
}