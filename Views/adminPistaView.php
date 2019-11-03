<?php

    require_once('Views/baseView.php');
    require_once('Models/pistaModel.php');

    class AdminPistaView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaPistas;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaPistas=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('idpista','estado');
            $this->listaPistas = $listaPistas;
        }

        function _render() { 
?>
          <!-- Jumbotron -->
      <div  id="espacio_info" class="jumbotron">
        <h1>Pistas</h1><br>
        <div class="row justify-content-md-center">
            <!-- Tabla pistas -->
            <div class="col-md-4">
                <table class="table table-hover table-bordered" id="tablas" style="border-radius: 25px; text-align: center;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Número de pista</th>
                            <th scope="col">Abrir/cerrar</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php

                        while($this->fila = ($this->listaPistas)->fetch_assoc()) {
                ?>
                            <tr>
                            <?php
                                if($this->fila['estado'] == 1){
                            ?>
                                <td class="table-light"><?php echo $this->fila['id_pista']; ?></td>
                                <td class="table-light"><a class="bg-ligth text-dark" href='/index.php?controller=adminPista&action=ESTADO&idpista=<?php echo $this->fila['id_pista']; ?>'><i class="fas fa-toggle-on fa-2x"></i></a></td>
                            <?php
                                }
                                else{
                            ?>
                                <td class="table-danger"><?php echo $this->fila['id_pista']; ?></td>
                                <td class="table-danger"><a class="bg-ligth text-dark" href='/index.php?controller=adminPista&action=ESTADO&idpista=<?php echo $this->fila['id_pista']; ?>'><i class="fas fa-toggle-off fa-2x"></i></a></td>
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
    </div>

<?php
        }
    }
    
?>