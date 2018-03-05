<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

    if(isset($_SESSION['idusuario']) && $_SESSION['idusuariomaster'] == "") {
        header('location: ../usu/home.php');
        exit;
    }
    
	include('../../php/config.php');

	$data = date("m-Y");

	$NARQUIVO = $banco."-".$data;
	$resp = `mysqldump --host=$host --user=$user --password=$senha --databases $banco > ../bkp_bd//$NARQUIVO.sql` ;


	header('location:../home_master.php?bkp=true');

?>