<?php

class ControllerUsuario extends Controller {
    
    function destroyuser(){
        $id = Request::get('id');
        $this->getModel()->deleteUsuario($id);
        header('Location: index.php');
        exit();
    }
    
    /**
     *
     * Llamamos a la función getSession para capturar la sesión
     * y luego con la función destroy la destruimos.
     * Posteriormente nos redirige a la página de inicio
     *
     */
    
    function logout(){
        $this->getSession()->destroy();
        header('Location: index.php');
        exit();
    }
    
    
    /**
     *
     * Leemos al usuario de la Web
     * Posteriormente creamos una variable para el usuario de la Base de Datos.
     * Le insertamos los datos del usuario de la Base de Datos que posea el mismo 
     * correo que hayamos introducido en la Web.
     * Comprobamos que el Estado sea igual a 1 y que el email del usuario de la Web 
     * y el de la base de Datos sea el mismo.
     * Si lo es, procedemos a desencriptar el password. Y lo hacemos llamando a 
     * la función verificarClave de la clase Util. Al que le tenemos que pasar la
     * contraseña de la Web y posteriormente leemos el de la Base de Datos.
     * Si todo está bien iniciamos sesión y nos dirigimos a la página principal 
     * del Usuario con la vista de las notas.
     * Y algo no está bien le muestra un mensaje al usuario diciendo que o el usuario
     * o la contraseña no es correcta, para que lo vuelva a intentar.
     * 
     */
    
    function dologin() {
        $usuarioWeb = new Usuario();
        $usuarioWeb->read();
        
        $usuarioBD = $this->getModel()->getUsuario($usuarioWeb->getEmail());
        if( $usuarioBD->getEstado()==='1' && $usuarioWeb->getEmail() === $usuarioBD->getEmail() ){
            if(Util::verificarClave($usuarioWeb->getPassword(), $usuarioBD->getPassword())) {
                $this->getSession()->setUser($usuarioBD);
                header('Location: index.php?ruta=nota&accion=viewnotas');
                exit();
            }
        }
        $this->getSession()->destroy();
        $mensajerror = "<span class='error'>El usuario o la contraseña introducidos no son correctos</span>";
        header('Location: /proyecto_notas/templates/html/login.html');
    }
    
    
    /**
     *
     * La función es llamada desde el formulario de Editar Usuario.
     * Leemos el id para buscar al usuario después por su id
     * Leemos el email para luego consultar si el correo ha sido modificado
     * Y el resto de datos los leemos por si algo sale mal podamos volver a la
     * misma página.
     * Llamamos al metodo editUsuario de la clase ModelUsuario para que edite 
     * al usuario en la Base de datos
     * Actualizamos la sesión, modificando cada uno de los datos si se han editado
     * Preguntamos si el email ha sido modificado, y si lo está te dirige a la 
     * función viewinsert().
     * Si el usuario no ha modificado el email te vuelve a dirigir a la 
     * página del Usuario con el listado de las notas
     *
     */
    
