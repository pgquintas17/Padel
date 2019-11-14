<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Mappers/partidoMapper.php');
require_once('Models/usuarioModel.php');
require_once('Services/Utils.php');

class IndexView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $partidos;
    private $campeonatos;

    function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $partidos=null, $filaC=null, $campeonatos=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->fila = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
        $this->partidos = $partidos;
        $this->filaC = array('id_campeonato','nombre','fecha_inicio','fecha_fin','fecha_inicio_inscripciones','fecha_fin_inscripciones');
        $this->campeonatos = $campeonatos;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Noticias</h1><br>
            <!-- Example row of columns -->
            <div class="row">
                <!--PARTIDOS-->
                <div id="seccion" class="col-lg-4">
                    <?php
                         if($this->partidos != null) {
                             if(Utils::conectado()){
                            if(($_SESSION['Usuario'])->getPermiso() == 0){
                            ?>
                            <h5>¡Apúntate a nuestros partidos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                $url = "index.php?controller=partidos&action=APUNTARSE&idpartido=" . $id;
                                if($numPlazas != 0){
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    ¡Quedan <?php echo $numPlazas; ?> plazas libres!</p>
                                    <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Apuntarse</a></p>
                                </li>
                                <?php
                                }
                            }
                            ?>
                            </p>
                            <?php
                            }
                            else{
                                ?>
                            <h5>Partidos abiertos</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                $reserva = (new PartidoMapper())->getReservaById($id);
                                if($reserva == null){
                                    ?>
                                    <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    Quedan <?php echo $numPlazas; ?> plazas libres</p>
                                    <?php
                                    if($numPlazas == 0){
                                        $id = $this->fila['id_partido'];
                                        $url = "index.php?controller=adminPartidos&action=CERRAR&idpartido=" . $id;
                                        ?>
                                    <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Cerrar partido</a></p>
                                    </li>
                                <?php
                                }
                            }    
                        }
                            ?>
                            </p>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <h5>¡Únete al club para poder apuntarte a los partidos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                if($numPlazas != 0){
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    ¡Quedan <?php echo $numPlazas; ?> plazas libres!</p>
                                </li>
                                <?php
                                }
                            }
                            ?>
                            </p>
                    <?php
                    }
                }
                else{
                    ?>
                    <h5>No hay partidos disponibles en este momento.</h5>
                <?php
                }
                    ?>
                </div>

                <!--CAMPEONATOS-->
                <div id="seccion" class="col-lg-4">
                    <?php
                         if($this->campeonatos != null) {
                            if(Utils::conectado()){
                            if(($_SESSION['Usuario'])->getPermiso() == 0){
                            ?>
                            <h5>¡Apúntate a nuestros campeonatos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->filaC = ($this->campeonatos)->fetch_assoc()) {
                                $id = $this->filaC['id_campeonato'];
                                $url = "index.php?controller=campeonatos&action=inscripcion&idcampeonato=" . $id;
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo $this->filaC['nombre']; ?></strong><br>
                                    <p>Se jugará del<br> <?php echo date('d-m-y',strtotime($this->filaC['fecha_inicio'])); ?> al <?php echo date('d-m-y',strtotime($this->filaC['fecha_fin'])); ?><br>
                                    Plazo de inscripción abierto hasta el <?php echo date('d-m',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
                                    <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Inscribirse</a></p>
                                </li>
                                <?php
                            }
                            ?>
                            </p>
                            <?php
                            }
                            else{
                                ?>
                            <h5>Campeonatos en inscripción</h5>
                            <p id="justificar">
                            <?php
                            while($this->filaC = ($this->campeonatos)->fetch_assoc()) {
                                ?>
                                <li class="list-group-item">
                                <strong><?php echo $this->filaC['nombre']; ?></strong><br>
                                <p>Se jugará del<br> <?php echo date('d-m-Y',strtotime($this->filaC['fecha_inicio'])); ?> al <?php echo date('d-m-Y',strtotime($this->filaC['fecha_fin'])); ?><br>
                                Plazo de inscripción abierto hasta el <?php echo date('d-m-Y',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
                            </li>
                            <?php
                            }    
                        }
                            ?>
                            </p>
                            <?php
                    }
                    else{
                        ?>
                        <h5>¡Únete al club para poder apuntarte a los campeonatos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->filaC = ($this->campeonatos)->fetch_assoc()) {
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo $this->filaC['nombre']; ?></strong><br>
                                    <p>Se jugará del<br> <?php echo date('d-m-Y',strtotime($this->filaC['fecha_inicio'])); ?> al <?php echo date('d-m-Y',strtotime($this->filaC['fecha_fin'])); ?><br>
                                    Plazo de inscripción abierto hasta el <?php echo date('d-m-Y',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
                                </li>
                                <?php
                            }
                            ?>
                            </p>
                    <?php
                    }
                }
                else{
                    ?>
                    <h5>No hay campeonatos disponibles en este momento.</h5>
                <?php
                }
                    ?>
                </div>

                <!--GENERIC-->
                <div class="col-lg-4">
                    <h5>Clases particulares y escuelas deportivas</h5>
                    <p><img src="Views/imgs/padel.jpg" class="img-fluid" alt="Responsive image"></p>
                    <p style="text-align:justify;">¡Dentro de muy poco podrás disfrutar aprendiendo y mejorando tu técnica de la mano de nuestros expertos profesores! Se impartirán clases particulares y también grupos adaptados por nivel. ¡No te lo pierdas!</p>
                </div>
            </div>
        </div>
        <?php
    }
}
?>