<?php

    	session_start();

        $usuario = addslashes(filter_input(INPUT_GET, 'usuario')); 
        $senha = md5(addslashes(filter_input(INPUT_GET, 'senha'))); 

        // $usuario = preg_replace('/[^[:alnum:]_]/', '',$usuario);
        // $senha = preg_replace('/[^[:alnum:]_]/', '',$senha);

        include ('config.php');


        $query = mysqli_query($conexao, "SELECT * FROM usuario WHERE login = '$usuario' AND nivel = 2 AND status = 1") or die(mysqli_error($conexao));
        $result = mysqli_fetch_array($query);
        $usu = mysqli_num_rows($query);


        if ($query) {
           

            if ($usu > 0) {
                $_SESSION['logo'] = $result['logo'];    
                $_SESSION['estabelecimento'] = $result['estabelecimento'];
                $_SESSION['login'] = $result['login'];
                $_SESSION['idusuario'] = $result['idusuario'];

                 
                $valor = ['retorno' => '1'];
                echo json_encode($valor);
                exit;

            }else{


                $valor = ['retorno' => '0'];
                echo json_encode($valor);
                exit;
            }

            $valor = ['retorno' => '0'];
            echo json_encode($valor);
            exit;
        }





?>