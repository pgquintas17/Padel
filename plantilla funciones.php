<?php


 static function crearGrupos($id_catcamp){
     include '../Models/GRUPO_MODEL.php';
     include '../Models/PAREJA_MODEL.php';
     include '../Models/CATCAMP_MODEL.php';
     //AQUÍ CÓDIGO PARA ELEGIR EL NÚMERO
     $categoria = new CATCAMP_MODEL($id_catcamp,0,0,0);
     $participantes = $categoria->getNumParejas();
     $resto = 11;
     
     
     for ($i = 12; $i >= 8; $i--) {
         $resto_aux = $participantes % $i
         if ($resto_aux < $resto){
             $resto = $resto_aux;
             $n_grupos = $i;

             if($resto_aux == 0){
                $n_grupos = $i;
                break;
            }
         }
         
     }


     //HACER BUCLE PARA CREAR LOS GRUPOS
     for($j = 0; $j < $n_grupos; $j++){
         $nuevoGrupo = new GRUPO_MODEL(0,$id_catcamp);
         $nuevoGrupo->ADD();
     }
     //HACER BUCLE PARA CAMBIAR EL VALOS DE GRUPO EN LAS PAREJAS
     $parejas_grupo = $participantes / $n_grupos;
     $grupos_en_cat = new GRUPO_MODEL(0,$id_catcamp);
     $grupos = $grupos_en_cat->crearFiltros("id_catcamp");
     foreach($grupos as $grupo){
         for($i = 0; $i < $parejas_grupos; $i++){
         }
     }
     /*EJEMPLO ESTRUCTURA
     $control = new USUARIO_MODEL($login,0,0,0,0,0,0,0,$nivelRequerido);
     $resultado = $control->comprobarNivelAcceso();
     if($resultado == true)
         return true;
     else
         return false;*/
 }



          static function inscribirse_campeonato($atr,$atr,...){
     //Crear la pareja con los datos recibidos
     //Sumar 1 al n_plazas en la catcamp
     /*EJEMPLO ESTRUCTURA
     include '../Models/GRUPO_MODEL.php';
     include '../Models/PAREJA_MODEL.php';
     include '../Models/CATCAMP_MODEL.php';
     $control = new USUARIO_MODEL($login,0,0,0,0,0,0,0,$nivelRequerido);
     $resultado = $control->comprobarNivelAcceso();
     if($resultado == true)
         return true;
     else
         return false;*/
 }
 static function nivelPermiso($nivelRequerido){
     $login = $_SESSION['login'];
     include '../Models/USUARIO_MODEL.php';
     $control = new USUARIO_MODEL($login,0,0,0,0,0,0,0,$nivelRequerido);
     $resultado = $control->comprobarNivelAcceso();
     if($resultado == true)
         return true;
     else
         return false;
 }
 }