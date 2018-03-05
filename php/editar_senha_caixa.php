<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

    if (isset($_POST['senha_nova'])) {


	include('config.php');

	$senha_velha = md5(addslashes($_POST['senha_velha']));
	$senha_nova = md5(addslashes($_POST['senha_nova']));
	$fkusuario = $_SESSION['idusuario'];
	$idcaixa = $_SESSION['idcaixa'];


	$sql = mysqli_query($conexao, "SELECT * FROM caixa WHERE senha_caixa = '$senha_velha' AND idcaixa = '$idcaixa' AND fkusuario = $fkusuario") or die(mysqli_error($conexao));
	$result = mysqli_num_rows($sql);

	if ($result>0) {

		$sql = mysqli_query($conexao, "UPDATE caixa SET senha_caixa = '$senha_nova', senha_padrao_cx = 1 WHERE idcaixa = '$idcaixa' AND fkusuario = $fkusuario");
		header('location:../usu/index.php?senha_alterada=true');

	}else{
		header('location:../usu/index.php?senha_alterada=false');
	}

    }else{
    	header('location:../usu/index.php?senha_alterada=false');
    }


?>