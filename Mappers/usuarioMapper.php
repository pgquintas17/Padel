<?php

require_once('Models/usuarioModel.php');

    class UsuarioMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($usuario){

            $login = $usuario->getLogin();
            $nombre = $usuario->getNombre();
            $password = $usuario->getPassword();
            $fechaNac = $usuario->getFechaNac();
            $telefono = $usuario->getTelefono();
            $email = $usuario->getEmail();
            $genero = $usuario->getGenero();
            $permiso = $usuario->getPermiso();

            if (($login <> '')){ 
    
                $sql = "SELECT * FROM USUARIO WHERE (login = '$login')";
    
                if (!$result = $this->mysqli->query($sql)) 
                    return 'No se ha podido conectar con la base de datos'; 
                else { 
                    if ($result->num_rows == 0){ 
                    
                        $sql = "INSERT INTO USUARIO (
                                login,
                                nombre,
                                password,
                                fecha_nac,
                                telefono,
                                email,
                                genero,
                                permiso
                            )
                            VALUES (
                                '$login',
                                '$nombre',
                                '$password',
                                '$fechaNac',
                                '$telefono',
                                '$email',
                                '$genero',
                                '$permiso'
                            )";
    
                        if (!$this->mysqli->query($sql)) 
                            return 'Error en la inserción';
                        else 
                            return 'Inserción realizada con éxito'; 
                    }
                    else 
                        return 'Ya existe en la base de datos'; 
                }
            }
            else 
                return 'Introduzca un valor'; 
        }



        function EDIT($usuario) {

            $login = $usuario->getLogin();
            $nombre = $usuario->getNombre();
            $password = $usuario->getPassword();
            $fechaNac = $usuario->getFechaNac();
            $telefono = $usuario->getTelefono();
            $email = $usuario->getEmail();
            $genero = $usuario->getGenero();
	
            $sql = "SELECT * FROM USUARIO  WHERE (login = '$login')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE USUARIO  SET
                            nombre = '$nombre',
                            password = '$password',
                            fecha_nac = '$fechaNac',
                            telefono = '$telefono',
                            email = '$email',
                            genero = '$genero'
    
                        WHERE ( login = '$login')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Modificado correctamente';
            }
            else 
                return 'No existe en la base de datos';
        }


        function DELETE($usuario) {	

            $login = $usuario->getLogin();
		
            $sql = "SELECT * FROM USUARIO  WHERE (login = '$login') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  USUARIO WHERE (login = '$login')";   
                $this->mysqli->query($sql);
                
                return "Borrado correctamente";
            } 
            else
                return "No existe";
        }


        function mostrarTodos() {
		
            $sql = "SELECT 
                        login,
                        nombre,
                        fecha_nac,
                        telefono,
                        email,
                        genero,
                        permiso 
                    FROM USUARIO";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }


        function consultarDatos($usuario) {	

            $login = $usuario->getLogin();

            $sql = "SELECT * FROM USUARIO WHERE (login = '$login')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }



        function Login($usuario){

            $login = $usuario->getLogin();
            $passwd = $usuario->getPassword();

            $sql = "SELECT * FROM USUARIO
                WHERE  (login = '$login' AND password = '$passwd')";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'Error con el login o contraseña.';
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                return new UsuarioModel($tupla[0], $tupla[1], $tupla[2], $tupla[3], $tupla[4], $tupla[5], $tupla[6], $tupla[7]);        
            }
        }
    
    
        function comprobarNivelAcceso($usuario,$nivelAcceso){

            $login = $usuario->getLogin();
            
            $sql = "SELECT * FROM USUARIO WHERE ((login = '$login') && (permiso = '$nivelAcceso'))";
            
            if (!($resultado = $this->mysqli->query($sql)))
                return false;
    
            if ($resultado->num_rows == 1)
                return true;
            else 
                return false;
        }


        function crearFiltros($usuario,$filtros) {
            $toret = "( ";

            $login = $usuario->getLogin();
            $nombre = $usuario->getNombre();
            $fechaNac = $usuario->getFechaNac();
            $telefono = $usuario->getTelefono();
            $email = $usuario->getEmail();
            $genero = $usuario->getGenero();
            $permiso = $usuario->getPermiso();

            foreach($filtros as $filtro) {
                switch($filtro) {
                    case "login":
                        $toret .= "(login = '$login')";
                        break;
                    case "nombre":
                        $toret .= "(nombre = '$nombre')";
                        break;
                    case "fecha_nac":
                        $toret .= "(fecha_nac = '$fechaNac')";
                        break;
                    case "telefono":
                        $toret .= "(telefono = '$telefono')";
                        break;
                    case "email":
                        $toret .= "(email = '$email')";
                        break;
                    case "genero":
                        $toret .= "(genero = '$genero')";
                        break;
                    case "permiso":
                        $toret .= "(permiso = '$permiso')";
                        break;
                }
                $toret .= " && ";
            }
            $toret = chop($toret," && ");
            $toret .= " )";
    
            $sql = "SELECT * FROM USUARIO WHERE " . $toret;
    
            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else 
                return $resultado;
        }


    }

?>