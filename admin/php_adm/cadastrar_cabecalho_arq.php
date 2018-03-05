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
    
	if (isset($_POST['cod_convenio']) && isset($_POST['nome_convenio'])) {
		
		$codconvenio = mb_strtoupper(addslashes($_POST['cod_convenio']));
		$nomeconvenio = mb_strtoupper(addslashes($_POST['nome_convenio']));
		$codbanco = mb_strtoupper(addslashes($_POST['cod_banco']));
		$nomebanco = mb_strtoupper(addslashes($_POST['nome_banco']));
		$conta_creditada = mb_strtoupper(addslashes($_POST['conta_creditada']));
		$ag_arrecadadora = mb_strtoupper(addslashes($_POST['ag_arrecadadora']));
		$numero_autenticacao = mb_strtoupper(addslashes($_POST['numero_autenticacao']));
		$idusuario = $_SESSION['idusuario'];

		include('../../php/config.php');


		$sql = "INSERT INTO arquivo(arq_codconvenio, arq_nomeconvenio, arq_codbanco, arq_nomebanco, conta_creditada, ag_arrecadadora, numero_autenticacao, fkusuario) VALUES('$codconvenio', '$nomeconvenio', '$codbanco', '$nomebanco', '$conta_creditada', '$ag_arrecadadora', '$numero_autenticacao', '$idusuario')";

		$query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
		
		if ($query) {

			header('location: ../cadastrar_editar_arquivo.php?cadastrado=true');

		}else{

			header('location: ../cadastrar_editar_arquivo.php?cadastrado=false');

		}

	}else{
		header('location: ../cadastrar_editar_arquivo.php??cadastrado=false');
	}



?>