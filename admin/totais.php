<?php 
    include('../php/config.php');
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

    if(isset($_SESSION['idusuario']) && $_SESSION['idusuarioadmin'] == "") {
        header('location: ../usu/home.php');
        exit;
    }
    
    if(isset($_SESSION['idusuario'])){
        $fkusuario = $_SESSION['idusuario'];
    }else{
        $fkusuario = 0;
    }

    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CONTA-GOTAS - <?=$_SESSION['estabelecimento']?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="../img/drop.png">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/sweetalert.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../bootstrap/css/estilo.css" />
        
        <script src="../bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/sweetalert.min.js"></script>


    </head>
    <body>

        <?php include('nav_adm.php') ?>

        <?php 
              $query = mysqli_query($conexao, "SELECT extract(month from dataPagto) mes FROM boletos WHERE fkusuario = '$fkusuario' group by mes;");
              $query2 = mysqli_query($conexao, "SELECT extract(year from dataPagto) ano FROM boletos WHERE fkusuario = '$fkusuario' group by ano;");  

              if (isset($_POST['mes']) && isset($_POST['ano'])) {
                $mes= $_POST['mes'];
                $ano = $_POST['ano'];
            }else{
                $mes = date('m');
                $ano = date('Y');
            }
        ?>

        <div class="container-fluid">
            
            <div class="row">

                <div class="col-md-12">

                <div class="modal-content">
                        <div class="modal-header">

                            <h1 class="text-center">TOTAIS</h1>

                        </div>
                        <div class="modal-body">
                            


                                    <div class="form-inline text-center">
                                        <form method="POST" action="totais.php">
                                            <center class="espaco_centro">
                                            <select class="form-control" name="mes">
                                                <option value="<?php echo $mes;?>"><?php echo $mes;?></option>

                                                <?php while($result = mysqli_fetch_array($query)): ?>    
                                                <option value="<?php echo $result['mes'];?>"><?php echo $result['mes'];?></option>
                                                <?php endwhile ?>
                                            
                                            </select>          
                                            <select class="form-control" name="ano">
                                                <option value="<?php echo $ano;?>"><?php echo $ano;?></option>
                                                
                                                <?php while($result2 = mysqli_fetch_array($query2)): ?>    
                                                <option value="<?php echo $result2['ano'];?>"><?php echo $result2['ano'];?></option>
                                                <?php endwhile ?>
                                            
                                            </select>
                                            <button class="btn btn-default">BUSCAR</button>
                                            </center>
                                        </form>
                                    </div>




                        <?php
       
                
                        include('../php/config.php');


                        
                        $query = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(day from dataPagto) dia , extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos b 
                            JOIN caixa c ON c.idcaixa = b.fkcaixa
                            WHERE c.numero_caixa = 1 and month(dataPagto) = $mes and Year(dataPagto) = $ano and c.fkusuario = '$fkusuario' group by dia, mes, ano") or die(mysqli_error($conexao));

                        $query2 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(day from dataPagto) dia , extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos b 
                            JOIN caixa c ON c.idcaixa = b.fkcaixa
                            WHERE c.numero_caixa = 2 and month(dataPagto) = $mes and Year(dataPagto) = $ano and c.fkusuario = '$fkusuario' group by dia, mes, ano") or die(mysqli_error($conexao));

                        $query3 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(day from dataPagto) dia , extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos b 
                            JOIN caixa c ON c.idcaixa = b.fkcaixa
                            WHERE c.numero_caixa = 3 and month(dataPagto) = $mes and Year(dataPagto) = $ano and c.fkusuario = '$fkusuario' group by dia, mes, ano") or die(mysqli_error($conexao));



                        $querytot = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(day from dataPagto) dia , extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos b 
                            JOIN caixa c ON c.idcaixa = b.fkcaixa
                            WHERE month(dataPagto) = $mes and Year(dataPagto) = $ano and c.fkusuario = '$fkusuario' group by dia, mes, ano") or die(mysqli_error($conexao));




                        $cx1 = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = '$fkusuario' and status_caixa = 1 and numero_caixa = 1"));

                        $cx2 = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = '$fkusuario' and status_caixa = 1 and numero_caixa = 2"));

                        $cx3 = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = '$fkusuario' and status_caixa = 1 and numero_caixa = 3"));




                        $cont = mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = '$fkusuario' and status_caixa = 1 ");
                        $num = mysqli_num_rows($cont);



                        if ($mes == 1) {
                            $mes = "JANEIRO";
                        } elseif ($mes == 2) {
                            $mes = "FEVEREIRO";
                        } elseif ($mes == 3) {
                            $mes = "MARÇO";
                        } elseif ($mes == 4) {
                            $mes = "ABRIL";
                        } elseif ($mes == 5) {
                            $mes = "MAIO";
                        } elseif ($mes == 6) {
                            $mes = "JUNHO";
                        } elseif ($mes == 7) {
                            $mes = "JULHO";
                        } elseif ($mes == 8) {
                            $mes = "AGOSTO";
                        } elseif ($mes == 9) {
                            $mes = "SETEMBRO";
                        } elseif ($mes == 10) {
                            $mes = "OUTUBRO";
                        } elseif ($mes == 11) {
                            $mes = "NOVEMBRO";
                        } elseif ($mes == 12) {
                            $mes = "DEZEMBRO";
                        };

                        ?>

                   
                </div>

                <div class="modal-footer">

                <h4 class="text-center"><?=$mes?> de <?=$ano?></h4>


                <h2 class="text-center"><?php if ($num<1) {echo "NENHUM CAIXA CADASTRADO";exit;} ?></h2>     



                <div class="

                <?php if ($num==1) {
                            echo "col-md-6";
                        }if ($num==2) {
                            echo "col-md-4";
                        }if ($num==3) {
                            echo "col-md-3";
                        } ?>                    

                "> 

                    <table class="table table-hover table-striped table-bordered menos_xs">
                        <thead>
                            <tr style="background-color: #064D77; color: white">
                                <th class="text-center" colspan="3"><?=$cx1['nome_caixa']?></th>
                            </tr>
                            <tr style="background-color: #0396D6; color: white">
                                <th>DATA</th>
                                <th>CONTAS</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $qtdtt = 0; $tttt = 0; while($result1 = mysqli_fetch_assoc($query)){ ?>
                            <tr align="left">
                                <td><?=$result1['dia']."/".$result1['mes']."/".$result1['ano'];?></td>
                                <td><?=$result1['qntd']?></td>
                                <td>R$ <?=number_format($result1['total'] ,2,",",".");?></td>
                            </tr>
                        <?php $qtdtt = $qtdtt + $result1['qntd']; $tttt = $tttt + $result1['total']; } ?>
                            <tr align="left" style="background-color: #0396D6; color: white">
                                <td>TOTAL</td>
                                <td><?=$qtdtt?></td>
                                <td>R$ <?=number_format($tttt ,2,",",".");?></td>
                            </tr>
                        </tbody>
                    </table>
           
                </div>


                
                <div class="

                <?php if ($num==1) {
                            echo "none";
                        }if ($num==2) {
                            echo "col-md-4";
                        }if ($num==3) {
                            echo "col-md-3";
                        } ?>                    

                ">     



                    <table class="table table-hover table-striped table-bordered menos_xs">
                        <thead>
                            <tr style="background-color: #064D77; color: white">
                                <th class="text-center" colspan="3"><?=$cx2['nome_caixa']?></th>
                            </tr>
                            <tr style="background-color: #0396D6; color: white">
                                <th>DATA</th>
                                <th>CONTAS</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
              
                        <?php $qtdtt = 0; $tttt = 0; while($result2 = mysqli_fetch_assoc($query2)){ ?>
                            <tr align="left">
                                <td><?=$result2['dia']."/".$result2['mes']."/".$result2['ano'];?></td>
                                <td><?=$result2['qntd']?></td>
                                <td>R$ <?=number_format($result2['total'] ,2,",",".");?></td>
                            </tr>
                        <?php $qtdtt = $qtdtt + $result2['qntd']; $tttt = $tttt + $result2['total']; } ?>
                            <tr align="left" style="background-color: #0396D6; color: white">
                                <td>TOTAL</td>
                                <td><?=$qtdtt?></td>
                                <td>R$ <?=number_format($tttt ,2,",",".");?></td>
                            </tr>
                        </tbody>
                    </table>
          
                </div>
                
                <div class="

                <?php if ($num==1) {
                            echo "none";
                        }if ($num==2) {
                            echo "none";
                        }if ($num==3) {
                            echo "col-md-3";
                        } ?>                    

                ">   



                    <table class="table table-hover table-striped table-bordered menos_xs">
                        <thead>
                            <tr style="background-color: #064D77; color: white">
                                <th class="text-center" colspan="3"><?=$cx3['nome_caixa']?></th>
                            </tr>
                            <tr style="background-color: #0396D6; color: white">
                                <th>DATA</th>
                                <th>CONTAS</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $qtdtt = 0; $tttt = 0; while($result3 = mysqli_fetch_assoc($query3)){ ?>
                            <tr align="left">
                                <td><?=$result3['dia']."/".$result3['mes']."/".$result3['ano'];?></td>
                                <td><?=$result3['qntd']?></td>
                                <td>R$ <?=number_format($result3['total'] ,2,",",".");?></td>
                            </tr>
                        <?php $qtdtt = $qtdtt + $result3['qntd']; $tttt = $tttt + $result3['total']; } ?>
                            <tr align="left" style="background-color: #0396D6; color: white">
                                <td>TOTAL</td>
                                <td><?=$qtdtt?></td>
                                <td>R$ <?=number_format($tttt ,2,",",".");?></td>
                            </tr>
                        </tbody>
                    </table>
          
                </div> 



                <div class="

                <?php if ($num==1) {
                            echo "col-md-6";
                        }if ($num==2) {
                            echo "col-md-4";
                        }if ($num==3) {
                            echo "col-md-3";
                        } ?>                    

                ">  




                    <table class="table table-hover table-striped table-bordered menos_xs">
                        <thead>
                            <tr style="background-color: #064D77; color: white">
                                <th class="text-center" colspan="3">TOTAL</th>
                            </tr>
                            <tr style="background-color: #0396D6; color: white">
                                <th>DATA</th>
                                <th>CONTAS</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $qtdtt = 0; $tttt = 0; while($resulttot = mysqli_fetch_assoc($querytot)){ ?>
                            <tr align="left">
                                <td><?=$resulttot['dia']."/".$resulttot['mes']."/".$resulttot['ano'];?></td>
                                <td><?=$resulttot['qntd']?></td>
                                <td>R$ <?=number_format($resulttot['total'] ,2,",",".");?></td>
                            </tr>
                        <?php $qtdtt = $qtdtt + $resulttot['qntd']; $tttt = $tttt + $resulttot['total']; } ?>
                            <tr align="left" style="background-color: #0396D6; color: white">
                                <td>TOTAL</td>
                                <td><?=$qtdtt?></td>
                                <td>R$ <?=number_format($tttt ,2,",",".");?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>  


                </div>
            </div>            





        <footer></footer>

        </div>


    </body>
</html>

                    