<?php

    require_once('Views/baseView.php');
    require_once('Models/reservaModel.php');
    require_once('Views/mensajeView.php');
    

    class AdminReservaPistaView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $idpista;
        private $fila;
        private $lista;

        function __construct($msg=null, $errs=null, $usuario=null, $idpista=null, $fila=null, $lista=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->idpista = $idpista;
            $this->fila = array('id_reserva','id_pista','hora','fecha','login');
            $this->lista = $lista;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Reservas en pista <?php echo $this->idpista; ?></h1><br>
            <div class="row justify-content-around">
                <a class="bg-ligth text-dark" href="/index.php?controller=adminPistas"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
            </div><br>

        

        <!-- Tabla partidos -->
        <div id="tablas" class="row center-content-md-center">
        <div class="col-md-2"></div>
        <table class="table table-hover table-bordered col-md-8" style="border-radius: 25px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Usuario</th>
                </tr>
            </thead>
            <tbody>
        <?php

                while($this->fila = ($this->lista)->fetch_assoc()) {
                    $fecha = date('Y-m-d');
                    
                    if($this->fila['fecha'] >= $fecha){
        ?>
                    <tr class="table-light">
                    <td><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></td>
                    <td><?php echo date('H:i',strtotime($this->fila['hora']));?></td>
                    <td><?php echo $this->fila['login']; ?></td>
                    <?php
                        
                    }
                    else{
                    ?>
                    <tr class='table-secondary'>
                    <td><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></td>
                    <td><?php echo date('H:i',strtotime($this->fila['hora'])); ?></td>
                    <td><?php echo $this->fila['login']; ?></td>
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