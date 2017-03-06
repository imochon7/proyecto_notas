<?php

class ControllerUsuario extends Controller {
    
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
        $this->getModel()->addData('contenido', Util::renderFile('templates/materialize/htmlusuarionologueado/iniciarsesion.html', array('error' => $mensajerror) ) );
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
        $alias = Request::read('alias');
        $listaEmailsCadena = Request::read('listaEmails');
        $listaAliasCadena = Request::read('listaAlias');
        $passwordpk = Request:: read('passwordpk');
        $passwordOld = Request::read('oldpassword');
        
        if ( empty($usuario->getPassword()) ) {
            $usuario->setPassword(null);
        }

        if(Util::verificarClave( $passwordOld, $passwordpk ) ) {
            $r = $this->getModel()->editUsuario($usuario, $idpk);
            if ($r == 1){
                $u = $this->getUser();
                
                if ( empty($usuario->getEmail()) ) {
                } else {
                    $u->setEmail($usuario->getEmail()); 
                }
                
                if ( empty($usuario->getAlias()) ) {
                } else {
                    $u->setAlias($usuario->getAlias());
                }
                
                if ( empty($usuario->getPassword()) ) {
                } else {
                    $u->setPassword($usuario->getPassword()); 
                }
                
                if ( $emailpk == $usuario->getEmail() ) {
                } else {
                    $u->setEstado(0);
                }

                $this->getSession()->setUser($u);
            }
        
            if ($emailpk == $usuario->getEmail()){ 
                header('Location: index.php?ruta=nota&accion=viewnotas');
            } else {
                return $this->viewinsert();
            }
            
        } else {
            $mensajerror = "<span class='error'>La Contraseña antigua no es correcta</span>";
            $this->getModel()->addData('contenido', Util::renderFile('templates/materialize/htmlusuariologueado/editUsuario.html',array('id'=>$idpk, 'correo'=>$emailpk, 'password'=>$passwordpk, 'alias'=>$alias, 'listaEmails'=> $listaEmailsCadena, 'listaAlias' => $listaAliasCadena, 'error'=> $mensajerror)));
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
    
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        $clave2 = Request::read('password2');
        $r = 0;
        if($usuario->isValid() && $usuario->getPassword() === $clave2) {
            $r = $this->getModel()->insertUsuario($usuario);
            return $this->viewinsert();
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
        $id = $_GET["r"];
        $r = $this->getModel()->deleteUsuario($id);
        header('Location: index.php?ruta=usuario&accion=viewlist');
        exit();
    }
    
    function dodeletenotas(){
        $id = Request::read('id');
        header('Location: index.php?ruta=nota&accion=deletenotasusuario&r=' . $id);
    }
    
    
/* ********************** VIEWS ********************** */
    
    /**
     * 
     * Creamos la función para que al darle el botón para iniciar sesión se llame
     * al archivo de la plantilla que lo contiene.
     * 
     */
     
    function viewiniciarsesion(){
        $this->getModel()->addData('titulo', 'Iniciar Sesión' );
        $this->getModel()->addFile('contenido', Util::renderFile('templates/materialize/htmlusuarionologueado/iniciarsesion.html') );
        $this->getModel()->addData('error', '');
    }
    
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
    
        $this->getModel()->addData('titulo', 'Registrarse' );
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
        
        
        $this->getModel()->addData('contenido', Util::renderFile('templates/materialize/htmlusuariologueado/editUsuario.html',array('id'=>$id, 'correo'=>$email, 'password'=>$password, 'alias'=>$alias, 'listaEmails'=> $listaEmailsCadena, 'listaAlias' => $listaAliasCadena, 'error'=> '')));
        $this->getModel()->addData('titulo', 'Editar Usuario');
    }
    
    
    /**
     *
     * Como al usuario tiene que llegarle un correo para activar su cuenta se
     * lo vamos a comunicar al usuario.
     * Lo sacamos de la aplicación, destruyendo la sesión (si estuviese creada) y 
     * lo mandamos a una página en la que le explique los motivos, y con la opción 
     * posteriormente de acceder de nuevo
     *
     */
    
    function viewinsert(){
        $this->getSession()->destroy();
        
        $this->getModel()->addFile('acceso', Util::renderFile('templates/materialize/htmlusuarionologueado/acceso.html'));
        $this->getModel()->addFile('contenido',Util::renderFile('templates/materialize/htmlusuarionologueado/mainCorreoActivacion.html'));
        $this->getModel()->addFile('seccionVentanasModales', Util::renderFile('templates/materialize/ventanasModalesNoLogueado.html'));
    }
    

    /**
     * 
     * Creamos la variable lista a la que mediante la función getList de la Clase
     * ModelUsuario habremos llenado con los usuarios de la Base de Datos.
     * Posteriormente procederemos a listarlos
     * 
     */
    
    function viewlist(){
        $lista = $this->getModel()->getList();
        $dato = '';
        
        $dato .= "<table class='tablaUsuarios'>";
        $dato .=    "<tr>";
		$dato .=        "<th>Id</th>";
		$dato .=        "<th>email</th>";
		$dato .=        "<th>password</th>";
		$dato .=        "<th>alias</th>";
		$dato .=        "<th>falta</th>";
		$dato .=        "<th>tipo</th>";
		$dato .=        "<th>estado</th>";
		$dato .=        "<th>Eliminar</th>";
		$dato .=        "<th>Editar</th>";
	    $dato .=    "</tr>";
	    
        foreach($lista as $usuario){
            $dato .= "<tr>";
            $dato .=    "<td>" . $usuario->getId() . "</td>";
            $dato .=    "<td>" . $usuario->getEmail() . "</td>";
            $dato .=    "<td>" . $usuario->getPassword() . "</td>";
            $dato .=    "<td>" . $usuario->getAlias() . "</td>";
            $dato .=    "<td>" . $usuario->getFalta() . "</td>";
            $dato .=    "<td>" . $usuario->getTipo() . "</td>";
            $dato .=    "<td>" . $usuario->getEstado() . "</td>";
            $dato .=    "<td><a class='eliminarusuario' href='index.php?ruta=usuario&accion=dodeletenotas&id=" . $usuario->getId(). "'>Eliminar</a></td>";
            $dato .=    "<td><a href='index.php?ruta=usuario&accion=vieweditcomplete&id=" . $usuario->getId(). "'>Editar</a></td>";
            $dato .= "</tr>";
        }
        $dato .= "</table>";
        
        $this->getModel()->addFile('acceso', Util::renderFile('templates/materialize/htmlusuariologueado/htmladmin/accesoAdministrador.html'));
        $this->getModel()->addData('contenido', $dato);
        $this->getModel()->addData('titulo', 'Usuarios');
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
        $passwordpk = $usuario->getPassword();
        $aliaspk = $usuario->getAlias();
        $faltapk = $usuario->getFalta();
        $tipopk = $usuario->getTipo();
        $estadopk = $usuario->getEstado();
        
        $array = array(
            'idpk' => $idpk, 'emailpk' => $emailpk, 'passwordpk' => $passwordpk, 
            'aliaspk' => $aliaspk, 'faltapk' => $faltapk, 'tipopk' => $tipopk,
            'estado' => $estadopk
        );
        
        $this->getModel()->addData('contenido', Util::renderFile('templates/materialize/htmlusuariologueado/htmladmin/editUsuarioCompleto.html', $array ) );
        $this->getModel()->addData('titulo', 'Editar Usuario: ' .  $aliaspk ); 
    }

}