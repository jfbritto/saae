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
    
	if (isset($_POST['login_caixa']) && isset($_POST['numero_caixa'])) {
		
		$nome = mb_strtoupper(addslashes($_POST['nome_caixa']));
		$login = addslashes($_POST['login_caixa']);
		// $senha = md5(addslashes($_POST['senha_caixa']));
		$senha = "202cb962ac59075b964b07152d234b70";
		$numero = addslashes($_POST['numero_caixa']);
		$fkusuario = $_SESSION['idusuario'];

		include('../../php/config.php');


        $busca = mysqli_query($conexao, "SELECT * FROM caixa WHERE status_caixa = 1 AND numero_caixa = $numero AND fkusuario = $fkusuario");
        $row = mysqli_num_rows($busca);

        if($row>0){
          header('location: ../cadastrar_caixas.php?naocadastrado=true');
          exit;
        }


        $busca2 = mysqli_query($conexao, "SELECT * FROM caixa WHERE status_caixa = 1 AND login_caixa = '$login' AND fkusuario = $fkusuario");
        $row2 = mysqli_num_rows($busca2);

        if($row2>0){
          header('location: ../cadastrar_caixas.php?naocadastrado=true');
          exit;
        }



		$sql = "INSERT INTO caixa(nome_caixa, login_caixa, senha_caixa, numero_caixa, fkusuario, status_caixa) VALUES('$nome', '$login', '$senha', '$numero', '$fkusuario', 1) ";

		$query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
		
		if ($query) {

			header('location: ../cadastrar_caixas.php?cadastrado=true');

		}else{

			header('location: ../cadastrar_caixas.php?cadastrado=false');

		}

	}else{
		header('location: ../cadastrar_caixas.php??cadastrado=false');
	}



?>