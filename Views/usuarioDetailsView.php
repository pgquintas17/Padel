<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    class UsuarioDetailsView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $datos;

        function __construct($msg=null, $errs=null, $usuario=null, $datos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->datos = $datos;
        }

        function _render() { 
            ?>
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <h3>Usuario: <?php echo $this->datos['1']; ?></h3><br>
                <div class="row justify-content-md-center">
                    <div class="col-md-auto"> 

                        <!-- Tabla datos usuario -->
                        <table class="table table-hover table-bordered" id="tablas" style="border-radius: 25px;">
                            <tr>
                            <th class="bg-dark text-white">Login</th>
                                <td><?php echo $this->datos['0']; ?></td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Nombre</th>
                                <td><?php echo $this->datos['1']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Fecha de Nacimiento</th>
                                <td><?php echo $this->datos['2']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Teléfono</th>
                                <td><?php echo $this->datos['3']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Email</th>
                                <td><?php echo $this->datos['4']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Genero</th>
                                <td><?php echo $this->datos['5']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Permiso</th>
                                <td>
                                    <?php 
                                        if($this->datos['6'] == 0)
                                            echo "Deportista";
                                        if($this->datos['6'] == 1)
                                            echo "Entrenador";
                                        if($this->datos['6'] == 2)
                                            echo "Administrador"; 
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        <?php
        }
    }
    
?>