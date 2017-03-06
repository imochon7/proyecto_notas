<?php

class Usuario {

    private $id, $email, $password, $alias, $falta, $tipo, $estado;

    function __construct($id = null, $email = null, $password = null, $alias = null, $falta = null, $tipo = null, $estado = null) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->alias = $alias;
        $this->falta = $falta;
        $this->tipo = $tipo;
        $this->estado = $estado;
    }

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getAlias() {
        return $this->alias;
    }

    function getFalta() {
        return $this->falta;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setFalta($falta) {
        $this->falta = $falta;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
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
        $this->email = $array[1 + $inicio];
        $this->password = $array[2 + $inicio];
        $this->alias = $array[3 + $inicio];
        $this->falta = $array[4 + $inicio];
        $this->tipo = $array[5 + $inicio];
        $this->estado = $array[6 + $inicio];
    }

    function isValid() {
        if ($this->email === null || $this->password === null) {
            return false;
        }
        return true;
    }

}
