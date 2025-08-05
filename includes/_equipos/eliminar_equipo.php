<?php

session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];
	if($varsesion== null || $varsesion= ''){

	    header("Location: ../_sesion/login.php");
	
	}
	$id = $_GET['id'];
	include "../db.php";
	$query = mysqli_query($conexion,"DELETE FROM equipos WHERE id = '$id'");
	
	header ('Location: ../../views/equipos.php?m=1');
