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

    if (isset($_GET['idusuario']) && isset($_GET['idcaixa'])) {


	include('../../php/config.php');


	$idusuario = $_GET['idusuario'];
	$idcaixa = $_GET['idcaixa'];


	$query = mysqli_query($conexao, "DELETE FROM caixa WHERE fkusuario = $idusuario AND idcaixa = $idcaixa");

	if ($query) {

		header('location:../caixas.php?deletado=true');
		exit;

	}else{

		header('location:../caixas.php?deletado=false');
		exit;

	}

    }else{

    	header('location:../caixas.php?deletado=false');

    }


?>
