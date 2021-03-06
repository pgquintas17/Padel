<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class UsuarioADDView extends baseView {

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
            <br><h3>Añadir usuario</h3><br>
            <div class="row justify-content-start">
                <div class="col-2"></div>
                <a class="bg-ligth text-dark" href="/index.php?controller=adminUsuarios"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
            </div>
                <div class="row">

                    <div class="col-lg-3"></div>
                    <div class="bg-dark text-white rounded p-3 col-lg-6" id="perfilform">

                        <!-- Formulario datos usuario -->
                        <form action="/" method="POST" name="formADDUsers">

                        <input type="hidden" name="controller" value="adminUsuarios">
                        <input type="hidden" name="action" value="ADD">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Login</label>
                                    <input type="text" class="form-control" name="inputLogin">
                                </div>
                                <div class="form-group col-md-6">
                                <label>Nombre</label>
                                    <input type="text" class="form-control" name="inputNombre">
                                </div>
                            </div>    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputFechaNac">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="inputFechaNac">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTelefono">Telefono</label>
                                    <input type="text" class="form-control" name="inputTelefono">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputGenero">Género</label>
                                <div class="form-check row">
                                <label><div class="col-md-1">
                                        <input class="form-check-input" type="radio" name="inputGenero" value="femenino">
                                    </div>
                                    <div class="col-md-1">
                                        Mujer
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                <label><div class="col-md-1">
                                        <input class="form-check-input" type="radio" name="inputGenero" value="masculino">
                                    </div>
                                    <div class="col-md-1">
                                        Hombre
                                    </div></label>
                                </div>  
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="inputEmail">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Permiso</label>
                                <div class="form-check row">
                                <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputPermiso" value="0">
                                    </div>
                                    <div class="col-md-2">
                                        Deportista
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputPermiso" value="1">
                                    </div>
                                    <div class="col-md-2">
                                        Entrenador
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputPermiso" value="2">
                                    </div>
                                    <div class="col-md-2">
                                        Administrador
                                    </div></label>
                                </div>    
                            </div>
                            <button type="submit" class="btn btn-light" name="submit" id="submit">Registrar</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>

        <?php
        }
    }
    
?>