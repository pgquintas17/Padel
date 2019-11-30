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
                    return 'Usuario modificado correctamente';
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
                
                return "Usuario borrado correctamente.";
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
                    FROM USUARIO
                    ORDER BY permiso DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return null;
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
                return null;
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


        function validarExisteDeportista($usuario){

            $login = $usuario->getLogin();

            $sql = "SELECT * FROM USUARIO 
                    WHERE login = '$login' AND permiso = '0'";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0){
                return true;
            }
            else{
                return false;
            }
        }


        function getSexoByLogin($usuario){

            $login = $usuario->getLogin();

            $sql = "SELECT * FROM USUARIO
                    WHERE login = '$login'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                return $tupla['6'];
            }
        }


        function getAdmin(){

            $sql = "SELECT * FROM USUARIO
                    WHERE  (permiso = '2') LIMIT 1";
                
                $resultado = $this->mysqli->query($sql);
                
                if ($resultado->num_rows == 0)
                    return null;
                else{
                    $tupla = $resultado->fetch_array(MYSQLI_NUM);
                    return new UsuarioModel($tupla[0], $tupla[1], $tupla[2], $tupla[3], $tupla[4], $tupla[5], $tupla[6], $tupla[7]);        
                }
        }

        function getPermisoByLogin($login){

            $sql = "SELECT * FROM USUARIO WHERE login = '$login'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['7'];
        }


        function capitanPareja($usuario,$pareja1,$pareja2){

            $id_pareja1 = $pareja1->getId();
            $id_pareja2 = $pareja2->getId();

            $login = $usuario->getLogin();

            $sql = "SELECT capitan FROM PAREJA WHERE capitan = '$login' AND (id_pareja = '$id_pareja1' OR id_pareja = '$id_pareja2')";

            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                    return false;
                else{
                    return true;        
                }

        }


    }

?>