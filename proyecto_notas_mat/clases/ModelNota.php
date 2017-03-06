<?php

class ModelNota extends Model{
    
    /**
     * 
     * Obtenemos Nota a traves de la funcion get de la clase GestorNotas 
     * pasandole el id, que es nuestra Primary Key.
     * 
     */
     
    function getNota($id){
        $gestor = new GestorNota();
        return $gestor->get($id);
    }
     
     
    /**
     *
     * Como buscamos insertar una nota vacía, le decimos que los campos deben ser
     * los preterminados.
     * Pero como el título no puede ser nulo por defecto ponemos que el título es Título
     *
     */ 
     
    function insertNota(Nota $nota, $id_usuario){
        date_default_timezone_set('Europe/Madrid');
        $nota->setId(null);
        $nota->setTitulo('Titulo');
        $nota->setId_propietario($id_usuario);
        $nota->setFecha(date('Y-m-d'));
        $nota->setPrivacidad('1');
        $nota->setColor('1');
        $nota->setTipografia('1');
        $nota->setTamano('1');
        
        $gestor = new GestorNota();
        return $gestor->add($nota);
    }
     
    /**
     * 
     * Leemos la nota, y se lo pasamos a la función saveNota de la Clase Gestor
     * Nota para que ella la edite en la tabla.
     * 
     */
    
    function editNota(Nota $nota){
        $gestor = new GestorNota();
        return $gestor->saveNota($nota);
    }
    

    function getNotaId($id){
        $gestor = new GestorNota();
        return $gestor->get($id);
    }


    /**
     * 
     * Llamamos a la función getList de la Clase Gestor Nota, para que al pasarle
     * el id del propietario nos de una lista de todas sus notas.
     * 
     */
    
    function getList($id_propietario){
        $gestor = new GestorNota();
        return $gestor->getList($id_propietario);
    }
    
    
    /**
     * 
     * Llamamos a la función deleteNotaUsuario de la Clase Gestor Nota, cuando al
     * pasarle el id de una nota la elimine 
     * 
     */
    
    function deleteNotaUsuario($id){
        $gestor=new GestorNota();
        return $gestor->deleteNotaUsuario($id);
    }
    
    

/* ****************** NOTA LISTA ************************** */
    
    
    /**
     * 
     * Llamamos a la función get de la Clase Gestor Nota Lista, que consiste
     * en que cuando le pasemos el id de la Nota Lista nos proporcionará todos
     * sus campos de la tabla.
     * 
     */
    
    function getNotaLista($id){
        $gestor=new GestorNotaLista();
        return $gestor->get($id);
    }
    
    
    /**
     * 
     * Insertamos una columna en la Tabla de NotaLista, para eso
     * vamos a necesitar el id de la nota.
     * Utilizamos la variable notalista en la que tenemos el texto, y le ponemos
     * el id a null porque es auto_increment, y le insertamos el id de la nota.
     * Posteriormente llamamos a la función add del GestorNotaLista para insertarlo
     * en la tabla
     * 
     */
    
    function insertNotaLista(NotaLista $notalista, $idnota){
        $notalista->setIdNotaLista(null);
        $notalista->setIdnota($idnota);

        $gestor = new GestorNotaLista();
        return $gestor->add($notalista);
    }
    
    
    /**
     * 
     * Llamamos a la función saveNotaLista para editar los campos de la nota
     * de la tabla notalista
     * 
     */
    
    function editNotaLista(NotaLista $notalista){
        $gestor = new GestorNotaLista();
        var_dump($notalista);
        return $gestor->saveNotaLista($notalista);
    }
    
    
    /**
     * 
     * Llamamos a la función deletenotalista para que a través de su id eliminemos 
     * la notalista de la tabla
     * 
     */
    
    function deletenotalista($idnota){
        $gestor = new GestorNotaLista();
        return $gestor->deleteNotaLista($idnota);
    }
    
    
/* ****************** NOTA IMAGEN ************************** */

    function getNotaImagen($id){
        $gestor=new GestorNotaImagen();
        return $gestor->get($id);
    }
    
    function insertNotaImagen(NotaImagen $notaimagen, $idnota){
        $notaimagen->setIdNotaImagen(null);
        $notaimagen->setIdnota($idnota);

        $gestor = new GestorNotaImagen();
        return $gestor->add($notaimagen);
    }
    
    function editNotaImagen(NotaImagen $notaimagen){
        $gestor = new GestorNotaImagen();
        var_dump($notaimagen);
        return $gestor->saveNotaImagen($notaimagen);
    }


}