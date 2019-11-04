<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');

class IndexView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $partidosPromocionados;

    function __construct($msg=null, $errs=null, $usuario=null, $partidosPromocionados=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->partidosPromocionados = $partidosPromocionados;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Noticias</h1>
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-lg-4">
                    <h2>¡Hazte socio!</h2>
                    <p id="centrar" class="text-danger">¡Plazas limitadas!</p>
                    <p id="justificar">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna. </p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Nuevos campeonatos</h2>
                    <p id="justificar">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Nuevas reglas</h2>
                    <p id="justificar">Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
            </div>
        </div>
        <?php
    }
}
?>