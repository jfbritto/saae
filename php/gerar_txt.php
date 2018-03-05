


<!-- linux -->



<?php  

    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' ); 
    date_default_timezone_set( 'America/Sao_Paulo' );

    
// PEGA AS INFORMAÇÕES NA SESSAO

    $idcaixa = $_SESSION['idcaixa'];
    $nomecx = $_SESSION['nome_caixa'];
    $estabelecimento = $_SESSION['estabelecimento'];

	$dataPagto = $_SESSION['dia'];
	$fkusuario = $_SESSION['idusuario'];



	include('config.php');
	$verifica = mysqli_query($conexao, "SELECT * FROM arquivo WHERE fkusuario = $fkusuario")or die(mysqli_error($conexao));
	$row = mysqli_num_rows($verifica);

	if ($row>0) {
		


// RETIRA OS ESPAÇOS DO NOME DO CAIXA E DO NOME DA EMPRESA
    $nomecx = str_replace(" ", "_", $nomecx);
    $estabelecimento = str_replace(" ", "_", $estabelecimento);


// VERIFICA SE O DIRETORIO COM O NOME DA EMPRESA EXISTE, SE NÃO EXISTIR ELE O CRIA
	if (!file_exists("../arquivos_saae/".$estabelecimento."/")){
		mkdir("../arquivos_saae/".$estabelecimento."/", 0777);
	}

// VERIFICA SE O DIRETÓRIO COM O NOME DO CAIXA EXISTE, SE NÃO EXISTIR ELE O CRIA
	if (!file_exists("../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/")){
		mkdir("../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/", 0777);
	}

// SALVA O DIRETÓRIO NA VARIÁVEL $name

// WIN	
	// $name = "C:\\xampp\\htdocs\\saae\\sistema\\saae\\caixa".$caixa."\\";
	// $data = "CX".$caixa." _ ".date('d-m-Y _ H-i-s').".txt";

// LINUX
	$diretorio = "../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/";

// SALVA O NOME QUE SERÁ DADO AO ARQUIVO NA VARIAVEL $data
	$nome_arquivo = "".$nomecx." _ ".date('d-m-Y _ H-i-s').".txt";

// CONCATENA O DIRETÓRIO AO NOME DO ARQUIVO	
	$fim = $diretorio.$nome_arquivo;

// SETA 0 NA VARIAVEL PARA CONTAGEM DE ARQUIVOS 
	$num = 0;
	


// BUSCA NO BANCO OS DADOS DA EMPRESA PARA PREENCHIMENTO DO CABEÇALHO O ARQUIVO

	$queryusu = mysqli_query($conexao, "SELECT * FROM arquivo WHERE fkusuario = '$fkusuario'")or die(mysqli_error($conexao));
	$result = mysqli_fetch_array($queryusu);

	$codconvenio = str_pad($result['arq_codconvenio'], 20, ' ', STR_PAD_LEFT);
	$nomeconvenio = str_pad($result['arq_nomeconvenio'], 20, ' ', STR_PAD_LEFT);
	$codbanco = str_pad($result['arq_codbanco'], 3, ' ', STR_PAD_LEFT);
	$nomebanco = str_pad($result['arq_nomebanco'], 20, ' ', STR_PAD_RIGHT);

	$conta = str_pad($result['conta_creditada'], 20, ' ', STR_PAD_LEFT);
	$ag_arrecadadora = str_pad($result['ag_arrecadadora'], 8, ' ', STR_PAD_LEFT);
	$autenticacao = str_pad($result['numero_autenticacao'], 23, ' ', STR_PAD_LEFT);




//geração da PRIMEIRA parte do arquivo TXT

	$text = "A2".$codconvenio.$nomeconvenio.$codbanco.$nomebanco.date('Ymd')."000001"."03";
	$text .= PHP_EOL;

	$file = fopen($fim, "a+");
	fwrite($file, $text);
	fclose($file);

//geração da SEGUNDA parte do arquivo TXT

	$query = mysqli_query($conexao, "SELECT * FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa where b.dataPagto = '$dataPagto' and b.fkcaixa = $idcaixa and b.fkusuario = '$fkusuario' ORDER BY id asc")or die(mysqli_error($conexao));


	while ($resp = mysqli_fetch_array($query)) {
	$num++;	
	$dataPagto = str_replace("-", "", $resp['dataPagto']);//pega a data e retira os traços
	$dataCredito = date('Y-m-d', strtotime($resp['dataPagto']. ' + 1 day'));//soma mais um dia na data
	$dataCredito = str_replace("-", "", $dataCredito);//pega a data somada e retira os traços

	$recebido = substr($resp['codBarras'], 7, -29);//pega o valor recebido do codigo
	$recebido = ltrim($recebido, "0");
	$recebido = str_pad($recebido, 12, ' ', STR_PAD_LEFT);

	$num = str_pad($num, 15, ' ', STR_PAD_LEFT);

	$text = "G".$conta.$dataPagto.$dataCredito.$resp['codBarras'].$recebido.$num.$ag_arrecadadora."1".$autenticacao;
	$text .= PHP_EOL;

	$file = fopen($fim, "a+");
	fwrite($file, $text);
	fclose($file);
	}

//geração da TERCEIRA e última parte do arquivo TXT
	$registros = $num + 2;
	$registros = str_pad($registros, 6, ' ', STR_PAD_LEFT);

	$query2 = mysqli_query($conexao, "SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa where b.fkcaixa = $idcaixa and b.dataPagto = '$dataPagto'")or die(mysqli_error($conexao));
	$resp = mysqli_fetch_array($query2);
	$total = str_replace(".", "", $resp['total']);
	$total = str_pad($total, 17, ' ', STR_PAD_LEFT);

	$text = "Z".$registros.$total;
	$text .= PHP_EOL;

	$file = fopen($fim, "a+");
	fwrite($file, $text);
	fclose($file);



	header('location: ../usu/contas_recebidas.php?txt=true');

	}else{
		header('location: ../usu/contas_recebidas.php?txt=false');
		exit;
	}
?>
