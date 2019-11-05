<?php

    require_once('Views/baseView.php');
    require_once('Models/partidoModel.php');
    require_once('Views/mensajeView.php');

    class AdminPartidoView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaPartidos;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaPartidos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('id_partido','resultado','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
            $this->listaPartidos = $listaPartidos;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Partidos</h1><br>
            <!--<div class="row justify-content-md-center">
                <a class="bg-ligth text-dark" href='/index.php?controller=adminUsuarios&action=ADD'><i class="fas fa-plus-circle fa-2x"></i></a>
            </div><br>-->

        

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

                while($this->fila = ($this->listaPartidos)->fetch_assoc()) {
                    $fecha = date('Y-m-d');
                    $id_partido = $this->fila['id_partido'];          
                    $url = "/index.php?controller=adminPartidos&action=DETAILS&idpartido=". $id_partido;
                    $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id_partido);
                    
                    if($this->fila['fecha'] >= $fecha){
        ?>
                    <tr class='clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <td class="table-light"><?php echo $this->fila['fecha']; ?></td>
                        <td class="table-light"><?php echo $this->fila['hora']; ?></td>
                        <td class="table-light"><?php echo $numPlazas; ?></td>
                        <?php
                        if($this->fila['promocion'] == 1){
                            ?>
                            <td class="table-light"><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->fila['id_partido']; ?>'><i class="fas fa-toggle-on fa-2x"></i></a></td>
                            <?php
                            }
                            else{
                            ?>
                            <td class="table-danger"><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->fila['id_partido']; ?>'><i class="fas fa-toggle-off fa-2x"></i></a></td>
                            <?php
                            }
                        }
                        else{
                        ?>
                        <tr class='clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <td class="table-secondary"><?php echo $this->fila['fecha']; ?></td>
                        <td class="table-secondary"><?php echo $this->fila['hora']; ?></td>
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