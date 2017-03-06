<?php

class NotaImagen {

    private $idnotaimagen, $idnota, $path, $tipo;
    
    function __construct($idnotaimagen = null, $idnota = null, $path = null, $tipo = null) {
        $this->idnotaimagen = $idnotaimagen;
        $this->idnota = $idnota;
        $this->path = $path;
        $this->tipo = $tipo;
    }
    
    function getIdNotaImagen() {
        return $this->idnotaimagen;
    }

    function getIdnota() {
        return $this->idnota;
    }

    function getPath() {
        return $this->path;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setIdNotaImagen($idnotaimagen) {
        $this->idnotaimagen = $idnotaimagen;
    }

    function setIdnota($idnota) {
        $this->idnota = $idnota;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
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
        $this->idnotaimagen = $array[0 + $inicio];
        $this->idnota = $array[1 + $inicio];
        $this->path = $array[2 + $inicio];
        $this->tipo = $array[3 + $inicio];
    }

    function isValid() {
        if ($this->id === null) {
            return false;
        }
        return true;
    }

    
}
