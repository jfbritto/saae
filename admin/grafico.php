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

$tot1 = 0;
$tot2 = 0;
$tot3 = 0;
$tot4 = 0;
$tot5 = 0;
$tot6 = 0;
$tot7 = 0;
$tot8 = 0;
$tot9 = 0;
$tot10 = 0;
$tot11 = 0;
$tot12 = 0;

$menosdineiro = 2000;
$menosconta = 50;
    
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

              if (isset($_POST['ano'])) {
                $ano = $_POST['ano'];
            }else{
                $ano = date('Y');
            }
        ?>

        <div class="container-fluid">





            <div class="row">
                <div class="col-md-0 col-lg-0"></div>

                <div class="col-md-12">
                    <div class="modal-content">
                        <div class="modal-header">

                                <h1 class="text-center">GRÁFICOS</h1>
                        </div>
                        <div class="modal-body">        


                                        <div class="form-inline text-center">
                                            <form method="POST" action="grafico.php">
                                                <center class="espaco_centro">
         
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


                        </div>
                    </div>
                </div>
            </div>

            <br>












            <div class="row">
                <div class="col-md-0 col-lg-0"></div>

                <div class="col-md-12  col-lg-12">

                <div class="modal-content">
                        <div class="modal-header">

                            <h3 class="text-center">CONTAS RECEBIDAS</h3>
                            <h4 class="text-center"><?=$ano?></h4>
                    
                        </div>

                        <div class="modal-body">
                            





                        <?php
       
                
                        include('../php/config.php');

