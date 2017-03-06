<?php

class Estructuras{
    
    /**
     * 
     * Esta función sirve para formar la estructura que va a crear la tabla que lista los
     * usuarios.
     * Recibe la lista de todos los usuarios de la Base de Datos y devuelve la cadena con la
     * estructura HTML de la tabla
     * 
     */
    
    function verUsuarios($lista, $pc){
        
        $dato = '';
        
        $dato .= "<table class='tablaUsuarios'>";
        $dato .=    "<tr>";
		$dato .=        "<th>email</th>";
		$dato .=        "<th>alias</th>";
		$dato .=        "<th>tipo</th>";
		$dato .=        "<th>estado</th>";
		$dato .=        "<th>Eliminar</th>";
		$dato .=        "<th>Editar</th>";
	    $dato .=    "</tr>";
	    
        foreach($lista as $usuario){
            $dato .= "<tr>";
            $dato .=    "<td>" . $usuario->getEmail() . "</td>";
            $dato .=    "<td>" . $usuario->getAlias() . "</td>";
            $dato .=    "<td>" . $usuario->getTipo() . "</td>";
            $dato .=    "<td>" . $usuario->getEstado() . "</td>";
            $dato .=    "<td><a class='eliminarusuario' href='index.php?ruta=usuario&accion=dodelete&id=" . $usuario->getId(). "'>Eliminar</a></td>";
            $dato .=    "<td><a href='index.php?ruta=usuario&accion=vieweditcomplete&id=" . $usuario->getId(). "'>Editar</a></td>";
            $dato .= "</tr>";
        }
        $dato .= "</table>";
        
         $dato .= "<div class='div-paginacion'>";
        $dato .=    '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=usuario&accion=viewlist&pagina='. $pc->getFirst() .'">primera</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=usuario&accion=viewlist&pagina=' .  $pc->getPrevious() . '">anterior</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=usuario&accion=viewlist&pagina=' . $pc->getNext() . '">siguiente</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=usuario&accion=viewlist&pagina='. $pc->getPages() . '">ultima</a>';
        $dato .= "</div>";
        
        return $dato;
        
    }
    
    
    
    /**
     * 
     * Esta función sirve para formar la estructura que va a crear la lista de notas de un usuario.
     * Recibe la lista de todas las notas de la Base de Datos y devuelve la cadena con la estructura 
     * HTML de las notas.
     * 
     */
    
