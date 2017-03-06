<?php

class UsuarioAutorizado {

    private $idnota, $id_usuario_autorizado;

    function __construct($idnota = null, $id_usuario_autorizado = null) {
        $this->idnota = $idnota;
        $this->id_usuario_autorizado = $id_usuario_autorizado;
    }

    function getIdnota() {
        return $this->idnota;
    }

    function getId_usuario_autorizado() {
        return $this->id_usuario_autorizado;
    }

    function setIdnota($idnota) {
        $this->idnota = $idnota;
    }

    function setId_usuario_autorizado($id_usuario_autorizado) {
        $this->id_usuario_autorizado = $id_usuario_autorizado;
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
        $this->idnota = $array[0 + $inicio];
        $this->id_usuario_autorizado = $array[1 + $inicio];
    }

    function isValid() {
        if ($this->idnota === null) {
            return false;
        }
        return true;
    }

}