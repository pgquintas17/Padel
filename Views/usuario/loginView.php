<?php
require_once("Views/baseView.php");
require_once('Views/mensajeView.php');

class LoginView extends BaseView {

    private $usuario;
    private $msg;
    private $errs;

	function __construct($msg=null, $errs=null, $usuario=null){
        $this->msg = $msg;
        $this->errs = $errs;		
        parent::__construct($this->usuario);
    }
    
    function _render() {
        ?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
        
        <div  id="espacio_info" class="jumbotron">
            <div class="row">
                <div class="col"></div>
                <div class="col-lg login-form">
                    <form action="/" method="POST" name="formularioLogin">
                        <h2 class="text-center">Login</h2><br>


                        <input type="hidden" name="controller" value="login">
                        <input type="hidden" name="action" value="login">

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" required="required" name="username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" required="required" name="passwd">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark" value="Login">Entrar</button>
                        </div>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
        <?php
    }

}?>
