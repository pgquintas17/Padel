<?php

    function conectado(){
	
	    if (!isset($_SESSION['login']))
		    return false;
	    else
		    return true;
    } 
?>

