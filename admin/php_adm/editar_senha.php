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

    if (isset($_POST['senha_nova'])) {
    	# code...

	include('../../php/config.php');

	$senha_velha = md5($_POST['senha_velha']);
	$senha_nova = md5($_POST['senha_nova']);
	$idusuario = $_SESSION['idusuario'];


	$sql = mysqli_query($conexao, "SELECT * FROM usuario WHERE senha = '$senha_velha' AND idusuario = '$idusuario'") or die(mysqli_error($conexao));
	$result = mysqli_num_rows($sql);

	if ($result>0) {

		$sql = mysqli_query($conexao, "UPDATE usuario SET senha = '$senha_nova', senha_padrao_usu = 1 WHERE idusuario = '$idusuario'");
		header('location:../gerenciar.php?senha_alterada=true');

	}else{
		header('location:../gerenciar.php?senha_alterada=false');
	}

    }else{
    	header('location:../gerenciar.php?senha_alterada=false');
    }


?>