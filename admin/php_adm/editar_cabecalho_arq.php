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


		$sql = "UPDATE arquivo SET arq_codconvenio = '$codconvenio', arq_nomeconvenio = '$nomeconvenio', arq_codbanco = '$codbanco', arq_nomebanco = '$nomebanco', conta_creditada = '$conta_creditada', ag_arrecadadora = '$ag_arrecadadora', numero_autenticacao = '$numero_autenticacao' WHERE fkusuario = $idusuario";

		$query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
		
		if ($query) {

			header('location: ../cadastrar_editar_arquivo.php?editado=true');

		}else{

			header('location: ../cadastrar_editar_arquivo.php?editado=false');

		}

	}else{
		header('location: ../cadastrar_editar_arquivo.php??editado=false');
	}



?>