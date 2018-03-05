<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }
    
  header('Content-type: application/json');  
  //envio o charset para evitar problemas com acentos
  header("Content-Type: text/html; charset=UTF-8");
  $_SESSION['verif'] = " ";
  include('../php/config.php');

  $codigo = filter_input(INPUT_GET, 'codigo');
  // $tamanho = strlen($codigo);

  // if ($tamanho == 48) {
  // $parte1 = substr($codigo, 0, -37);
  // $parte2 = substr($codigo, 12, -25);
  // $parte3 = substr($codigo, 24, -13);
  // $parte4 = substr($codigo, 36, -1);
  // $codigo = $parte1.$parte2.$parte3.$parte4;
  // }







$tamanho = strlen($codigo);

// if ($tamanho < 44) {
//   $valor = ['retorno' => '4'];
//   echo json_encode($valor);
//   exit;
// }

if ($tamanho >= 45 & $tamanho <= 47) {
  $valor = ['retorno' => '6'];
  echo json_encode($valor);
  exit;
}

//verifica se o código é válido mediante aos digitos verificadores
  if ($tamanho == 48 or $tamanho > 44) {
    // $codigo = $_POST['codigo'];

    $parte1 = substr($codigo, 0, -37);
    $verif1 = substr($codigo, 11, -36);
    
    $parte2 = substr($codigo, 12, -25);
    $verif2 = substr($codigo, 23, -24);
    
    $parte3 = substr($codigo, 24, -13);
    $verif3 = substr($codigo, 35, -12);
    
    $parte4 = substr($codigo, 36, -1);
    $verif4 = substr($codigo, 47, 1);


  for ($i=1; $i < 5; $i++) { 
    
    if ($i == 1) {
      $string = $parte1;
    }
    if ($i == 2) {
      $string = $parte2;
    }
    if ($i == 3) {
      $string = $parte3;
    }
    if ($i == 4) {
      $string = $parte4;
    }





  // Consiste se a string recebida é valida, caso contrário retorna o dígito zero:
  $string = trim($string);
  if (empty($string) or !is_numeric($string))
     return 0;

  // Inicializa variaveis de trabalho
  $posicao1 = strlen($string)-1;    // Obtem a posicao do último digito da string
  $multi   = 2;                     // Declara o multiplicador com o valor de 2
  $acumula = 0;                     // Zera a variavel que acumulará a soma dos digitos

  // Loop principal de calculo
  while ($posicao1 >= 0) {         // Loop para multiplicar cada digito da string por 2 ou 1, da direita pra esquerda
        $resultado = substr($string,$posicao1,1) * $multi;
      $posicao2  = strlen($resultado)-1;
      while ($posicao2 >= 0) {   // Loop para acumular a soma dos digitos do resultado da multiplicação
            $acumula = $acumula + substr($resultado,$posicao2,1);
        $posicao2--;
      };
      if ($multi == 2)           // Alterna o multiplicador entre 2 e 1
          $multi = 1;
      else
          $multi = 2;
      $posicao1--;               // Controla a posição da string a ser processada
  }

  // Obtem o resto da divisão por dez:
  $dac = bcmod($acumula, 10);

  // Subtrai de 10 o resto obtido:
  $dac = 10 - $dac;

  // Se o resultado for dez, retorna zero:
  if ($dac == 10) $dac = 0;



    if ($i==1) {
      $dac1 = $dac;
    }
    if ($i==2) {
      $dac2 = $dac;
    }
    if ($i==3) {
      $dac3 = $dac;
    }
    if ($i==4) {
      $dac4 = $dac;
    }


  }


  $numconta = $verif1.$verif2.$verif3.$verif4;

  $numreal = $dac1.$dac2.$dac3.$dac4;

  if ($numconta !== $numreal) {
    $_SESSION['verif'] = "CÓDIGO INVÁLIDO";
    // echo 'CÓDIGO INVÁLIDO!';
    $valor = ['retorno' => '1'];
    echo json_encode($valor);
    exit;
  }else{
    $codigo = $parte1.$parte2.$parte3.$parte4;
    // echo 'CÓDIGO VÁLIDO!';
    $valor = ['retorno' => '2'];
    echo json_encode($valor);
    exit;
  }


}




  $query = mysqli_query($conexao, "SELECT * FROM boletos WHERE codBarras = '{$codigo}'")or die(mysqli_error($conexao)); //monto a query


  if( mysqli_fetch_array($query) > 0 ) {//se retornar algum resultado
    $_SESSION['verif'] = "CONTA JÁ RECEBIDA";
    // echo 'CONTA JÁ RECEBIDA!';
    $valor = ['retorno' => '3'];
    echo json_encode($valor);
    exit;
  } 

  if($tamanho = 44){
    $valor = ['retorno' => '5'];
    echo json_encode($valor);
  } 

  ?>