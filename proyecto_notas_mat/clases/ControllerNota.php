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
        
        $id_propietario = $this->getUser()->getId();
        $lista = $this->getModel()->getList($id_propietario);
        $dato = '';
        
        foreach($lista as $nota){
            
            $notalista = $this->getModel()->getNotaLista($nota->getId());
            $notaimagen = $this->getModel()->getNotaImagen($nota->getId());
            
            $dato .= "<div class='divnota'>";
            $dato .=    "<form class='formnota' method='POST' enctype='multipart/form-data'>";
            $dato .=        "<input type='hidden' name='ruta' value='nota'>";
            $dato .=        "<input type='hidden' name='accion' value='doedit'>";
            
            $dato .=        "<input type='hidden' name='id' value='" . $nota->getId() . "'>";
            $dato .=        "<input type='hidden' name='color' value='" . $nota->getColor() . "'>";
            $dato .=        "<input type='hidden' name='tipografia' value='" . $nota->getTipografia() . "'>";
            $dato .=        "<input type='hidden' name='tamano' value='" . $nota->getTamano() . "'>";
            
            $dato .=        "<input type='hidden' name='idnotalista' value=" . $notalista->getIdNotaLista() . ">";
            $dato .=        "<input type='hidden' name='idnota' value='" . $notalista->getIdnota() . "'>";
            $dato .=        "<input type='hidden' name='id_propietario' value='" . $id_propietario . "'>";
            
            $dato .=        "<input type='hidden' name='idnotaimagen' value='" . $notaimagen->getIdNotaImagen() . "'>";
            /*$dato .=        "<input type='hidden' name='path' value='" . $notaimagen->getPath() . "'>";*/
            $dato .=        "<input type='hidden' name='tipo' value='" . $notaimagen->getTipo() . "'>";
            
            
            $dato .=        "<input type='text' name='titulo' value='". $nota->getTitulo() ."'/>";
            $dato .=        "<textarea name='texto' rows='10' cols='70' />" . $notalista->getTexto() . "</textarea>";
            $dato .=        "<div class='imagenNota'>";
            $dato .=            "<img src='imagenesUsuario/" . $notaimagen->getPath() . "' alt='' />";
            $dato .=        "</div>";
                            /* Aquí empieza el menu de la nota*/
            $dato .=        "<div class='notamenu'>";
            
            $dato .=            '<div style="width:150px; display:inline-block">';
            $dato .=                '<label>Tipografias</label>';
            $dato .=                '<select class="browser-default" name="tipografia">';
            $dato .=                    '<option value="Calibri" selected>Calibri</option>';
            $dato .=                    '<option value="Cambria">Cambria</option>';
            $dato .=                    '<option value="Raleway">Raleway</option>';
            $dato .=                    '<option value="Satellite">Satellite</option>';
            $dato .=                '</select>';
            $dato .=            '</div>';
            
            $dato .=            '<div style="width:150px; display:inline-block">';
            $dato .=                '<label>Compartir</label>';
            $dato .=                '<select class="browser-default" name="privacidad" >';
            $dato .=                    '<option value="privado" selected>Privado</option>';
            $dato .=                    '<option value="publico">Publico</option>';
            $dato .=                '</select>';
            $dato .=            '</div>';
                
            $dato .=            '<div style="width:150px; display:inline-block">';
            $dato .=                '<label>Tamaño Letra</label>';
            $dato .=                '<select class="browser-default" name="tamano">';
            $dato .=                    '<option value="12" selected>12</option>';
            $dato .=                    '<option value="14">14</option>';
            $dato .=                    '<option value="16">16</option>';
            $dato .=                    '<option value="18">18</option>';
            $dato .=                    '<option value="24">24</option>';
            $dato .=                '</select>';
            $dato .=            '</div>';
                
            $dato .=            '<div style="width:150px; display:inline-block">';
            $dato .=                '<label>Color</label>';
            $dato .=                '<input name="color" type="color" value="#FDFD96" />';
            $dato .=            '</div>';
        
            $dato .=            '<div style="width:150px; display:inline-block">';
            $dato .=                '<span>File</span>';
            $dato .=                '<input type="file" name="path" />';
            $dato .=            '</div>';
                
            $dato .=            '<input type="submit" class="modal-action btn waves-green btn-flat col s12" value="HECHO">';
            $dato .=            '<li><a href="?ruta=nota&accion=eliminarnota&r=' . $nota->getId() . '">Eliminar</a></li>';                                                                                                                                                   
            $dato .=        '</div>';
            $dato .=    "</form>";
            $dato .= '</div>';
}
         
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
        
        $img = new FileUpload("path");
        $img->setTarget("imagenesUsuario/");
        $img->setTamano(90000000);
        $re = $img->upload();
        
        $notaimagen->setPath( $img->getNombre() . '.' . $img->getExtension() );
        $notaimagen->setTipo( $img->getExtension() );

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