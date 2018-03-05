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

	$logo = $_FILES["logo"];
	$idusuario = $_SESSION['idusuario'];

	include('../../php/config.php');

	// Se a logo estiver sido selecionada
	if (!empty($logo["name"])) {
		
		
		// Largura máxima em pixels
		$largura = 5000;
		// Altura máxima em pixels
		$altura = 5000;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 500000000;
 
		$error = array();
 		
    	// Verifica se o arquivo é uma imagem
    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $logo["type"])){
     	   $error[1] = "Isso não é uma imagem.";
   	 	} 
	
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($logo["tmp_name"]);
	
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}
 
		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
		
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($logo["size"] > $tamanho) {
   		 	$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}
 	
		// Se não houver nenhum erro
		if (count($error) == 0) {
		
			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $logo["name"], $ext);

        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "../../logos/" . $nome_imagem;
 
			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($logo["tmp_name"], $caminho_imagem);
			
			// remove a foto antiga
			$sql = mysqli_query($conexao, "SELECT logo FROM usuario WHERE idusuario = '$idusuario'");
			$sql = mysqli_fetch_array($sql);
			$logoatual = $sql['logo'];
			unlink("../../logos/$logoatual"); 

			// Insere os dados no banco
			$sql = mysqli_query($conexao, "UPDATE usuario SET logo = '$nome_imagem' WHERE idusuario = '$idusuario'") or die(mysqli_error($conexao));
			// $sql = mysqli_query($conexao, "UPDATE usuario SET logo = 'TESTE' WHERE id = '$idu'");
		
			// Se os dados forem inseridos com sucesso
			if ($sql){
				$sql = mysqli_query($conexao, "SELECT logo FROM usuario WHERE idusuario = '$idusuario'");
				$sql = mysqli_fetch_array($sql);
				$_SESSION['logo'] = $sql['logo'];
				header('location:../gerenciar.php?adicionada=true');
			}
		}

		 if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
				header('location:../gerenciar.php?adicionada=false');
			}
		}
	}
	
?>	