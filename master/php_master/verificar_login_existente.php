<?php



    include('../../php/config.php');

    $login = filter_input(INPUT_GET, 'login');

 
    $query = mysqli_query($conexao, "SELECT * FROM usuario WHERE login = '{$login}'")or die(mysqli_error($conexao)); 
    $num = mysqli_num_rows($query);

    if( $num > 0 ) {
      
      $valor = ['retorno' => '1'];
      echo json_encode($valor);
      exit;

    }

    $valor = ['retorno' => '0'];
    echo json_encode($valor);
    exit;
    
    }











  ?>