<?php

class ControllerNota extends Controller{
    
    /**
     * 
     * Insertar una nota vacía.
     * Se crea una variable de tipo nota, y sacamos el id del usuario de la Sesión.
     * Después de eso volvemos a la pantalla principal visualizando las notas,
     * en la que ya estará la nueva nota insertada.
     * 
     */
    
    function doinsert() {
        $nota = new Nota();
        $nota->read();
        $id_usuario = $this->getUser()->getId();
        
        $r = $this->getModel()->insertNota($nota, $id_usuario);
        
        header('Location: index.php?ruta=nota&accion=viewnotas');
    }
    
    
    function doinsertLista(){
        $nota = new Nota();
        $nota->read();
        $notalista = new NotaLista();
        $notalista->read();
        $id_usuario = $this->getUser()->getId();
        $r = $this->getModel()->insertNota($nota, $id_usuario);
        
        $notaultima = $this->getModel()->obtenUltimoID($id_usuario);
        $id_notaultima = $notaultima->getId();
        $notalista->setLista('1');
        $notalista->setIdnota($id_notaultima);
        $r = $this->getModel()->insertNotaLista($notalista);

        header('Location: index.php?ruta=nota&accion=viewnotas');
    }
    
    /**
     * 
     * Visualizamos todas las notas de un usuario.
     * Llamamos a la función getList(pasándole el id del usuario sacado de la sesión)
     * de la Clase ModelNota. 
     * Creamos una variable vacía.
     * Posteriormente con un foreach listamos cada una de las notas. Como ya vamos a
     * tener el id de la nota podemos buscar en la Base de Datos de NotaLista si existe
     * algún texto para esa nota, y si es así sacamos cada uno de sus datos.
     * Con todos los datos que tenemos vamos metiendo en la variable vacía un div que
     * contendrá la nota, y posteriormente el formulario de la nota.
     * Posteriormente le pasamos al contenido todo el contenido de la variable para que
     * dibuje todas las notas.
     * 
     */
    
    function viewnotas(){
        $gestor = new GestorNota();
        $id_propietario = $this->getUser()->getId();
        $parametros = array("id_propietario" => "$id_propietario");
        $total = $gestor->count($parametros);
        $pc = new PageController($total, Request::get('pagina'));
        $lista = $this->getModel()->getListPaginado($id_propietario, $pc);
        $dato = Estructuras::verNotas($lista, $pc);
         
        $this->getModel()->addData('contenido', $dato);
        $this->getModel()->addData('titulo', '');   
        
    }
    
    
    /**
     * 
     * Con ésta función leemos desde la url el id del usuario, 
     * Posteriormente se lo pasamos a la función deleteNotaUsuario para que elimine
     * esas notas. 
     * Una vez las haya borrado le decimos que ahora sí puede borrar al usuario, 
     * ya que ya no hay filas que dependan de ese usuario. Para eso se debe dirigir
     * al dodelete del ControllerUsuario
     * 
     */
    
    function deletenotasusuario(){
        $id_propietario = $_GET["r"];
        $r = $this->getModel()->deleteNotaUsuario($id_propietario);
        header('Location: index.php?ruta=usuario&accion=dodelete&r=' . $id_propietario);
    }
    
    /**
     * 
     * Leemos los campos de la nota del formulario. Leemos los campos de notalista
     * del formulario.
     * Una vez hecho ésto llamamos a la función editNota de la Clase ModelNota, que 
     * será el encargado de editar la nota en la Base de Datos.
     * Ahora tenemos un problema, y es que no sabemos si ya hay un notalista creada
     * para esa nota o no. Para ambos casos lo que hay que hacer es diferente.
     * Si no está creada la notalista, que lo sabremos si no se ha leído ningún id, 
     * llamamos a la función insertNotaLista de la Clase ModelNota, y le pasamos
     * el contenido del texto, y el id del propietario.
     * Si ya está creada, procederemos a editarla, así que llamaremos a la función
     * editNotaLista de la Clase ModelNota.
     * 
     */
    
    function doedit(){
        
        $nota = new Nota();
        $nota->read();
        
        $notalista = new NotaLista();
        $notalista->read();
        
        $notaimagen = new NotaImagen();
        $notaimagen->read();
        
        $img = new FileUpload('path');
        $img->setTarget("imagenesUsuario/");
        $img->setTamano(9000000);
        $re = $img->upload();
        
        if ($re == true){
            $notaimagen->setPath( $img->getNombre() . '.' . $img->getExtension() );
            $notaimagen->setTipo( $img->getExtension() );
        }


        $r = $this->getModel()->editNota($nota, $idpk);
        if ( $notalista->getIdNotaLista() == null ){
            $this->getModel()->insertNotaLista($notalista, $nota->getId());
        } else{
            $this->getModel()->editNotaLista($notalista);
        }
        
        if ( $notaimagen->getIdNotaImagen() == null ){
            $this->getModel()->insertNotaImagen($notaimagen, $nota->getId());
        } else{
            $this->getModel()->editNotaImagen($notaimagen);
        }
        
        
        header('Location: index.php?ruta=nota&accion=viewnotas');
    }
    
    
    /**
     * 
     * Para eliminar una nota debemos de conocer el id de la nota, que la obtendremos
     * de la url. 
     * Una vez conocido ésto llamamos a la función deleteNotaUsuario de la Clase 
     * ModelNota, que se encargará de eliminar la nota de la Base de Datos Nota.
     * Y posteriormente con la función deletenotalista de la Clase ModelNota, se
     * encargará de eliminar la nota de la Base de Datos Nota Lista.
     * 
     */
     
    function eliminarnota(){
        $id_nota = $_GET["r"];
        
        $this->getModel()->deleteNotaUsuario($id_nota);
        $this->getModel()->deletenotalista($id_nota);
        
        header('Location: index.php?ruta=nota&accion=viewnotas');
    }
    
    
}