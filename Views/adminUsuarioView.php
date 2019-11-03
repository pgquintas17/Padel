<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');

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
            $this->fila = array('login','nombre','apellidos','passwd','fecha_nac','telefono','email','genero','permiso');
            $this->listaUsuarios = $listaUsuarios;
        }

        function _render() { 
?>
          <!-- Jumbotron -->
      <div  id="espacio_info" class="jumbotron">
        <h1>Usuarios</h1><br>
        <div class="row justify-content-md-center">
            <a class="bg-ligth text-dark" href='/index.php?controller=adminUsuarios&action=ADD'><i class="fas fa-plus-circle fa-2x"></i></a>
        </div><br>

        

        <!-- Tabla usuario -->

        <table class="table table-hover table-bordered" id="tablas" style="border-radius: 25px;">
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
        ?>
                    <tr class='clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <td class="table-light"><?php echo $this->fila['login']; ?></td>
                        <td class="table-light"><?php echo $this->fila['nombre']; ?></td>
                        <td class="table-light"><?php echo $this->fila['email']; ?></td>
                    </tr>
                
        <?php
        
                }
        
        ?>
            </tbody>
        </table>
    </div>

<?php
        }
    }
    
?>