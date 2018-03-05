<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../../index.php?naologado=true');
        exit;
    }

    if(isset($_SESSION['idusuario']) && $_SESSION['idusuarioadmin'] == "") {
        header('location: ../../usu/home.php');
        exit;
    }

	include('../../php/config.php');


	$id = $_GET['id'];


	$sql = "DELETE FROM boletos WHERE id = '$id'";

	$deleta = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

	if ($deleta) {
		header('location:../gerenciar.php?deletada=true');
		exit;
	}else{
		header('location:../gerenciar.php?deletada=false');
	}



?>
