<?php
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }
    
    $caixa = $_SESSION['idcaixa'];
    $fkusuario = $_SESSION['idusuario'];
             
            

    include('../php/config.php');

    //fim da conexão com o banco de dados

    $data = $_POST['data'];

    $query = mysqli_query($conexao, "SELECT * FROM boletos WHERE fkcaixa = '$caixa' and dataPagto = '$data' and fkusuario = '$fkusuario' ORDER BY id desc");
    $qtd = mysqli_num_rows($query);

    $total = mysqli_query($conexao, "SELECT sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM boletos WHERE fkcaixa = '$caixa' and fkusuario = '$fkusuario' and dataPagto = '$data'");
    $total = mysqli_fetch_array($total);
    ?>
    <section class="panel col-lg-9" style="width: 100%">

        <header class="panel-heading">
<!--             Dados da busca: -->
        </header>
        <?php if($qtd>0){ ?>

           <table class="table table-hover table-striped table-bordered" style="text-align: left; font-size: 18px">
              <thead>
                <tr style="background-color: #0396D6; color: white">
                 <td class="hidden-xs" style="vertical-align: middle;">CÓDIGO</td>
                 <td style="vertical-align: middle;">DATA</td>
                 <td style="vertical-align: middle;">HORA</td>
                 <td style="vertical-align: middle;">VALOR</td>
                 <td style="vertical-align: middle;"></td>
                </tr>
              </thead> 
              <tbody>
           <?php while($linha = mysqli_fetch_assoc($query)){ ?>
           <tr>
               <td class="hidden-xs" style="vertical-align: middle;"><?=$linha['codBarras'];?></td>
               <td  style="vertical-align: middle;"><?=date('d/m/Y', strtotime($linha['dataPagto']));?></td>
               <td  style="vertical-align: middle;"><?=$linha['hora'];?></td>
               <td  style="vertical-align: middle;">R$ <?=$linha['valorPago'];?></td>
               <td  style="vertical-align: middle; text-align: center;"><a class="btn btn-warning" title="IMPRIMIR RECIBO" href="../php/gerar_recibo.php?id=<?php echo $linha['id'];?>" onclick="window.open(this.href,'galeria','width=680,height=470'); return false;"><span class="glyphicon glyphicon-print"></span></a></td>
           </tr>           
           <?php $_SESSION['dia'] = $linha['dataPagto'];}?>
              </tbody>
            </table>  

            <table class="table table-bordered" style="font-size: 18px; color: white">
              <tr>
                <th style="background-color: #0396D6; text-align: center; vertical-align: middle;">CONTAS RECEBIDAS:</b> <?php echo $qtd; ?></th>
                <th style="background-color: #0396D6; text-align: center; vertical-align: middle;">TOTAL:</b> R$ <?php echo number_format($total['total'] ,2,",","."); ?></th>
                <th class="hidden-xs"><a title="APÓS GERADO, O ARQUIVO ESTARÁ DISPONÍVEL NO TOPO DA LISTA, NA SESSÃO 'ARQUIVOS'" class="btn btn-block btn-success btn-lg" id="gerar" onClick="confirmacao()" href="#">GERAR ARQUIVO FINAL DE <?php echo date('d/m/Y', strtotime($data));?></a></th>
              </tr>
            </table>

        <?php }else{ ?>

            <h4 class="text-center" style="color: red">Nao foram encontrados registros.</h4>

        <?php }?>
    </section>