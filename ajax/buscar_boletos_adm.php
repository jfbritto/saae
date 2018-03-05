<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

            

    include('../php/config.php');

    //fim da conexão com o banco de dados

    $data = $_POST['data'];
    $fkusuario = $_SESSION['idusuario'];

// busca para tabela principal
    $query = mysqli_query($conexao, "SELECT * FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE b.dataPagto = '$data' and b.fkusuario = '$fkusuario' ORDER BY id desc");
    $qtd = mysqli_num_rows($query);




    $query1 = mysqli_query($conexao, "SELECT * FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 1 and c.status_caixa = 1 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $qtd1 = mysqli_num_rows($query1);

    $query2 = mysqli_query($conexao, "SELECT * FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 2 and c.status_caixa = 1 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $qtd2 = mysqli_num_rows($query2);

    $query3 = mysqli_query($conexao, "SELECT * FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 3 and c.status_caixa = 1 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $qtd3 = mysqli_num_rows($query3);




    $total = mysqli_query($conexao, "SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos WHERE dataPagto = '$data' and fkusuario = '$fkusuario'");
    $total = mysqli_fetch_array($total);



    $total1 = mysqli_query($conexao, "SELECT c.numero_caixa, sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 1 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $total1 = mysqli_fetch_array($total1);

    $total2 = mysqli_query($conexao, "SELECT c.numero_caixa, sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 2 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $total2 = mysqli_fetch_array($total2);

    $total3 = mysqli_query($conexao, "SELECT c.numero_caixa, sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 3 and  b.dataPagto = '$data' and b.fkusuario = '$fkusuario'");
    $total3 = mysqli_fetch_array($total3);


    $nome1 = mysqli_fetch_array(mysqli_query($conexao, "SELECT c.nome_caixa as nome FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 1 and c.status_caixa = 1 and b.fkusuario = '$fkusuario' limit 1"));

    $nome2 = mysqli_fetch_array(mysqli_query($conexao, "SELECT c.nome_caixa as nome FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 2 and c.status_caixa = 1 and b.fkusuario = '$fkusuario' limit 1"));

    $nome3 = mysqli_fetch_array(mysqli_query($conexao, "SELECT c.nome_caixa as nome FROM boletos b JOIN caixa c ON c.idcaixa = b.fkcaixa WHERE c.numero_caixa = 3 and c.status_caixa = 1 and b.fkusuario = '$fkusuario' limit 1"));

    
    ?>
    <section class="panel col-md-10" style="width: 100%">

        <header class="panel-heading">
<!--             Dados da busca: -->
        </header>
      
        <?php if($qtd>0){ ?>


           <table class="table table-hover table-striped table-bordered" style="text-align: left; font-size: 18px">
              <thead>
                <tr style="background-color: #0396D6; color: white" class="menos_xs">
                   <th class="hidden-xs">CÓDIGO</th>
                   <th class="hidden-xs" style="vertical-align: middle;">DATA</th>
                   <th style="vertical-align: middle;">HORA</th>
                   <th style="vertical-align: middle;">VALOR</th>
                   <th style="vertical-align: middle;" class="text-center">CAIXA</th>
                   <th style="vertical-align: middle;"></th>
                </tr>
              </thead>
              <tbody>
           <?php while($linha = mysqli_fetch_assoc($query)){ ?>
               <tr class="menos_xs">
                   <td class="hidden-xs" style="vertical-align: middle;"><?=$linha['codBarras'];?></td>
                   <td class="hidden-xs" style="vertical-align: middle;"><?=date('d/m/Y', strtotime($linha['dataPagto']));?></td>
                   <td style="vertical-align: middle;"><?=$linha['hora'];?></td>
                   <td style="vertical-align: middle;">R$ <?=$linha['valorPago'];?></td>
                   <td style="vertical-align: middle;" class="text-center"><font style="<?php if($linha['status_caixa']==0){echo "color: red";}?>"><?=$linha['nome_caixa'];?></font></td>
                   <td style="vertical-align: middle;" class="text-center"><a class="btn btn-danger" title="DELETAR CONTA" onClick="confirmacao(<?php echo $linha['id'];?>)"><span class="glyphicon glyphicon-trash"></span></a></td>
               </tr>           
           <?php $_SESSION['dia'] = $linha['dataPagto'];}?>
              </tbody>
            </table>

            <table class="table table-bordered" style="font-size: 18px; color: white">
              <thead class="text-center menos_xs">
                <tr style="background-color: #064D77; color: white;">
                  <th style="text-align: center">CAIXA</th>
                  <th style="text-align: center">CONTAS</th>
                  <th style="text-align: center">RECEBEU</th>
                </tr>
              </thead>
              <tbody>
              <?php if($qtd1){ ?>
                <tr class="menos_xs">
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?=$nome1['nome'];?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?php echo $qtd1; ?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;">R$ <?php echo number_format($total1['total'] ,2,",","."); ?></td>
               
               </tr>
               <?php }if($qtd2){ ?>  
                <tr class="menos_xs">
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?=$nome2['nome'];?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?php echo $qtd2; ?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;">R$ <?php echo number_format($total2['total'] ,2,",","."); ?></td>
               </tr> 
               <?php }if($qtd3){ ?>
                <tr class="menos_xs">
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?=$nome3['nome'];?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;"><?php echo $qtd3; ?></td>
                   <td style="background-color: #0396D6; text-align: center; vertical-align: middle;">R$ <?php echo number_format($total3['total'] ,2,",","."); ?></td>
               
               </tr>  
               <?php }?>             
                <tr class="menos_xs">
                   <td style="background-color: #064D77; text-align: center; vertical-align: middle;">TOTAL</td>
                   <td style="background-color: #064D77; text-align: center; vertical-align: middle;"><?php echo $qtd; ?></td>
                   <td style="background-color: #064D77; text-align: center; vertical-align: middle;">R$ <?php echo number_format($total['total'] ,2,",","."); ?></td>
               
               </tr>                               
             </tbody>

           </table>
                              

        <?php }else{ ?>

            <h4 class="text-center menos_xs" style="color: red">Nao foram encontrados registros.</h4>

        <?php }?>
    </section>