    function doedit() {
        $usuario = new Usuario();
        $usuario->read();
        $idpk = Request::read('idpk');
        $emailpk = Request::read('emailpk');
        $aliaspk = Request::read('aliaspk');
        $passwordpk = Request:: read('passwordpk');
        $passwordOld = Request::read('oldpassword');
        $repassword = Request::read('password2');
        
        /* validar en php si los datos nuevos que se han introducido son válidos */

        $si_email = false;
        // Preguntar si se ha modificado el email
        if($emailpk == $usuario->getEmail()){
            //no se ha modificado
            $usuario->setEmail(null);
            $si_email = true;
        } else{
            //se ha modificado
            if( empty($usuario->getEmail()) ){
                echo "No puede estar vacio el email<br/>";
                //Está vacio el email
                //mostrar error
            }else{
                //Preguntar si se encuentra en la base de datos
                $lista = $this->getModel()->getList();
                foreach($lista as $BDusuario){
                    if( $usuario->getEmail() === $BDusuario->getEmail() ){
                        //no se puede usar este email porque está en la base de datos
                        echo "Ese email ya se encuentra en la Base de Datos<br/>";
                    }
                }
                $si_email = true;
            }
        }
        
        $si_alias = false;
        // Preguntar si se ha modificado el alias
        if($aliaspk == $usuario->getAlias()){
            //no se ha modificado
            $usuario->setAlias(null);
            $si_alias = true;
        }else{
            if( empty($usuario->getAlias()) ){
                echo "No puede estar vacio el alias<br/>";
                //Está vacio el alias
                //mostrar error
            }else{
                //Preguntar si se encuentra en la base de datos
                $lista = $this->getModel()->getList();
                foreach($lista as $BDusuario){
                    if( $usuario->getAlias() === $BDusuario->getAlias() ){
                        //no se puede usar este alias porque está en la base de datos
                        echo "Ese Alias ya se encuentra en la Base de Datos<br/>";
                    }
                }
            }
            //es correcto
            $si_alias = true;
        }
        
        $si_AntiguaClave = false;
        //Preguntar si la contraseña antigua introducida es la misma
        if(Util::verificarClave( $passwordOld, $passwordpk ) ) {
            //Es igual
            $si_AntiguaClave = true;
        }else{
            echo "La Clave actual no es correcta<br/>";
        }
        
        if ( empty($usuario->getPassword()) ){
            $usuario->setPassword(null);
        }
        
        $si_comprobarClave = false;
        if( !empty($usuario->getPassword()) && !empty($repassword) ){
            if ( $usuario->getPassword() == $repassword ){
                //esta bien
                $si_comprobarClave = true;
            }
            else{
                echo "Las contraseñas no son iguales<br/>";
            }
        }


        if( $si_email && $si_alias && $si_AntiguaClave && $si_comprobarClave ) {
            $r = $this->getModel()->editUsuario($usuario, $idpk);
            if ($r == 1){
                $u = $this->getUser();
                
                if ( empty($usuario->getEmail()) ) {
                } else {
                    $u->setEmail($usuario->getEmail());
                    $u->setEstado(0);
                }
                
                if ( empty($usuario->getAlias()) ) {
                } else {
                    $u->setAlias($usuario->getAlias());
                }
                
                if ( empty($usuario->getPassword()) ) {
                } else {
                    $u->setPassword($usuario->getPassword()); 
                }

                $this->getSession()->setUser($u);
            }
        
            if ($emailpk == $usuario->getEmail()){ 
                header('Location: index.php?ruta=nota&accion=viewnotas');
            } else {
                return $this->viewinsert();
            }
            
        } else {
            $this->getModel()->addData('contenido', Util::renderFile('templates/html/editar-perfil.html',array('id'=>$usuario->getId(), 'correo'=>$emailpk, 'password'=>$passwordpk, 'alias'=>$aliaspk)));
        }
        
    }
    
    
    /**
     *
     * Leemos al usuario que hemos escrito en los campos de Registro
     * Creamos una variable clave2 con la segunda contraseña
     * Preguntamos si el usuario es válido y si la clave que hemos escrito para el
     * usuario es la misma que la de repetir clave
     * Si lo es, llamamos al insertUsuario de la clase ModelUsuario para que nos lo inserte
     * Volvemos a la pantalla de inicio (index.php)
     *
     */
    /*
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        $clave2 = Request::read('password2');
        
        $r = 0;
        if($usuario->isValid() && $usuario->getPassword() === $clave2) {
            $r = $this->getModel()->insertUsuario($usuario);
            return $this->viewinsert();
        }
    }*/
    
    
    // ESTE SERA EL BUENO - NO BORRAR
    
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        $clave2 = Request::read('password2');
        $r = 0;
        if($usuario->isValid() && $usuario->getPassword() === $clave2) {
            $r = $this->getModel()->insertUsuario($usuario);
            if($r === -1){
               // header('Location: https://proyecto-notas-montselop.c9users.io/proyecto_notas/templates/html/mensajes.html?m=1');
                $this->getModel()->addData('contenido', 'Se conoce que el usuario ya existe.');
            }else{
                $enviado = Mail::sendMail($usuario->getEmail());
                if($enviado){
                  //  header('Location: https://proyecto-notas-montselop.c9users.io/proyecto_notas/templates/html/mensajes.html?m=2');
                    $this->getModel()->addData('contenido', 'Te hemos enviado un email para activar tu cuenta. Por favor sigue las instrucciones del mismo.');

                }else{
                  //  header('Location: https://proyecto-notas-montselop.c9users.io/proyecto_notas/templates/html/mensajes.html?m=3');
                $this->getModel()->addData('contenido', 'Ups! Parece que ha habido algún error en el proceso de activación.');
                exit();
            }
                
            }
        }
    }
    
    
    
    /**
     * 
     * Leemos el id del usuario que el administrador haya clicado.
     * Se lo pasamos a la función deleteUsuario de la Clase ModeloUsuario para
     * que lo elimine
     * 
     */
    
    function dodelete() {
        $id = Request::get('id');
        $this->getModel()->deleteUsuario($id);
        header('Location: index.php?ruta=usuario&accion=viewlist');
        exit();
    }
    
    function doactivar() {
        $email = Request::read('email');
        $iduser = Request::read('iduser');
        $r = $this->getModel()->activarUsuario($email, $iduser);
        if($r>0){
            $this->getModel()->addData('contenido', 'Activación realizada correctamente, ya se puede autentificar');
        } else {
            $this->getModel()->addData('contenido', 'Activación incorrecta, posiblemente ya estuviera activado');
        }
        
    }
    
    
