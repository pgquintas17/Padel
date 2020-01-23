<?php

    require_once('Views/baseView.php');
    require_once('Views/mensajeView.php');

    class AdminNoticiaView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaNoticias;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaNoticias=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('id_noticia','titulo','cuerpo','fecha_creacion');
            $this->listaNoticias = $listaNoticias;
        }

        function _render() { 
?>


        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        
        <!-- ///////////////////////////////////////////// -->
          <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Noticias</h1><br>
            <div class="row justify-content-md-center">
                <a class="bg-ligth text-dark" href='/index.php?controller=adminNoticias&action=ADD'><i class="fas fa-plus-circle fa-2x"></i></a>
            </div><br>
            <div class="row justify-content-md-center">
                
                
                <!-- Tabla noticias -->
                <div class="col-md-6" id="tablas">
                    <table class="table table-hover table-bordered"  style="border-radius: 25px; text-align: center;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Fecha creación</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php

                            while($this->fila = ($this->listaNoticias)->fetch_assoc()) {
                                $id_noticia = $this->fila['id_noticia'];          
                                $url = "/index.php?controller=adminNoticias&action=mostrar&idnoticia=". $id_noticia;
                    ?>
                                <tr class="table-light clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                                    <td><?php echo $this->fila['titulo']; ?></td>
                                    <td><?php echo date('d/m/Y',strtotime($this->fila['fecha_creacion'])); ?></td>
                                </tr>
                            
                    <?php
                    
                            }
                    
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        }
    }
    
?>