<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

	include('config.php');

	if (isset($_GET['cod'])) {
		$cod = addslashes($_GET['cod']);

		$usuario = "SELECT * FROM boletos WHERE codBarras = $cod";
	}elseif (isset($_GET['id'])) {
	

	$id= addslashes($_GET['id']);

	$usuario = "SELECT * FROM boletos WHERE id = $id";
	
	}
	
	$busca = mysqli_query($conexao, $usuario) or die(mysqli_error());

	$row_usuario = mysqli_fetch_array($busca);

	$codigo= $row_usuario['codBarras'];
	$data= $row_usuario['dataPagto'];
	$valor= $row_usuario['valorPago'];
	$hora= $row_usuario['hora'];

	if ($_SESSION['now'] == 1) {

		$codigo = $_SESSION['codigo'];
		$data = $_SESSION['data'];
		$valor = $_SESSION['valor'];
		$hora = $_SESSION['hora'];
		// $caixa = $_SESSION['caixa'];
	}
	$_SESSION['now'] = 0;
	$nome_caixa= $_SESSION['nome_caixa'];
																
	mysqli_close($conexao);

?>

	<!DOCTYPE html>
	<html lang=\"pt-br\">
	<head>
		<meta charset=\"UTF-8\">
		<title>PDF-RELATÓRIO</title>
		<style>
			body{
				font-family: Calibri, DejaVu Sans, Arial;
				margin-top: 0px;
			}
		</style>

	</head>
	<body onload="self.print();self.close();">

		<center>
		<label style="font-size: 20px"><b><?=$_SESSION['estabelecimento']?></b></label>
		<!-- <img width="100px" src="../img/pz.png"> -->
<br>
		<label style="font-size: 15px">RECIBO - SAAE</label>
		</center>
<br>
		<label><b>-----------------------------------------------------</b></label>
<br>
		<label style="font-size: 15px" ><b>INFORMA&Ccedil;&Otilde;ES DO RECEBIMENTO:</b></label>
<br>
		<label style="font-size: 15px"><b>C&#211;DIGO DE BARRAS:</b></label>
<br>
		<label style="font-size: 11px"><?=$codigo;?></label>
<br><br>
		<label style="font-size: 15px"><b>DATA PAGAMENTO:</b></label>
<br>
		<label style="font-size: 15px"><?=date('d/m/Y', strtotime($data));?></label>
		<label style="font-size: 15px"><?=$hora;?></label>
<br><br>
		<label style="font-size: 15px"><b>VALOR:</b></label>
<br>
		<label style="font-size: 15px"><?="R$".$valor;?></label>

<br><br>
		<label style="font-size: 15px"><b>CAIXA:</b></label>
		<label style="font-size: 15px"><?=$nome_caixa;?></label>		
<br>
		<label><b>-----------------------------------------------------</b></label>
<br>	<center>
		<label style="font-size: 15px" >Guarde este comprovante em local seguro.</label>
<br>
		<label style="font-size: 15px" >Obrigado pela prefer&ecirc;ncia, volte sempre!</label>		
		</center>


	</body>
	</html>