    function verNotas($lista, $pc){
        
        $dato = '';
        
        foreach($lista as $nota){
        
            $notalista = $this->getModel()->getNotaLista($nota->getId());
            $notaimagen = $this->getModel()->getNotaImagen($nota->getId());
            $saberlista = $notalista->getLista();
                
            $dato .= "<div class='div-nota'>";
            $dato .=    "<form class='form-nota' method='POST' enctype='multipart/form-data'>";
            $dato .=        "<input type='hidden' name='ruta' value='nota'>";
            $dato .=        "<input type='hidden' name='accion' value='doedit'>";
                
            $dato .=        "<input type='hidden' name='id' value='" . $nota->getId() . "'>";
            $dato .=        "<input type='hidden' id='hidden_color' name='color' value='" . $nota->getColor() . "'>";
            $dato .=        "<input type='hidden' id='hidden_tipo' name='tipografia' value='" . $nota->getTipografia() . "'>";
            $dato .=        "<input type='hidden' id='hidden_tam' name='tamano' value='" . $nota->getTamano() . "'>";
                
            $dato .=        "<input type='hidden' name='idnotalista' value=" . $notalista->getIdNotaLista() . ">";
            $dato .=        "<input type='hidden' name='idnota' value='" . $notalista->getIdnota() . "'>";
            $dato .=        "<input type='hidden' name='lista' value='" . $notalista->getLista() . "'>";
            $dato .=        "<input type='hidden' name='id_propietario' value='" . $id_propietario . "'>";
                
            $dato .=        "<input type='hidden' name='idnotaimagen' value='" . $notaimagen->getIdNotaImagen() . "'>";
            $dato .=        "<input type='hidden' name='tipo' value='" . $notaimagen->getTipo() . "'>";
           //$dato .=        "<input type='hidden' name='name' value='" . $notalista->getText() . "'>";
            $dato .=        "<input type='hidden' class='textoculto' name='texto' value='" . $notalista->getTexto() . "'>";
                
                
            $dato .=        "<a href='?ruta=nota&accion=eliminarnota&r=" . $nota->getId() . "' class='deletebtn'><img src='templates/img/delete.png'></a>";
            $dato .=        "<input class='titulo-nota' name='titulo' value='" . $nota->getTitulo() . "'>";
            $dato .=        "</br></br>";
           
            
            if($saberlista === false || $saberlista === null || $saberlista === '0'){
            

            $dato .=        "<input type='text' class='contenido-nota' name='texto' value='" . $notalista->getTexto() . "'>";
            $dato .=        "</br></br>";

            /*   PARA INSERTAR IMAGEN O VÍDEO   */
            $dato .=        "<div class='imagenNota'>";
            if ($notaimagen->getPath() == null){
                $dato .=            "<img id='blah' src='imagenesUsuario/sinfondo.png' alt=''/>";
            } else{
            $dato .=            "<img id='blah' src='imagenesUsuario/" . $notaimagen->getPath() . "' alt=''/>";
            }
            $dato .=        "</div>";

            }else{
             // Esta linea no aparecia en el dom debido a que estaba despues de esa condicion
             // $dato .=        "<input type='hidden' class='textoculto' name='texto' value='" . $notalista->getTexto() . "'>";
             // la he pasado a la linea 89, pero nada.
            $dato .=        "<div class='contenidolista'>";
            $dato .=            "<ul class=listanotalista name='texto'>";
            /*   PARA INSERTAR UNA LISTA   */
              if($notalista->getTexto() !==null){
                  $cadena = $notalista->getTexto();
                  $array = explode("_" , $cadena);
                  foreach($array as $li){
                      $dato .= "<input type='checkbox' name='realizado' class='checklista' value=''><li class='lilista' contenteditable='true'>" . $li . "</li><span class='spanoculto'>x</span>";
                  }
              }
            $dato .=        "</ul>";   
            $dato .=        "<input type='text' class='inputlista' name='inputlista' value='' placeholder='nuevo item' >";
            $dato .=        "</div>";    
            
            }
           
            
            /*
            
            if ($notaimagen->getTipo()  !== null){
            
                if( ($notaimagen->getTipo() == 'jpg') || ($notaimagen->getTipo() == 'png') || ($notaimagen->getTipo()  == 'gif') || ($notaimagen->getTipo()  == 'jpeg') ){
                
                    $dato .=        "<div class='imagenNota'>";
                    $dato .=            "<img src='imagenesUsuario/" . $notaimagen->getPath() . "' alt=''  id='#blah'/>";
                    $dato .=        "</div>";
                    
                } else if( ($notaimagen->getTipo() == 'avi') || ($notaimagen->getTipo() == 'mpeg') || ($notaimagen->getTipo() == 'mov') || ($notaimagen->getTipo() == 'flv') ){
                    
                    $dato .=        "<div class='imagenNota'>";
                    $dato .=            "<video src='" . $notaimagen->getPath() . "' controls></video>";
                    $dato .=        "</div>";
                    
                }
                
            }
            
            */
            
            
            
                            /*   Aquí empieza el menu de la nota  */
            $dato .=        "<div id='menu-nota' class='menu-editar oculto'>";
                
            $dato .=            "<label for='tipografia'>Tipografia</label>";
            $dato .=            "<select class='sel-tipo' name='tipografia'>";
                if($nota->getTipografia() == 'Calibri'){  $dato .= "<option value='Calibri' selected>Calibri</option>";
                } else{  $dato .= "<option value='Calibri'>Calibri</option>";
                }
                if($nota->getTipografia() == 'Cambria'){  $dato .= "<option value='Cambria' selected>Cambria</option>";
                } else{  $dato .= "<option value='Cambria'>Cambria</option>";
                }
                if($nota->getTipografia() == 'Raleway'){  $dato .= "<option value='Raleway' selected>Raleway</option>";
                } else{  $dato .= "<option value='Raleway'>Raleway</option>";
                }
                if($nota->getTipografia() == 'Satellite'){  $dato .= "<option value='Satellite' selected>Satellite</option>";
                } else{  $dato .= "<option value='Satellite'>Satellite</option>";
                }
                if($nota->getTipografia() == 'Notera'){  $dato .= "<option value='Notera' selected>Notera</option>";
                } else{  $dato .= "<option value='Notera'>Notera</option>";
                }
            $dato .=            "</select>";
                
            $dato .=            "<label for='privacidad'>Compartir</label>";
            $dato .=            "<select class='sel-comp' name='privacidad'>";
                if($nota->getPrivacidad() == 'privado'){  $dato .= "<option value='privado' selected>Privado</option>";
                } else{  $dato .= "<option value='privado'>privado</option>";
                }
                if($nota->getPrivacidad() == 'publico'){  $dato .= "<option value='publico' selected>Publico</option>";
                } else{  $dato .= "<option value='publico'>publico</option>";
                }
            $dato .=            "</select>";
                    
            $dato .=            "<label for='tamano'>Tamaño</label>";
            $dato .=            "<select class='sel-tama' name='tamano'>";
                if($nota->getTamano() == '12'){  $dato .= "<option value='12' selected>12</option>";
                } else{  $dato .= "<option value='12'>12</option>";
                }
                if($nota->getTamano() == '14'){  $dato .= "<option value='14' selected>14</option>";
                } else{  $dato .= "<option value='14'>14</option>";
                }
                if($nota->getTamano() == '16'){  $dato .= "<option value='16' selected>16</option>";
                } else{  $dato .= "<option value='16'>16</option>";
                }
                if($nota->getTamano() == '18'){  $dato .= "<option value='18' selected>18</option>";
                } else{  $dato .= "<option value='18'>18</option>";
                }
                if($nota->getTamano() == '24'){  $dato .= "<option value='24' selected>24</option>";
                } else{  $dato .= "<option value='24'>24</option>";
                }
            $dato .=            "</select>";
                    
            $dato .=            "<label for='sel-color'>Color</label>";
            $dato .=            "<select id='sel-color' class='sel-color' name='color'>";
                if($nota->getColor() == 'amarillo'){  $dato .= "<option value='amarillo' selected>Amarillo</option>";
                } else{  $dato .= "<option value='amarillo'>Amarillo</option>";
                }
                if($nota->getColor() == 'rosa'){  $dato .= "<option value='rosa' selected>Rosa</option>";
                } else{ $dato .= "<option value='rosa'>Rosa</option>";
                }
                if($nota->getColor() == 'azul'){ $dato .= "<option value='azul' selected>Azul</option>";
                } else{ $dato .= "<option value='azul'>Azul</option>";
                }
                if($nota->getColor() == 'verde'){ $dato .= "<option value='verde' selected>Verde</option>";
                } else{  $dato .= "<option value='verde'>Verde</option>";
                }
            $dato .=            "</select>";
            
            
             if($saberlista === false || $saberlista === null){
                    $dato .=            "<input type='file' name='path' id='file' class='inputfile'  data-multiple-caption='{count} archivos' multiple />";
                    $dato .=            "<label for='file'><span>Subir archivo</span></label>";
                    
             }

            $dato .=            "<div class='div-submit'>";
            $dato .=                "<input type='submit' id='btn-submit-nota' class='btn-submit-nota' value='HECHO' />";                                                                                                                                                   
            $dato .=            "</div>";
            $dato .=        "</div>";
            $dato .=    "</form>";
            $dato .= "</div>";
            
        }
        $dato .= "<div class='div-paginacion'>";
        $dato .=    '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=nota&accion=viewnotas&pagina='. $pc->getFirst() .'">primera</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=nota&accion=viewnotas&pagina=' .  $pc->getPrevious() . '">anterior</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=nota&accion=viewnotas&pagina=' . $pc->getNext() . '">siguiente</a>';
        $dato .= '<a href="https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=nota&accion=viewnotas&pagina='. $pc->getPages() . '">ultima</a>';
        $dato .= "</div>";
        
        
        return $dato;
    }
    
}