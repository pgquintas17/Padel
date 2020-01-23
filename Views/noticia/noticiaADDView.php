<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class NoticiaADDView extends baseView {

        private $usuario;
        private $msg;
        private $errs;

        function __construct($msg=null, $errs=null, $usuario=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Añadir noticia</h3><br>
            <div class="row justify-content-start">
                <div class="col-2"></div>
                <a class="bg-ligth text-dark" href="/index.php?controller=adminNoticias"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br><br>
            </div>
                <div class="row">

                <div class="col-lg-2"></div>
                    <div class="bg-dark text-white rounded p-3 col-lg-8" id="perfilform">

                        <form action="/" method="POST" name="formADDNotis">

                        <input type="hidden" name="controller" value="adminNoticias">
                        <input type="hidden" name="action" value="ADD">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><strong>Título</strong></label>
                                <input type="text" class="form-control" name="titulo">
                            </div>
                            
                        </div>
                            <fieldset>
                                <textarea id="cuerpo" name="cuerpo" class="widgEditor nothing"></textarea>
                            </fieldset>
                            <button type="submit" class="btn btn-light" name="action" value="ADD" id="submit">Añadir noticia</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        <?php
        }
    }
    
?>