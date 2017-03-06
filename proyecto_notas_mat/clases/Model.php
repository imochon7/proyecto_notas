<?php

class Model {

    private $data = array();
    private $file = array();

    function __construct() {
    }

    function addData($name, $data) {
        $this->data[$name] = $data;
    }

    function addFile($name, $file) {
        $this->data[$name] = $file;
    }

    function getData() {
        return $this->data;
    }
    
    function getFile() {
        return $this->file;
    }

}
