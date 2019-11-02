<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    class UsuarioDetailsView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $datos;

        function __construct($msg=null, $errs=null, $usuario=null, $datos=null) {
            $this->usuario = $usuario;
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->datos = $datos;
        }

        function _render() { 
            ?>
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron"> 

                <!-- Tabla datos usuario -->
                <table class="table table-hover table-bordered" id="tablas" style="border-radius: 25px;">
                    <tr>
                        <th class="bg-dark" scope="col">Login</th>
                        <td><?php echo $this->datos['0']; ?></td>
                    </tr>
                    <tr>    
                        <th class="bg-dark" scope="col">Nombre</th>
                        <td><?php echo $this->datos['1']; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-dark" scope="col">Fecha de Nacimiento</th>
                        <td><?php echo $this->datos['2']; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-dark" scope="col">Teléfono</th>
                        <td><?php echo $this->datos['3']; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-dark" scope="col">Email</th>
                        <td><?php echo $this->datos['4']; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-dark" scope="col">Genero</th>
                        <td><?php echo $this->datos['5']; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-dark" scope="col">Permiso</th>
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

        <?php
        }
    }
    
?>