<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');

    class PerfilView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaReservas;
        private $listaReservas;
        private $filaPartidos;
        private $listaPartidos;
        private $filaCampeonatos;
        private $listaCampeonatos;
        

        function __construct($msg=null, $errs=null, $usuario=null, $filaReservas=null, $listaReservas=null, $filaPartidos=null, $listaPartidos=null, $filaCampeonatos=null, $listaCampeonatos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaReservas = array('id_reserva','id_pista','hora','fecha','login');
            $this->listaReservas = $listaReservas;
            $this->filaPartidos = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
            $this->listaPartidos = $listaPartidos;
            $this->filaCampeonatos = array('fecha_fin','id_campeonato', 'nombre', 'fecha_fin_inscripciones','sexonivel', 'nombre_pareja', 'capitan', 'miembro', 'id_pareja');
            $this->listaCampeonatos = $listaCampeonatos;
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
                <div id="seccion" class="col-lg-4">
                    <?php
                    if($this->listaPartidos != null) {
                    ?>
                    <!---SECCIÓN PARTIDOS--->
                    <h5>Tus partidos</h5>
                    <p id="justificar">
                    <?php
                    while($this->filaPartidos = ($this->listaPartidos)->fetch_assoc()) {
                        $id = $this->filaPartidos['id_partido'];
                        $urlP = "index.php?controller=partidos&action=borrar&idpartido=" . $id;
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
                            <p><a class="btn btn-dark" href="<?php echo $urlP; ?>" role="button">Desapuntarse</a></p>
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
                    <?php
                    }
                    ?>
                </div>

                <!---SECCIÓN RESERVAS--->
                <div id="seccion" class="col-lg-4">
                    <?php
                    if($this->listaReservas != null) {
                    ?>
                    <h5>Tus reservas</h5>
                    <p id="justificar">
                    <?php
                    while($this->filaReservas = ($this->listaReservas)->fetch_assoc()) {
                        $id = $this->filaReservas['id_reserva'];
                        $urlR = "index.php?controller=reservas&action=borrar&idreserva=" . $id;
                        $hoy = date('Y-m-d');

                        if($this->filaReservas['fecha'] > $hoy){
                            ?>
                        <li class="list-group-item">
                            <strong><?php echo date('d-m-Y',strtotime($this->filaReservas['fecha'])); ?></strong><br>
                            <p>Tienes reservada la pista <?php echo $this->filaReservas['id_pista']; ?> a las  <?php echo date('H:i',strtotime($this->filaReservas['hora'])); ?>.<br>
                            <p><a class="btn btn-dark" href="<?php echo $urlR; ?>" role="button">Cancelar</a></p>
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
                    <?php
                    }
                    ?>
                </div>

                <!---SECCIÓN CAMPEONATOS--->
                <div id="seccion" class="col-lg-4">
                    <?php
                    if($this->listaCampeonatos != null) {
                    ?>
                        <h5>Tus campeonatos</h5>
                        <p id="justificar">
                        <?php
                        while($this->filaCampeonatos = ($this->listaCampeonatos)->fetch_assoc()) {
                            $hoy = date('Y-m-d H:i:s');
                            $id = $this->filaCampeonatos['id_campeonato'];
                            $pareja = $this->filaCampeonatos['id_pareja'];
                            $fechafinins = $this->filaCampeonatos['fecha_fin_inscripciones'];
                            $urlBorrar = "index.php?controller=campeonatos&action=borrar&idpareja=" . $pareja . "&fechafininscripciones=" . $fechafinins;
                            $urlC = "index.php?controller=campeonatos&action=details&idcampeonato=" . $id;

                            if($this->filaCampeonatos['fecha_fin'] > $hoy){
                                ?>
                            <li class="list-group-item">
                                <?php
                            }
                            else{
                                ?>
                            <li class="list-group-item bg-secondary">
                                <?php
                            }
                            ?>
                                <strong><a href=<?php echo $urlC; ?>><?php echo $this->filaCampeonatos['nombre']; ?></a></strong><br>
                                <p style="text-align:left";>Estás apuntado en la categoría <strong><?php 
                                                                if($this->filaCampeonatos['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaCampeonatos['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaCampeonatos['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaCampeonatos['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaCampeonatos['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaCampeonatos['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaCampeonatos['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaCampeonatos['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaCampeonatos['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                
                                                                ?></strong>.</p>
                            <p style="text-align:left";>Pareja <strong><?php echo $this->filaCampeonatos['nombre_pareja']; ?></strong>:<br>-Capitán: <?php echo $this->filaCampeonatos['capitan']; ?><br>-Miembro: <?php echo $this->filaCampeonatos['miembro']; ?></p>
                            <?php
                            if($this->filaCampeonatos['fecha_fin_inscripciones'] > $hoy){
                                ?>
                                <p><a class="btn btn-dark" href="<?php echo $urlBorrar; ?>" role="button">Cancelar inscripción.</a></p>
                                <?php
                            }
                            ?>
                            </li>
                            <?php   
                            
                        }
                    }
                    else{
                        ?>
                        <h5>No estás apuntado a ningún campeonato.</h5>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>



        </div>

<?php
        }
    }
    
?>