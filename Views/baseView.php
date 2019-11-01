<?php

    require_once('Services/Utils.php');
    
    
    abstract class BaseView {

        private $usuario;

        function __construct($usuario) {
            $this->usuario = $usuario;
        }

        abstract protected function _render();

        function render() {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>PADELweb</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                <link type="text/css" rel="stylesheet" href="bootstrap/css/custom.css">
                <link type="text/css" rel="stylesheet" href="./Views/css/custom.css">
                <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            </head>
            <body>
            <header>
                <nav class="navbar navbar-expand-lg navbar-inverse bg-dark">
                    <a class="navbar-brand" href="index.php">PADELweb</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                        <?php
                        if(Utils::conectado()){ //Si está conectado
                            if(Utils::nivelPermiso(2)){ //Si es admin
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PISTAS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CAMPEONATOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PARTIDOS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/index.php?controller=adminUsuarios">USUARIOS</a>
                            </li>
                          <?php

                            }else { //Si no es admin
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">RESERVAR PISTA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">APUNTARSE A CAMPEONATOS</a>
                            </li>
                        <?php
                            }
                        ?>
                            <li class="nav-item">
                            <!--perfil-->
                                <a class="nav-link" href="/index.php?controller=perfil"><i class="fas fa-user"></i></a>
                            </li>
                            <li class="nav-item">
                            <!--desconexión-->
                                <a class="nav-link" href='/index.php?controller=logout'><i class="fas fa-power-off"></i></a>
                            </li>
                            <?php

                                }
                                else{ //Si no está conectado
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href='/index.php?controller=login'><i class="fas fa-sign-in-alt"></i></a>
                            </li>
                            <?php
                                } 
                            ?>      
                        </ul>
                    </div>
                </nav>
            </header>
                <main class="container"> <!-- render -->
                    <?php $this->_render();?>
                </main>
                <footer class="pt-5 pb-4" id="contact">
                    <div class="container">
                        <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 mt-2 mb-4">
                            <h5 class="mb-4 font-weight-bold">CONTACTO</h5>
                            <ul class="f-address">
                            <li>
                                <div class="row">
                                <div class="col-1"><i class="fas fa-map-marker"></i></div>
                                <div class="col-10">
                                    <h6 class="font-weight-bold mb-0">Dirección:</h6>
                                    <p>Edificio Politécnico s/n, 32004 Ourense</p>
                                </div>
                                </div>
                            </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mt-2 mb-4">
                            <h5 class="mb-4 font-weight-bold"><br></h5>
                            <ul class="f-address">
                            <li>
                                <div class="row">
                                <div class="col-1"><i class="far fa-envelope"></i></div>
                                <div class="col-10">
                                    <h6 class="font-weight-bold mb-0">¿Alguna pregunta?</h6>
                                    <p><a href="#">Support@userthemes.com</a></p>
                                </div>
                                </div>
                            </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mt-2 mb-4">
                            <h5 class="mb-4 font-weight-bold"><br></h5>
                            <ul class="f-address">
                            <li>
                                <div class="row">
                                <div class="col-1"><i class="fas fa-phone-volume"></i></div>
                                <div class="col-10">
                                    <h6 class="font-weight-bold mb-0">Teléfono:</h6>
                                    <p><a href="#">+XX (0) XX XX-XXXX-XXXX</a></p>
                                </div>
                                </div>
                            </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mt-2 mb-4">
                            <h5 class="mb-4 font-weight-bold">REDES SOCIALES</h5>
                            <ul class="social-pet mt-4">
                            <li><a href="#" title="facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" title="twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" title="google-plus"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="#" title="instagram"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </footer>
                <!-- Copyright -->
                <section class="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="text-center text-white">
                                &copy; 2019 Grupo 35 ABP. All Rights Reserved.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </body>
            </html>
            <?php
        }
    }
?>