/* ********************** VIEWS ********************** */
    
    /**
     * Creamos la función para que al darle al botón para registrarse se llame 
     * al archivo de la plantilla que lo contiene.
     * Además creamos las variables que tienen almacenado el listado de emails y 
     * los alias para que cuando el usuario se quiera registrar no introduzca
     * ninguno que haya sido ya utilizado 
     */
    
    function viewregistrar(){
        $lista = $this->getModel()->getList();
        
        /* Declaro las cadenas que van a contener la lista de los emails y de los alias */
        $listaEmailsCadena = "";
        $listaAliasCadena = "";

        /* Introduzco los email dentro de la cadena separadas por guiones */
        foreach($lista as $usuario){
            $listaEmailsCadena .= $usuario->getEmail();
            $listaEmailsCadena .= '-';
        }
        
        /* Introduzco los alias dentro de la cadena separadas por guiones */
        foreach($lista as $usuario){
            $listaAliasCadena .= $usuario->getAlias();
            $listaAliasCadena .= '-';
        }
    
        $this->getModel()->addFile('contenido', Util::renderFile('templates/materialize/htmlusuarionologueado/registro.html', array('listaEmails'=> $listaEmailsCadena, 'listaAlias' => $listaAliasCadena) ) );
    }
    
    /**
     *
     * Llamada a la visualización del Editor del Usuario.
     * Obtenemos de la sesión los campos que vamos a necesitar: id, email, alias.
     * Y la lista de todos los Emails y los Alias de la Base de Datos para que 
     * se pueda comprobar que el usuario no introduzca ningún email que ya esté 
     * en la base de datos.
     * Le pasamos al fichero editUsuario.html el array con los datos.
     *
     */
    
    function viewedit(){
        $usuario = $this->getSession()->getUser();
        $id = $usuario->getId();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $alias = $usuario->getAlias();
        
        $this->getModel()->addData('contenido', Util::renderFile('templates/html/editar-perfil.html',array('id'=>$id, 'correo'=>$email, 'password'=>$password, 'alias'=>$alias, 'error'=> '')));
    }
    

    /**
     * 
     * Creamos la variable lista a la que mediante la función getList de la Clase
     * ModelUsuario habremos llenado con los usuarios de la Base de Datos.
     * Posteriormente procederemos a listarlos
     * 
     */
    
    function viewlist(){
        $gestor = new GestorUsuario();
        $total = $gestor->count();
        $pc = new PageController($total, Request::get('pagina'));
        $lista = $this->getModel()->getListPaginado($pc);
        $dato = Estructuras::verUsuarios($lista, $pc);
        $this->getModel()->addData('contenido', $dato);
    }
    
    /**
     * 
     * Esta función es para visualizar un editar Usuario distinto al del Editar Perfil
     * para que así el usuario pueda modificar cualquier campo de la base de datos.
     * Para ello tenemos que pasarle todos los valores del usuario de la base de datos.
     */
     
    function vieweditcomplete(){
        $id = Request::read('id');
        
        $usuario = $this->getModel()->getUsuarioId($id);
        $idpk = $usuario->getId();
        $emailpk = $usuario->getEmail();
        $aliaspk = $usuario->getAlias();
        $faltapk = $usuario->getFalta();
        $tipopk = $usuario->getTipo();
        $estadopk = $usuario->getEstado();
        
        $array = array(
            'id' => $idpk, 'correo' => $emailpk, 'alias' => $aliaspk, 'faltapk' => $faltapk, 'tipopk' => $tipopk,
            'estado' => $estadopk
        );
        
        $this->getModel()->addData('contenido', Util::renderFile('templates/html/editar-perfil-completo.html', $array ));
    }

}