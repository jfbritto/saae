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
    
	if (isset($_GET['idusuario'])) {
		
		$idusuario = addslashes($_GET['idusuario']);


		include('../../php/config.php');


		$query = mysqli_query($conexao, "DELETE FROM usuario WHERE idusuario = $idusuario");
		
		if($query){

			header('location: ../home_master.php?deletado=true');
			exit;

		}else{

			header('location: ../home_master.php?deletado=false');
			exit;
		}

	}else{
		header('location: ../home_master.php??deletado=false');
		exit;
	}



?>