//coluna 1
                        $query1 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 01 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha1 = mysqli_fetch_assoc($query1);
                        $val = $linha1['qntd'];
                        $cont = 0;



                        

                        while ($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot1 = $cont;
//coluna 2
                        $query2 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 02 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha2 = mysqli_fetch_assoc($query2);
                        $val = $linha2['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot2 = $cont;
//coluna 3
                        $query3 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 03 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha3 = mysqli_fetch_assoc($query3);
                        $val = $linha3['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot3 = $cont;                        
//coluna 4
                        $query4 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 04 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha4 = mysqli_fetch_assoc($query4);
                        $val = $linha4['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot4 = $cont;                        
//coluna 5                        
                        $query5 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 05 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha5 = mysqli_fetch_assoc($query5);
                        $val = $linha5['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot5 = $cont;                        
//coluna 6                        
                        $query6 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 06 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha6 = mysqli_fetch_assoc($query6);
                        $val = $linha6['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot6 = $cont;                        
//coluna 7
                        $query7 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 07 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha7 = mysqli_fetch_assoc($query7);
                        $val = $linha7['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot7 = $cont;                        
//coluna 8
                        $query8 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 08 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha8 = mysqli_fetch_assoc($query8);
                        $val = $linha8['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot8 = $cont;                        
//coluna 9
                        $query9 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 09 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha9 = mysqli_fetch_assoc($query9);
                        $val = $linha9['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot9 = $cont;                        
//coluna 10
                        $query10 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 10 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha10 = mysqli_fetch_assoc($query10);
                        $val = $linha10['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot10 = $cont;                        
//coluna 11                        
                        $query11 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 11 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha11 = mysqli_fetch_assoc($query11);
                        $val = $linha11['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot11 = $cont;                        
//coluna 12                        
                        $query12 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 12 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha12 = mysqli_fetch_assoc($query12);  
                        $val = $linha12['qntd'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosconta;
                            $cont++;
                        }

                        $tot12 = $cont;                                              
                        

                        ?>






            <div class="container">
            

                <div class="row rotate">

                    <!-- <div class="col-xs-12"> -->

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot12; $i++) { ?>
                                <div class="col-xs-12 jan"></div>
                            <?php } ?>  
                            <div class="col-xs-12 bar-tot"><?php echo $linha12['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot11; $i++) { ?>
                                <div class="col-xs-12 fev"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha11['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot10; $i++) { ?>
                                <div class="col-xs-12 mar"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha10['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot9; $i++) { ?>
                                <div class="col-xs-12 abr"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha9['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot8; $i++) { ?>
                                <div class="col-xs-12 mai"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha8['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot7; $i++) { ?>
                                <div class="col-xs-12 jun"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha7['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot6; $i++) { ?>
                                <div class="col-xs-12 jul"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha6['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot5; $i++) { ?>
                                <div class="col-xs-12 ago"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha5['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot4; $i++) { ?>
                                <div class="col-xs-12 set"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha4['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot3; $i++) { ?>
                                <div class="col-xs-12 out"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha3['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot2; $i++) { ?>
                                <div class="col-xs-12 nov"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha2['qntd'];?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot1; $i++) { ?>
                                <div class="col-xs-12 dez"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php echo $linha1['qntd'];?></div>
                        </div>

                    <!-- </div> -->

                </div>
                <div class="row">

                    <div class="col-xs-12">

                        <div class="col-xs-1 bar">JAN</div>
                        <div class="col-xs-1 bar">FEV</div>
                        <div class="col-xs-1 bar">MAR</div>
                        <div class="col-xs-1 bar">ABR</div>
                        <div class="col-xs-1 bar">MAI</div>
                        <div class="col-xs-1 bar">JUN</div>
                        <div class="col-xs-1 bar">JUL</div>
                        <div class="col-xs-1 bar">AGO</div>
                        <div class="col-xs-1 bar">SET</div>
                        <div class="col-xs-1 bar">OUT</div>
                        <div class="col-xs-1 bar">NOV</div>
                        <div class="col-xs-1 bar">DEZ</div>
                        
                    </div>

                </div>

            </div>



                            
                        </div>
                </div>        
                </div>

                <div class="col-md-0 col-lg-0"></div>

            </div>














            <br>

            <div class="row">
                <div class="col-md-0 col-lg-0"></div>

                <div class="col-md-12  col-lg-12">

                <div class="modal-content">
                        <div class="modal-header">


                            <h3 class="text-center">VALORES MOVIMENTADOS</h3>
                            <h4 class="text-center"><?=$ano?></h4>

                        </div>
                        <div class="modal-body">
                            



                        <?php
       
                
                        include('../php/config.php');

//coluna 1
                        $query1 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 01 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha1 = mysqli_fetch_assoc($query1);
                        $val = $linha1['total'];
                        $cont = 0;



                        

                        while ($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot1 = $cont;
//coluna 2
                        $query2 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 02 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha2 = mysqli_fetch_assoc($query2);
                        $val = $linha2['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot2 = $cont;
//coluna 3
                        $query3 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 03 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha3 = mysqli_fetch_assoc($query3);
                        $val = $linha3['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot3 = $cont;                        
//coluna 4
                        $query4 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 04 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha4 = mysqli_fetch_assoc($query4);
                        $val = $linha4['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot4 = $cont;                        
//coluna 5                        
                        $query5 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 05 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha5 = mysqli_fetch_assoc($query5);
                        $val = $linha5['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot5 = $cont;                        
//coluna 6                        
                        $query6 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 06 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha6 = mysqli_fetch_assoc($query6);
                        $val = $linha6['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot6 = $cont;                        
//coluna 7
                        $query7 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 07 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha7 = mysqli_fetch_assoc($query7);
                        $val = $linha7['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot7 = $cont;                        
//coluna 8
                        $query8 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 08 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha8 = mysqli_fetch_assoc($query8);
                        $val = $linha8['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot8 = $cont;                        
//coluna 9
                        $query9 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 09 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha9 = mysqli_fetch_assoc($query9);
                        $val = $linha9['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot9 = $cont;                        
//coluna 10
                        $query10 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 10 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha10 = mysqli_fetch_assoc($query10);
                        $val = $linha10['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot10 = $cont;                        
//coluna 11                        
                        $query11 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 11 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha11 = mysqli_fetch_assoc($query11);
                        $val = $linha11['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot11 = $cont;                        
//coluna 12                        
                        $query12 = mysqli_query($conexao, "
                            SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total, count(codBarras) as qntd, extract(month from dataPagto) mes, extract(year from dataPagto) ano 
                            FROM boletos 
                            WHERE month(dataPagto) = 12 and Year(dataPagto) = $ano and fkusuario = '$fkusuario' group by mes, ano") or die(mysqli_error($conexao));    
                        $linha12 = mysqli_fetch_assoc($query12);  
                        $val = $linha12['total'];
                        $cont = 0;




                        while($val>0){
                            $val = $val - $menosdineiro;
                            $cont++;
                        }

                        $tot12 = $cont;                                              
                        

                        ?>






            <div class="container">
            

                <div class="row rotate">

                    <!-- <div class="col-xs-12"> -->

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot12; $i++) { ?>
                                <div class="col-xs-12 jan"></div>
                            <?php } ?>  
                            <div class="col-xs-12 bar-tot"><?php if($linha12['total']){ echo 'R$'.number_format($linha12['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot11; $i++) { ?>
                                <div class="col-xs-12 fev"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha11['total']){ echo 'R$'.number_format($linha11['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot10; $i++) { ?>
                                <div class="col-xs-12 mar"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha10['total']){ echo 'R$'.number_format($linha10['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot9; $i++) { ?>
                                <div class="col-xs-12 abr"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha9['total']){ echo 'R$'.number_format($linha9['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot8; $i++) { ?>
                                <div class="col-xs-12 mai"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha8['total']){ echo 'R$'.number_format($linha8['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot7; $i++) { ?>
                                <div class="col-xs-12 jun"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha7['total']){ echo 'R$'.number_format($linha7['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot6; $i++) { ?>
                                <div class="col-xs-12 jul"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha6['total']){ echo 'R$'.number_format($linha6['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot5; $i++) { ?>
                                <div class="col-xs-12 ago"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha5['total']){ echo 'R$'.number_format($linha5['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot4; $i++) { ?>
                                <div class="col-xs-12 set"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha4['total']){ echo 'R$'.number_format($linha4['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot3; $i++) { ?>
                                <div class="col-xs-12 out"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha3['total']){ echo 'R$'.number_format($linha3['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot2; $i++) { ?>
                                <div class="col-xs-12 nov"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha2['total']){ echo 'R$'.number_format($linha2['total'] ,2,",",".");}?></div>
                        </div>

                        <div class="col-xs-1">
                            <?php for ($i=0; $i < $tot1; $i++) { ?>
                                <div class="col-xs-12 dez"></div>
                            <?php } ?>              
                            <div class="col-xs-12 bar-tot"><?php if($linha1['total']){ echo 'R$'.number_format($linha1['total'] ,2,",",".");}?></div>
                        </div>

                    <!-- </div> -->

                </div>
                <div class="row">

                    <div class="col-xs-12">

                        <div class="col-xs-1 bar">JAN</div>
                        <div class="col-xs-1 bar">FEV</div>
                        <div class="col-xs-1 bar">MAR</div>
                        <div class="col-xs-1 bar">ABR</div>
                        <div class="col-xs-1 bar">MAI</div>
                        <div class="col-xs-1 bar">JUN</div>
                        <div class="col-xs-1 bar">JUL</div>
                        <div class="col-xs-1 bar">AGO</div>
                        <div class="col-xs-1 bar">SET</div>
                        <div class="col-xs-1 bar">OUT</div>
                        <div class="col-xs-1 bar">NOV</div>
                        <div class="col-xs-1 bar">DEZ</div>
                        
                    </div>

                </div>

            </div>



                            
                        </div>
                </div>        
                </div>

                <div class="col-md-0 col-lg-0"></div>

            </div>


                            
        </div>
    <footer></footer>
    </body>
</html>

                    