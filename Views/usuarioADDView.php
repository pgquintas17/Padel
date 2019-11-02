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
            <h3>Añadir usuario</h3><br>
                <div class="row">

                    <div class="col-lg-3"></div>
                    <div class="col-lg-6" id="perfilform">

                        <!-- Formulario datos usuario -->
                        <form method="post"  name="formAdd" action='/index.php?controller=adminUsuarios&action=ADD' autocomplete="off">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Login</label>
                                    <input type="text" class="form-control" id="inputLogin">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="inputPassword">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" id="inputNombre">
                                </div>
                            </div>    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputFechaNac">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="inputFechaNac">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTelefono">Telefono</label>
                                    <input type="text" class="form-control" id="inputTelefono">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputGenero">Género</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inputGenero" value="femenino">
                                    <label class="form-check-label">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inputGenero" value="masculino">
                                    <label class="form-check-label">Masculino</label>
                                </div>  
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="inputEmail">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Permiso</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inputPermiso" value="0">
                                    <label class="form-check-label" for="permiso-0">Deportista</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inputPermiso" value="1">
                                    <label class="form-check-label" >Entrenador</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="inputPermiso" value="2">
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