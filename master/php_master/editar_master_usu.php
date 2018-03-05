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

    include('autenticar_sessao.php');

    include('../../php/config.php');

    if (isset($_POST['nome'])) {
      
      $idusuario = $_POST['idusuario'];

      $nome = addslashes($_POST['nome']);
      $estabelecimento = mb_strtoupper(addslashes($_POST['estabelecimento']));
      $login = addslashes($_POST['login']);
      $senha = md5(addslashes($_POST['senha']));
      $nivel = addslashes($_POST['nivel']);



      $query = mysqli_query($conexao, "UPDATE usuario SET nome = '$nome', estabelecimento = '$estabelecimento', login = '$login', senha = '$senha', nivel = '$nivel' WHERE idusuario = $idusuario ") or die(mysqli_error($conexao));

      if ($query) {
        
        header('location: ../home_master.php?editado=true');
      
      } else{
        header('location: ../home_master.php?editado=false');
      }

    }else{

      header('location: ../home_master.php?editado=false');

    }


?>