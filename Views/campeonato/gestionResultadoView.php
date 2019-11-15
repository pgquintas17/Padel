<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/parejaModel.php');
    require_once('Mappers/parejaMapper.php');
    
    class GestionResultadoView extends baseView {

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
                <br><h3>Gestión de resultado</h3><br>
                <div class="row justify-content-start">
                    <div class="col-2"></div>
                    <a class="bg-ligth text-dark" href="/index.php?controller=adminGrupos&idgrupo=<?php echo $this->datos['10']; ?>"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
                </div>
                <div class="row">

                    <div class="col-lg-3"></div>
                        <div class="bg-dark text-white rounded p-3 col-lg-6" id="perfilform">

                            <!-- Formulario datos enfrentamiento -->
                            <form action="/" method="POST" name="formEDITUsers">

                                <input type="hidden" name="controller" value="adminGrupos">
                                <input type="hidden" name="action" value="addResultado">
                                <input type="hidden" name="idenfrentamiento" value="<?php echo $this->datos['0']; ?>">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Pareja1</label>
                                        <input type="text" class="form-control" name="pareja1" readonly value="<?php $pareja = new ParejaModel(); $pareja->setId($this->datos['7']); $parejaMapper = new ParejaMapper(); echo $parejaMapper->getNombreById($pareja); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Pareja2</label>
                                        <input type="text" class="form-control" name="pareja2" readonly value="<?php $pareja = new ParejaModel(); $pareja->setId($this->datos['8']); $parejaMapper = new ParejaMapper(); echo $parejaMapper->getNombreById($pareja); ?>">
                                    </div>
                                </div>    
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Fecha</label>
                                        <input type="text" class="form-control" name="fecha" readonly value="<?php echo date('d/M/y',strtotime($this->datos['2'])); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Hora</label>
                                        <input type="text" class="form-control" name="hora" readonly value="<?php echo date('H:i',strtotime($this->datos['3'])); ?>">
                                    </div>
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <label>Set1</label>
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S1P1" value="<?php if($this->datos['4'] != null){echo substr($this->datos['4'], 0,1);}?>">
                                    </div>
                                    <div class="form-group col-1">
                                        -
                                    </div>
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S1P2" value="<?php if($this->datos['4'] != null){echo substr($this->datos['4'], -1);}?>">
                                    </div>  
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <label>Set2</label>
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S2P1" value="<?php if($this->datos['4'] != null){echo substr($this->datos['5'], 0,1);}?>">
                                    </div>
                                    <div class="form-group col-1">
                                        -
                                    </div>
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S2P2" value="<?php if($this->datos['4'] != null){echo substr($this->datos['5'], -1);}?>">
                                    </div>  
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <label>Set3</label>
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S3P1" value="<?php if($this->datos['4'] != null){echo substr($this->datos['6'], 0,1);}?>">
                                    </div>
                                    <div class="form-group col-1">
                                        -
                                    </div>
                                    <div class="form-group col-2">
                                        <input type="text" class="form-control" name="S3P2" value="<?php if($this->datos['4'] != null){echo substr($this->datos['6'], -1);}?>">
                                    </div>  
                                </div>
                                <div class="form-row justify-content-md-center">
                                    <div class="form-group col-2 ">
                                        <label>Resultado</label>
                                        <input type="text" class="form-control" name="resultado" readonly value="<?php echo $this->datos['1'];?>">
                                    </div>  
                                </div>
                                <button type="submit" class="btn btn-light" name="submit" id="submit">Aceptar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
        <?php
        }
    }
?>