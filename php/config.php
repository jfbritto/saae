<?php

	$host = 'localhost';
	$usu = 'root';
	$pass = '123456';
	$banco = 'saae';

	$conexao = mysqli_connect($host, $usu, $pass, $banco) or die(mysqli_error());
	
?>
