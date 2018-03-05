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
    
	if (isset($_POST['login']) && isset($_POST['estabelecimento'])) {
		
		$nome = addslashes($_POST['nome']);
		$estabelecimento = mb_strtoupper(addslashes($_POST['estabelecimento']));
		$login = addslashes($_POST['login']);
		// $senha = md5(addslashes($_POST['senha']));
		$senha = "202cb962ac59075b964b07152d234b70";
		$nivel = addslashes($_POST['nivel']);
		$status = 1;


		include('../../php/config.php');

		$sql = "INSERT INTO usuario(nome, estabelecimento, login, senha, nivel, status) VALUES('$nome', '$estabelecimento', '$login', '$senha', '$nivel', '$status') ";
		$query = mysqli_query($conexao, $sql);

		
		if ($query) {

			header('location: ../cadastrar_master.php?cadastrado=true');

		}else{

			header('location: ../cadastrar_master.php?cadastrado=false');

		}

	}else{
		header('location: ../cadastrar_master.php??cadastrado=false');
	}



?>