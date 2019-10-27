<?php

	session_start();
	
	include '../Functions/Authentication.php';

	if (!IsAuthenticated())
		header('Location: ../index.php');
	else{
		include '../Views/Users_Views/USERS_Index.php';
		new Index();
	}

?>