<?php

class Nota {
    private $id, $titulo, $id_propietario, $fecha, $privacidad, $color, $tipografia, $tamano;

    function __construct($id = null, $titulo = null, $id_propietario = null, $fecha = null, $privacidad = null, $color = null, $tipografia = null, $tamano = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->id_propietario = $id_propietario;
        $this->fecha = $fecha;
        $this->privacidad = $privacidad;
        $this->color = $color;
        $this->tipografia = $tipografia;
        $this->tamano = $tamano;
    }

    function getId() {
        return $this->id;
    }
    
    function getTitulo(){
        return $this->titulo;
    }

    function getId_propietario() {
        return $this->propietario;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getPrivacidad() {
        return $this->privacidad;
    }

    function getColor() {
        return $this->color;
    }

    function getTipografia() {
        return $this->tipografia;
    }

    function getTamano() {
        return $this->tamano;
    }
    

    function setId($id) {
        $this->id = $id;
    }
    
    function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    function setId_propietario($id_propietario) {
        $this->id_propietario = $id_propietario;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setPrivacidad($privacidad) {
        $this->privacidad = $privacidad;
    }

    function setColor($color) {
        $this->color = $color;
    }

    function setTipografia($tipografia) {
        $this->tipografia = $tipografia;
    }

    function setTamano($tamano) {
        $this->tamano = $tamano;
    }

    function __toString() {
        $r = '';
        foreach ($this as $key => $valor) {
            $r .= "$key => $valor - ";
        }
        return $r;
    }

    function read(ObjectReader $reader = null) {
        if ($reader === null) {
            $reader = 'Request';
        }
        foreach ($this as $key => $valor) {
            $this->$key = $reader::read($key);
        }
    }

    function get() {
        $nuevoArray = array();
        foreach ($this as $key => $valor) {
            $nuevoArray[$key] = $valor;
        }
        return $nuevoArray;
    }

    function set(array $array, $inicio = 0) {
        $this->id = $array[0 + $inicio];
        $this->titulo = $array[1 + $inicio];
        $this->id_propietario = $array[2 + $inicio];
        $this->fecha = $array[3 + $inicio];
        $this->privacidad = $array[4 + $inicio];
        $this->color = $array[5 + $inicio];
        $this->tipografia = $array[6 + $inicio];
        $this->tamano = $array[7 + $inicio];
    }

/*
    function isValid() {
        if ($this->titulo === null) {
            echo 'false';
            return false;
        }
        
        echo 'true';
        return true;
    }*/
}