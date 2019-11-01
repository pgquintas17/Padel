# PadelWEB



## Introducción.

El propósito de este proyecto será la creación de una aplicación web que permita manejar el funcionamiento de un club de pádel.

Los tipos de usuarios que se han tomado en cuenta serán: Deportista, Entrenador y Administrador.

## Funcionalidades

Se implementarán las siguientes funcionalidades para el correcto funcionamiento de la aplicación.

* Gestión de usuarios
* Gestión de reserva de pista
* Gestión de pista
* Gestión de campeonatos
* Gestión de liga regular
* Inscripción a campeonato
* Promoción de partidos
* Organización de partidos



## Implementación

La implementación de la aplicación se llevará a cabo usando el modelo vista-controlador.





## Cambios Paula:

- [x] Eliminar comentarios modelos
- [x] Eliminar método SEARCH() y añadir mostrarTodos()
- [x] Función crearFiltros()
- [x] Función consultarDatos()
- [ ] Función generarGrupos()
- [x] Modificar métodos ADD() cuando el id es autogenerado
- [ ] Repasar atributos de todas los modelos
- [ ] Crear objetos tipo Set (preguntar alfonso)
- [x] Eliminar PAREJACAMPEONATO_MODEL.php
- [ ] Cambiar en controller el pasar por REQUEST los valores a pasar un objeto del modelo
- [ ] Quitar llamadas a BD en modelos y añadir getters y setters
- [ ] Hacer MODELS genérico con las llamadas a BD ($tabla,$valores) ($valores array(clave,valor))