<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/campeonatoModel.php');

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
                        <th scope="col1">Periodo inscripciones</th>
                        <th scope="col1"></th>
                    </tr>
                </thead>
                <tbody>
            <?php

                    while($this->fila = ($this->listaCampeonatos)->fetch_assoc()) {
                        $idcampeonato = $this->fila['id_campeonato'];          
                        $url = "/index.php?controller=campeonato&action=DETAILS&idCampeonato=". $idcampeonato;

                        $hoy = date('Y-m-d H:i:s');
                        if(($this->fila['fecha_inicio_inscripciones'] <= $hoy && $this->fila['fecha_fin_inscripciones'] >= $hoy) || $this->fila['fecha_inicio_inscripciones'] > $hoy){ // EN PERIODO DE INSCRIPCION O A ESPERA DE ABRIR
                        ?>
                        <tr class='table-light clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                            <td><?php echo $this->fila['nombre']; ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_inicio_inscripciones'])); ?> hasta <?php echo date('d-m-Y H:i:s',strtotime($this->fila['fecha_fin_inscripciones'])); ?></td>
                            <td>Crear Grupos</td>
                        </tr>

                        <?php
                        }

                        if(($this->fila['fecha_inicio'] <= $hoy && $this->fila['fecha_fin'] > $hoy) || $this->fila['fecha_fin_inscripciones'] <= $hoy){ // EN CURSO O A ESPERA DE EMPEZAR
                        ?>
                        <tr class='table-warning clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                            <td><?php echo $this->fila['nombre']; ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                            <td>Cerrado</td>
                            <td></td>
                        </tr>

                        <?php
                        }

                        if($this->fila['fecha_fin'] < $hoy){ // FINALIZADOS
                            ?>
                            <tr class='table-secondary clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                                <td><?php echo $this->fila['nombre']; ?></td>
                                <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_inicio'])); ?></td>
                            <td><?php echo date('d-m-Y H:i',strtotime($this->fila['fecha_fin'])); ?></td>
                            <td>Cerrado</td>
                            <td>Ver clasificación</td>
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