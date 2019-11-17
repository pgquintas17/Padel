<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/campeonatoModel.php');
    require_once('Mappers/grupoMapper.php');

    class CampeonatoView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaCampeonatos;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaCampeonatos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('id_campeonato','nombre','fecha_inicio','fecha_fin','fecha_inicio_inscripciones','fecha_fin_inscripciones');
            $this->listaCampeonatos = $listaCampeonatos;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Campeonatos</h1><br>
            
            <?php
            if(Utils::nivelPermiso(2)){
            ?>

            <div class="row justify-content-md-center">
                <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos&action=ADD'><i class="fas fa-plus-circle fa-2x"></i></a>
            </div><br>
            
            <?php
            }
            ?>
        

        <!-- Tabla campeonatos -->
        <div id="tablas">
            <table class="table table-hover table-bordered" style="border-radius: 25px;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha inicio</th>
                        <th scope="col">Fecha fin</th>
                        <th scope="col">Periodo inscripciones</th>
                        <th scope="col"></th>
                        <?php
                            if(Utils::nivelPermiso(2)){
                        ?>
                        <th scope="col"></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
            <?php

                    while($this->fila = ($this->listaCampeonatos)->fetch_assoc()) {
                        $idcampeonato = $this->fila['id_campeonato'];
                        if(Utils::nivelpermiso(2)){
                            $url = "/index.php?controller=adminCampeonatos&action=DETAILS&idcampeonato=". $idcampeonato;
                        }
                        else{
                            $url = "/index.php?controller=campeonatos&action=DETAILS&idcampeonato=". $idcampeonato;
                        }          
                        
                        $hoy = date('Y-m-d H:i:s');

                        if($this->fila['fecha_inicio'] <= $hoy && $this->fila['fecha_fin'] > $hoy){ // EN CURSO
                        ?>
                        <tr class='table-warning clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                            <td style="vertical-align: middle";><?php echo $this->fila['nombre']; ?></td>
                            <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                            <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                            <td style="vertical-align: middle";>Cerrado</td>
                            <td style="vertical-align: middle";>
                                <?php
                                    if(Utils::nivelPermiso(2)){
                                        $url = "/index.php?controller=adminCampeonatos&action=clasificacionCampeonato&idcampeonato=".$this->fila['id_campeonato'];
                                    }
                                    else{
                                        $url = "/index.php?controller=campeonatos&action=clasificacionCampeonato&idcampeonato=".$this->fila['id_campeonato'];

                                    }
                                ?>
                                <a class="text-dark" href='<?php echo $url; ?>'><i class="fas fa-list-alt"></i></a>
                            </td>
                            <?php
                                if(Utils::nivelPermiso(2)){
                                    ?>
                                    <td></td>
                                    <?php
                                }
                                ?>
                        </tr>

                        <?php
                        } else if($this->fila['fecha_fin'] < $hoy){ // FINALIZADOS
                            ?>
                            <tr class='table-secondary clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                                <td style="vertical-align: middle";><?php echo $this->fila['nombre']; ?></td>
                                <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                                <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                                <td style="vertical-align: middle";>Cerrado</td>
                                <td style="vertical-align: middle";>
                                    <?php
                                        if(Utils::nivelPermiso(2)){
                                            $url = "/index.php?controller=adminCampeonatos&action=clasificacionCampeonato&idcampeonato=".$this->fila['id_campeonato'];
                                        }
                                        else{
                                            $url = "/index.php?controller=campeonatos&action=clasificacionCampeonato&idcampeonato=".$this->fila['id_campeonato'];

                                        }
                                    ?>
                                    <a class="text-dark" href='<?php echo $url; ?>'><i class="fas fa-list-alt"></i></a>
                                </td>
                                <?php
                                if(Utils::nivelPermiso(2)){
                                    ?>
                                    <td></td>
                                    <?php
                                }
                                ?>
                            </tr>
    
                            <?php
                        }
                        else{ // PERIODO INSCRIPCIÓN O ESPERANDO A EMPEZAR
                        ?>
                            <tr class='table-light clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                                <td style="vertical-align: middle";><?php echo $this->fila['nombre']; ?></td>
                                <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                                <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                                <td style="vertical-align: middle";><?php echo date('d/m H:i',strtotime($this->fila['fecha_inicio_inscripciones'])); ?> - <?php echo date('d/m H:i',strtotime($this->fila['fecha_fin_inscripciones'])); ?></td>
                                <td style="vertical-align: middle";>
                                    <?php
                                        if(Utils::nivelPermiso(2)){
                                            if($this->fila['fecha_inicio_inscripciones'] > $hoy){
                                            ?>
                                                Pendiente de abrir
                                            <?php
                                            }else{
                                                $url = "/index.php?controller=adminCampeonatos&action=clasificacionCampeonato&idcampeonato=".$this->fila['id_campeonato'];
                                            ?>
                                                <a class="text-dark" href='<?php echo $url; ?>'><i class="fas fa-list-alt"></i></a>
                                        <?php
                                            }
                                        }
                                        else{
                                            if($this->fila['fecha_fin_inscripciones'] >= $hoy & $this->fila['fecha_inicio_inscripciones'] <= $hoy){
                                                $url = "index.php?controller=campeonatos&action=inscripcion&idcampeonato=" .$this->fila['id_campeonato'];
                                            ?>
                                                <a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Inscribirse</a>
                                            <?php

                                            } else if($this->fila['fecha_inicio_inscripciones'] > $hoy){
                                                ?>
                                                Pendiente de abrir
                                            <?php
                                            } else {
                                                $url = "index.php?controller=campeonatos&action=clasificacionCampeonato&idcampeonato=" .$this->fila['id_campeonato'];
                                            ?>
                                                <a class="text-dark" href='<?php echo $url; ?>'><i class="fas fa-list-alt"></i></a>
                                            <?php
                                            }
                                            
                                        }
                                    ?>
                                </td>
                                <?php
                                if(Utils::nivelPermiso(2) && $this->fila['fecha_fin_inscripciones'] <= $hoy && !(new GrupoMapper())->comprobarGrupos($this->fila['id_campeonato'])){
                                    $url = 'index.php?controller=adminCampeonatos&action=crearGrupos&idcampeonato=' . $this->fila['id_campeonato'];
                                    ?>
                                        <td style="vertical-align: middle";><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Crear grupos</a></td>
                                    <?php
                                }
                                else{
                                    ?>
                                    <td></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        <?php
                        }           
                    }
            
            ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
        }
    }
    
?>