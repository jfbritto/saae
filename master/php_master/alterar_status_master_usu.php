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
    
    include('../../php/config.php');

    if (isset($_GET['status']) && isset($_GET['idusuario'])) {
      
      $status = $_GET['status'];
      $idusuario = $_GET['idusuario'];

      $query = mysqli_query($conexao, "UPDATE usuario SET status = $status WHERE idusuario = $idusuario ") or die(mysqli_error($conexao));

      if ($query) {

        if ($status==1) {
          header('location: ../home_master.php?ativado=true');
        }else{
          header('location: ../home_master.php?finalizado=true');
          
        }
      
      } else{

        if ($status==1) {
          header('location: ../home_master.php?ativado=false');
        }else{
          header('location: ../home_master.php?finalizado=false');
          
        }
      }

    }else{

      header('location: ../home_master.php?finalizado=false');

    }


?>