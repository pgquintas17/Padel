<?php

    require_once('Views/baseView.php');
    require_once('Models/partidoModel.php');
    require_once('Views/mensajeView.php');

    class AdminPartidoView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaPartidos;
        private $listaPartidos;
        private $filaHoras;
        private $listaHoras;

        function __construct($msg=null, $errs=null, $usuario=null, $filaPartidos=null, $listaPartidos=null, $filaHoras=null, $listaHoras=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaPartidos = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
            $this->listaPartidos = $listaPartidos;
            $this->filaHoras = array('id','hora');
            $this->listaHoras = $listaHoras;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Partidos</h1><br>
            <div class="row justify-content-md-center">
                <a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=fecha'><i class="fas fa-plus-circle fa-2x"></i></a>
            </div><br>

        

        <!-- Tabla partidos -->
        <div id="tablas">
        <table class="table table-hover table-bordered" style="border-radius: 25px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Plazas libres</th>
                    <th scope="col">Promoción</th>
                </tr>
            </thead>
            <tbody>
        <?php

                while($this->filaPartidos = ($this->listaPartidos)->fetch_assoc()) {
                    $fecha = date('Y-m-d');
                    $id_partido = $this->filaPartidos['id_partido'];          
                    $url = "/index.php?controller=adminPartidos&action=DETAILS&idpartido=". $id_partido;
                    $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id_partido);
                    
                    if($this->filaPartidos['fecha'] > $fecha){
        ?>
                    
                        <?php
                        if($this->filaPartidos['promocion'] == 1){
                            ?>
                            <tr class="table-light clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                            <td><?php echo date('d/m',strtotime($this->filaPartidos['fecha'])); ?></td>
                            <td><?php echo date('H:i',strtotime($this->filaPartidos['hora']));?></td>
                            <td><?php echo $numPlazas; ?></td>
                            <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->filaPartidos['id_partido']; ?>'><i class="fas fa-toggle-on fa-2x"></i></a></td>
                            <?php
                            }
                            else{
                            ?>
                            <tr class="table-danger clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                            <td><?php echo date('d/m',strtotime($this->filaPartidos['fecha'])); ?></td>
                            <td><?php echo date('H:i',strtotime($this->filaPartidos['hora']));?></td>
                            <td><?php echo $numPlazas; ?></td>
                            <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->filaPartidos['id_partido']; ?>'><i class="fas fa-toggle-off fa-2x"></i></a></td>
                            <?php
                            }
                        }
                        else{
                        ?>
                        <tr class='clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <td class="table-secondary"><?php echo date('d/m',strtotime($this->filaPartidos['fecha'])); ?></td>
                        <td class="table-secondary"><?php echo date('H:i',strtotime($this->filaPartidos['hora'])); ?></td>
                        <td class="table-secondary"></td>
                        <td class="table-secondary"></td>
                        <?php    
                        }
                        ?>
                    </tr>
                
        <?php
        
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