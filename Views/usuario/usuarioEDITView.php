<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class UsuarioEDITView extends baseView {

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

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
                <br><h3>Perfil de: <?php echo $this->datos['0']; ?></h3><br>
                <div class="row justify-content-start">
                    <div class="col-2"></div>
                    <a class="bg-ligth text-dark" href="/index.php?controller=perfil"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
                </div>
                <div class="row">

                    <div class="col-lg-3"></div>
                        <div class="bg-dark text-white rounded p-3 col-lg-6" id="perfilform">

                            <!-- Formulario datos usuario -->
                            <form action="/" method="POST" name="formEDITUsers">

                                <input type="hidden" name="controller" value="perfil">
                                <input type="hidden" name="action" value="EDIT">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label><strong>Nombre</strong></label>
                                        <input type="text" class="form-control" name="inputNombre" readonly value=<?php echo $this->datos['1'];?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>Password</strong></label>
                                        <input type="password" class="form-control" name="inputPassword" value=<?php echo $this->datos['2'];?>>
                                    </div>
                                </div>    
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFechaNac"><strong>Fecha de Nacimiento</strong></label>
                                        <input type="date" class="form-control" name="inputFechaNac" value=<?php echo $this->datos['3'];?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputTelefono"><strong>Telefono</strong></label>
                                        <input type="text" class="form-control" name="inputTelefono" value=<?php echo $this->datos['4'];?>>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputGenero"><strong>Género</strong></label>
                                    <div class="form-check row">
                                    <label><div class="col-md-1">
                                            <input class="form-check-input" type="radio" name="inputGenero" value="femenino" <?php if($this->datos['6'] == "femenino"){ ?> checked <?php } ?>>Mujer
                                        </div></label>
                                    <label><div class="col-md-1">
                                            <input class="form-check-input" type="radio" name="inputGenero" value="masculino" <?php if($this->datos['6'] == "masculino"){ ?> checked<?php } ?>>Hombre
                                        </div></label>
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label><strong>Email</strong></label>
                                    <input type="email" class="form-control" name="inputEmail" value=<?php echo $this->datos['5']; ?>>
                                </div>
                                <div class="form-group col-md-12" style="text-align: left;">
                                    <label for="inputSus"><strong>Suscripción a noticias</strong></label>
                                    <div class="form-check row">
                                    <label><div class="col">
                                            <input class="form-check-input" type="radio" name="inputSuscripcion" value="1" <?php if($this->datos['8'] == "1"){ ?> checked <?php } ?>>Sí, deseo recibir noticias por email.
                                        </div></label>
                                    <label><div class="col">
                                            <input class="form-check-input" type="radio" name="inputSuscripcion" value="0" <?php if($this->datos['8'] == "0"){ ?> checked<?php } ?>>No, no quiero recibir noticias por email
                                            <p class="text-danger" style="font-size: 11px;">Seguirás recibiendo emails relacionados con tus reservas, partidos y campeonatos.</p>
                                        </div></label>
                                    </div>  
                                </div>
                                <button type="submit" class="btn btn-light" name="submit" id="submit">Editar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
        <?php
        }
    }
?>