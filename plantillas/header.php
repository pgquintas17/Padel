<?php

/*Archivo php header, contiene la cabecera de la web.
Autor: Grupo 35 ABP*/

//incluimos todos los ficheros a utilizar

?>
<html>
<head>
  <title>PADELweb</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link type="text/css" rel="stylesheet" href="bootstrap/css/custom.css">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
  
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-inverse bg-dark">
        <a class="navbar-brand" href="#">PADELweb</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              PISTAS
            </a>
              <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
              <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              CAMPEONATOS
            </a>
              <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
              <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              PARTIDOS
            </a>
              <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
              <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              USUARIOS
            </a>
              <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
              <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <!--Si está conectado-->
            <?php

	            if (IsAuthenticated()){
            ?>
            <li class="nav-item">
              <!--perfil-->
              <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
            </li>
            <li class="nav-item">
              <!--desconexión-->
              <a class="nav-link" href='../Functions/Desconectar.php'><i class="fas fa-power-off"></i></a>
            </li>
            <?php
                }
                else{
            ?>
            <!--Si no está conectado-->
            <li class="nav-item">
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                    <i class="fas fa-sign-in-alt"></i>
                  </button>
            </li>
            <?php
                } 
            ?>      
          </ul>
        </div>
      </div>
    </nav>
</header>

<body>
