<?php

    	session_start();

        $caixa = addslashes(filter_input(INPUT_GET, 'login_caixa')); 
        $senha = md5(addslashes(filter_input(INPUT_GET, 'senha_caixa'))); 

        // $caixa = preg_replace('/[^[:alnum:]_]/', '',$caixa);

        $fkusuario = $_SESSION['idusuario'];

        include ('config.php');


        $query = mysqli_query($conexao, "SELECT * FROM caixa WHERE login_caixa = '$caixa' AND senha_caixa = '$senha' AND fkusuario = '$fkusuario' AND status_caixa = 1") or die(mysqli_error($conexao));
        $result = mysqli_fetch_array($query);
        $usu = mysqli_num_rows($query);

        if ($query) {
           

            if ($usu > 0) {

                $_SESSION['idcaixa'] = $result['idcaixa'];
                $_SESSION['nome_caixa'] = $result['nome_caixa'];
                $_SESSION['login_caixa'] = $result['login_caixa'];

                 
                $valor = ['retorno' => '1'];
                echo json_encode($valor);
                exit;

            }else{


                $valor = ['retorno' => '0'];
                echo json_encode($valor);
                exit;
            }

        }else{
            $valor = ['retorno' => '0'];
            echo json_encode($valor);
            exit;
        }
    





?>