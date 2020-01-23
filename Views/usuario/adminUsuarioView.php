<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');

    class AdminUsuarioView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaUsuarios;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaUsuarios=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('login','nombre','apellidos','passwd','fecha_nac','telefono','email','genero','permiso','suscripcion');
            $this->listaUsuarios = $listaUsuarios;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Usuarios</h1><br>
            <div class="row justify-content-md-center">
                <a class="bg-ligth text-dark" href='/index.php?controller=adminUsuarios&action=ADD'><i class="fas fa-plus-circle fa-2x"></i></a>
            </div><br>

        

        <!-- Tabla usuario -->
        <div id="tablas">
            <table class="table table-hover table-bordered" style="border-radius: 25px;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Login</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
            <?php

                    while($this->fila = ($this->listaUsuarios)->fetch_assoc()) {
                        $login = $this->fila['login'];          
                        $url = "/index.php?controller=adminUsuarios&action=DETAILS&username=". $login;

                        if($this->fila['permiso'] == 0){ //DEPORTISTA
                        ?>
                            <tr class='table-light clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <?php
                        }

                        if($this->fila['permiso'] == 1){ //ENTRENADOR
                        ?>
                            <tr class='table-warning clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <?php

                        }

                        if($this->fila['permiso'] == 2){ //ADMIN
                        ?>
                            <tr class='table-success clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <?php

                        }
            ?>
                            <td><?php echo $this->fila['login']; ?></td>
                            <td><?php echo $this->fila['nombre']; ?></td>
                            <td><?php echo $this->fila['email']; ?></td>
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