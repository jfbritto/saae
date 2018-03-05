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
    
	if (isset($_POST['login_caixa']) && isset($_POST['senha_caixa'])) {
		
		$nome = mb_strtoupper(addslashes($_POST['nome_caixa']));
		$login = addslashes($_POST['login_caixa']);
		$senha = md5(addslashes($_POST['senha_caixa']));
		$numero = addslashes($_POST['numero_caixa']);

		$fkusuario = $_SESSION['idusuario'];
		$idcaixa = addslashes($_POST['idcaixa']);



		include('../../php/config.php');

		$sql = "UPDATE caixa SET nome_caixa = '$nome', login_caixa = '$login', senha_caixa = '$senha', numero_caixa = '$numero' WHERE fkusuario = '$fkusuario' AND idcaixa = '$idcaixa'";

		$query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
		
		if ($query) {

			header('location: ../caixas.php?editado=true');

		}else{

			header('location: ../caixas.php?editado=false');

		}

	}else{
		header('location: ../caixas.php??editado=false');
	}



?>