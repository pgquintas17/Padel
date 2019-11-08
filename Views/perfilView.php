<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');

    class PerfilView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaPartidos;
        private $listaPartidos;
        private $filaHoras;
        private $listaHoras;

        function __construct($msg=null, $errs=null, $usuario=null, $filaReservas=null, $listaReservas=null, $filaPartidos=null, $listaPartidos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaReservas = array('id_reserva','id_pista','hora','fecha','login');
            $this->listaReservas = $listaReservas;
            $this->filaPartidos = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
            $this->listaPartidos = $listaPartidos;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Hola, <?php echo $_SESSION['Usuario']->getNombre(); ?></h1><br>
            <p>Haz click <a href='index.php?controller=perfil&action=EDIT'>aquí</a> para editar tus datos.

            <div class="row">
                <div id="partidos" class="col-lg-4">
                    <?php
                    if($this->listaPartidos != null) {
                    ?>
                    <h5>Tus partidos</h5>
                    <p id="justificar">
                    <?php
                    while($this->filaPartidos = ($this->listaPartidos)->fetch_assoc()) {
                        $id = $this->filaPartidos['id_partido'];
                        $url = "index.php?controller=partidos&action=BORRARSE&idpartido=" . $id;
                        $hoy = date('Y-m-d');

                        if($this->filaPartidos['fecha'] > $hoy){
                            ?>
                        <li class="list-group-item">
                            <strong><?php echo date('d-m-Y',strtotime($this->filaPartidos['fecha'])); ?></strong><br>
                            <p>Se jugará a las <?php echo date('H:i',strtotime($this->filaPartidos['hora'])); ?>. <br>
                        <?php
                        if($this->filaPartidos['id_reserva'] != NULL){
                            require_once('Models/reservaModel.php');
                            $reserva = new ReservaModel();
                            $reserva->setId($this->filaPartidos['id_reserva']);
                            require_once('Mappers/reservaMapper.php');
                            $reservaMapper = new ReservaMapper();
                            $idPista = $reservaMapper->getPistaById($reserva);
                        ?>
                            Se jugará en la pista número <?php echo $idPista['0']; ?></p>
                        <?php
                        }
                        else{
                        ?>
                            La pista aún está por determinar.</p>
                        <?php
                        }
                        ?>
                            <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Desapuntarse</a></p>
                        </li>
                        <?php
                        }
                        else{
                            require_once('Models/reservaModel.php');
                            $reserva = new ReservaModel();
                            $reserva->setId($this->filaPartidos['id_reserva']);
                            require_once('Mappers/reservaMapper.php');
                            $reservaMapper = new ReservaMapper();
                            $idPista = $reservaMapper->getPistaById($reserva);
                        ?>
                        <li class="list-group-item bg-secondary">
                        <strong><?php echo date('d-m-Y',strtotime($this->filaPartidos['fecha'])); ?></strong><br>
                        <p>El partido se jugó a las <?php echo date('H:i',strtotime($this->filaPartidos['hora'])); ?> en la pista número <?php echo $idPista['0']; ?>.</p>
                        <?php

                        }
                        
                    }
                    }
                    else{
                        ?>
                        <h5>No estás apuntado en ningún partido.</h5>
                        <
                    <?php
                    }
                    ?>
                </div>
                <div id="partidos" class="col-lg-4">
                    <?php
                    if($this->listaReservas != null) {
                    ?>
                    <h5>Tus reservas</h5>
                    <p id="justificar">
                    <?php
                    while($this->filaReservas = ($this->listaReservas)->fetch_assoc()) {
                        $id = $this->filaReservas['id_reserva'];
                        $url = "index.php?controller=reservas&action=BORRAR&idreserva=" . $id;
                        $hoy = date('Y-m-d');

                        if($this->filaReservas['fecha'] > $hoy){
                            ?>
                        <li class="list-group-item">
                            <strong><?php echo date('d-m-Y',strtotime($this->filaReservas['fecha'])); ?></strong><br>
                            <p>Tienes reservada la pista <?php echo $this->filaReservas['id_pista']; ?> a las  <?php echo date('H:i',strtotime($this->filaReservas['hora'])); ?>.<br>
                            <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Cancelar</a></p>
                        </li>
                        <?php
                        }
                        else{
                        ?>
                        <li class="list-group-item bg-secondary">
                        <strong><?php echo date('d-m-Y',strtotime($this->filaReservas['fecha'])); ?></strong><br>
                        <p>Reservaste la pista número <?php echo $this->filaReservas['id_pista']; ?> a las  <?php echo date('H:i',strtotime($this->filaReservas['hora'])); ?>.<br>
                        <?php

                        }
                        
                    }
                    }
                    else{
                        ?>
                        <h5>No tienes reservas de pistas.</h5>
                        <
                    <?php
                    }
                    ?>
                </div>
                <div class="col-lg-4">
                    <h5>Tus campeonatos</h5>
                    <p id="justificar">Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                </div>
            </div>
        </div>



        </div>

<?php
        }
    }
    
?>