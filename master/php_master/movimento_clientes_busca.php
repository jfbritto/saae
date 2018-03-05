<?php

    
            

    include('../../php/config.php');


    $data = $_POST['data'];

    $query = mysqli_query($conexao, "SELECT nome, count(codBarras) as contas, 
sum(cast(replace(replace(valorPago, '.', ''), ',', '.') as decimal(10,2))) as total FROM usuario u 
                                     JOIN boletos b ON b.fkusuario = u.idusuario 
                                     WHERE dataPagto = '$data' GROUP BY nome ASC");
    $qtd = mysqli_num_rows($query);
    // $qtd = 1;

    ?>
    <section class="panel col-lg-9" style="width: 100%">

        <header class="panel-heading">
<!--             Dados da busca: -->
        </header>
        <?php if($qtd>0){ ?>

           <table class="table table-hover table-striped table-bordered" style="text-align: left; font-size: 18px">
              <thead>
                <tr style="background-color: #0396D6; color: white">
                 <td style="vertical-align: middle;">CLIENTE</td>
                 <td style="vertical-align: middle;">CONTAS</td>
                 <td style="vertical-align: middle;">MOVIMENTAÇÃO</td>
                </tr>
              </thead> 
              <tbody>
           <?php while($linha = mysqli_fetch_assoc($query)){ ?>
           <tr>
               <td  style="vertical-align: middle;"><?=$linha['nome'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['contas'];?></td>
               <td  style="vertical-align: middle;">R$ <?php echo $tot = str_replace(".", ",", $linha['total']);?></td>
           </tr>           
           <?php }?>
              </tbody>
            </table>  

        <?php }else{ ?>

            <h4 class="text-center" style="color: red">Nao foram encontrados registros.</h4>

        <?php }?>
    </section>