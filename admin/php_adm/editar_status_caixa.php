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

    
    include('../../php/config.php');

    if (isset($_GET['idcaixa']) && isset($_GET['st'])) {
      
      $idcaixa = $_GET['idcaixa'];
      $st = $_GET['st'];
      $ncx = $_GET['ncx'];

      $fkusuario = $_SESSION['idusuario'];

      if ($st == 1) {
        $busca = mysqli_query($conexao, "SELECT * FROM caixa WHERE status_caixa = 1 AND numero_caixa = $ncx AND fkusuario = $fkusuario");
        $row = mysqli_num_rows($busca);

        if($row>0){
          header('location: ../caixas.php?naoativado=true');
          exit;
        }
      }


      $query = mysqli_query($conexao, "UPDATE caixa SET status_caixa = $st WHERE idcaixa = $idcaixa ") or die(mysqli_error($conexao));

      if ($query) {

        if ($st==1) {
          header('location: ../caixas.php?ativado=true');
        }else{
          header('location: ../caixas.php?desativado=true');
          
        }
      
      } else{

        if ($st==1) {
          header('location: ../caixas.php?ativado=false');
        }else{
          header('location: ../caixas.php?desativado=false');
          
        }
      }

    }else{

      header('location: ../caixas.php?desativado=false');

    }


?>