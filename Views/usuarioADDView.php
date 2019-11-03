<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    class UsuarioADDView extends baseView {

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
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="inputPassword">
                                </div>
                            </div>
                            <div class="form-row">
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
                            <div class="form-group col-md-3">
                                <label for="inputGenero">Género</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputGenero" value="femenino">
                                    <label class="form-check-label">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputGenero" value="masculino">
                                    <label class="form-check-label">Masculino</label>
                                </div>  
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="inputEmail">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Permiso</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputPermiso" value="0">
                                    <label class="form-check-label" for="permiso-0">Deportista</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputPermiso" value="1">
                                    <label class="form-check-label" >Entrenador</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputPermiso" value="2">
                                    <label class="form-check-label">Administrador</label>
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