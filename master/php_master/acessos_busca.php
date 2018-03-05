<?php

    
            

    include('../../php/config.php');


    $data = $_POST['data'];

    $query = mysqli_query($conexao, "SELECT * FROM acesso WHERE data = '$data' ORDER BY primeira_visita");
    $qtd = mysqli_num_rows($query);

    ?>
    <section class="panel col-lg-9" style="width: 100%">

        <header class="panel-heading">
<!--             Dados da busca: -->
        </header>
        <?php if($qtd>0){ ?>

           <table class="table table-hover table-striped table-bordered" style="text-align: left; font-size: 18px">
              <thead>
                <tr style="background-color: #0396D6; color: white">
                 <td style="vertical-align: middle;">IP</td>
                 <td style="vertical-align: middle;">PRIMEIRO ACESSO</td>
                 <td style="vertical-align: middle;">ÚLTIMO ACESSO</td>
                 <td style="vertical-align: middle;">QUANTIDADE</td>
                 <td style="vertical-align: middle;">CIDADE</td>
                 <td style="vertical-align: middle;">ESTADO</td>
                 <td style="vertical-align: middle;">PAÍS</td>
                 <td style="vertical-align: middle;">PROVEDOR</td>
                </tr>
              </thead> 
              <tbody>
           <?php while($linha = mysqli_fetch_assoc($query)){ ?>
           <tr>
               <td  style="vertical-align: middle;"><?=$linha['ip'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['primeira_visita'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['ultima_visita'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['quantidade'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['cidade'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['estado'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['pais'];?></td>
               <td  style="vertical-align: middle;"><?=$linha['provedor'];?></td>
           </tr>           
           <?php }?>
              </tbody>
            </table>  

        <?php }else{ ?>

            <h4 class="text-center" style="color: red">Nao foram encontrados registros.</h4>

        <?php }?>
    </section>