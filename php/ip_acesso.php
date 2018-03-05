<?php



    $ip = $_POST["ip"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $pais = $_POST["pais"];
    $provedor = $_POST["provedor"];


    $data = date('Y-m-d');
    $hora= date('H:i:s');




    include ('config.php');

    $query1 = mysqli_query($conexao, "SELECT * FROM acesso WHERE ip = '$ip' AND data = '$data'");
    $num = mysqli_num_rows($query1);

    if ($num>0) {
        $result1 = mysqli_fetch_array($query1);
        $qntd = $result1['quantidade'] + 1;

        $atualizando = mysqli_query($conexao, "UPDATE acesso SET quantidade = $qntd, ultima_visita = '$hora' WHERE ip = '$ip' AND data = '$data'");
    
    }else{
        $inserindo = mysqli_query($conexao, "INSERT INTO acesso(ip, data, primeira_visita, ultima_visita, quantidade, cidade, estado, pais, provedor) VALUES('$ip', '$data', '$hora', '$hora', 1, '$cidade', '$estado', '$pais', '$provedor')")or die(mysqli_error($conexao));
    }









?>
