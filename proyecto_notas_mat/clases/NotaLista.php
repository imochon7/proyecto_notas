<?php

class NotaLista {
    
    private $idnotalista, $idnota, $texto;
    
    function __construct($idnotalista = null, $idnota = null, $texto = null) {
        $this->idnotalista = $idnotalista;
        $this->idnota = $idnota;
        $this->texto = $texto;
    }
    
    function getIdNotaLista() {
        return $this->idnotalista;
    }

    function getIdnota() {
        return $this->idnota;
    }

    function getTexto() {
        return $this->texto;
    }

    function setIdNotaLista($idnotalista) {
        $this->idnotalista = $idnotalista;
    }

    function setIdnota($idnota) {
        $this->idnota = $idnota;
    }

    function setTexto($texto) {
        $this->texto = $texto;
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
        $this->idnotalista = $array[0 + $inicio];
        $this->idnota = $array[1 + $inicio];
        $this->texto = $array[2 + $inicio];
    }
    
    function isValid() {
        if ($this->idnotalista === null) {
            return false;
        }
        return true;
    }
    
}