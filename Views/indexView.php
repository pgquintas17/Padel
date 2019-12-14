<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Mappers/partidoMapper.php');
require_once('Models/usuarioModel.php');
require_once('Mappers/usuarioMapper.php');
require_once('Services/Utils.php');

class IndexView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $partidos;
    private $campeonatos;
    private $noticias;

    function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $partidos=null, $filaC=null, $campeonatos=null, $filaN=null, $noticias=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->fila = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva','creador');
        $this->partidos = $partidos;
        $this->filaC = array('id_campeonato','nombre','fecha_inicio','fecha_fin','fecha_inicio_inscripciones','fecha_fin_inscripciones');
        $this->campeonatos = $campeonatos;
        $this->filaN = array('id_noticia','titulo','fecha_creacion');
        $this->noticias = $noticias;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
    </br>
            <!--Carrousel-->
            <div id="demo" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="Views/imgs/pelota.png">
                    </div>
                    <div class="carousel-item">
                    <img src="Views/imgs/pista.png">
                    </div>
                    <div class="carousel-item">
                    <img src="Views/imgs/raquetas.png">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev " href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon text-black"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
                </div>
            </br></br>

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
                                    <strong><?php echo date('d/m/Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <?php if((new UsuarioMapper())->getPermisoByLogin($this->fila['creador']) == 0){
                                    ?>
                                        <p id="centrar" class="text-danger">Partido creado por: <?php echo $this->fila['creador']; ?></p>
                                    <?php
                                    }
                                    ?>
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
                                    <strong><?php echo date('d/m/Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    Quedan <?php echo $numPlazas; ?> plazas libres</p>
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
                        <h5>¡Únete al club para poder apuntarte a los partidos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                if($numPlazas != 0){
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d/m/Y',strtotime($this->fila['fecha'])); ?></strong><br>
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
                                    <p>Se jugará del<br> <?php echo date('d/m',strtotime($this->filaC['fecha_inicio'])); ?> - <?php echo date('d/m',strtotime($this->filaC['fecha_fin'])); ?><br>
                                    Plazo de inscripción abierto hasta el <?php echo date('d/m',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
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
                                <p>Se jugará del<br> <?php echo date('d/m',strtotime($this->filaC['fecha_inicio'])); ?> al <?php echo date('d/m',strtotime($this->filaC['fecha_fin'])); ?><br>
                                Plazo de inscripción abierto hasta el <?php echo date('d/m',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
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
                                    <p>Se jugará del<br> <?php echo date('d/m',strtotime($this->filaC['fecha_inicio'])); ?> al <?php echo date('d/m',strtotime($this->filaC['fecha_fin'])); ?><br>
                                    Plazo de inscripción abierto hasta el <?php echo date('d/m',strtotime($this->filaC['fecha_fin_inscripciones'])); ?>.</p>
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

                <!--NOTICIAS-->
                <div id="seccion" class="col-lg-4">
                    <?php
                        if($this->noticias != null) {
                            ?>
                            <h5>Noticias</h5>
                            <?php
                            if(Utils::conectado()){
                            ?>
                                <p id="justificar">
                                <?php
                                while($this->filaN = ($this->noticias)->fetch_assoc()) {
                                    $id = $this->filaN['id_noticia'];
                                    if(Utils::nivelPermiso(0)){
                                        $url = "index.php?controller=noticias&idnoticia=" . $id;
                                    }
                                    if(Utils::nivelPermiso(2)){
                                        $url = "index.php?controller=adminNoticias&action=mostrar&idnoticia=" . $id;
                                    }
                                    ?>
                                    <li class="list-group-item">
                                        <p style="text-align:left;text-transform: uppercase;";><strong><?php echo $this->filaN['titulo']; ?></strong></p>
                                        <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Leer más</a></p>
                                    </li>
                                    <?php
                                    
                                }
                            ?>
                            </p>
                            <?php
                        }
                        else{
                            ?>
                                <p id="justificar">
                                <?php
                                while($this->filaN = ($this->noticias)->fetch_assoc()) {
                                ?>
                                    <li class="list-group-item">
                                        <p style="text-align:left;text-transform: uppercase;";><strong><?php echo $this->filaN['titulo']; ?></strong></p><br>
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
                        <h5>No hay noticias.</h5>
                    <?php
                    }
                        ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>