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

    $idusuario = $_SESSION['idusuario'];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CONTA-GOTAS - <?=$_SESSION['estabelecimento']?></title>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="../img/drop.png">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/sweetalert.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../bootstrap/css/estilo.css" />
        
        <script src="../bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../ferramentas/Numeral/numeral.js"></script>
        <script type="text/javascript" src="../bootstrap/js/sweetalert.min.js"></script>


    </head>
    <body>

    <?php include('nav_adm.php') ?>


        <div class="container-fluid">
            
            <div class="row">
                

                <div class="col-md-12  col-lg-12">


                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h1 class="text-center">CAIXAS</h1>

                            <center class="modal-body">
                            <div class="btn-group text-center"> 

                              <a type="button" class="btn menos_xs" href="caixas.php" style="background-color: #064D77; color: white">
                                CAIXAS
                              </a>

                              <a type="button" class="btn menos_xs" href="cadastrar_caixas.php" style="background-color: #0396D6; color: white">
                                CADASTRAR CAIXA
                              </a>

                            </div>
                            </center>
                            
                        </div>
                        <div class="modal-body">
                           
                           <?php 

                            $query = mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = $idusuario") or die(mysqli_error($conexao));
                            $num = mysqli_num_rows($query);
                            if ($num<=0) {
                                echo "<center style=\"color:red\"><h4>Nenhum caixa cadastrado</h4></center>";
                                exit;
                            }
                           ?> 

                            <table class="tble table-hover table-condensed table-striped table-bordered menos_xs" width="60%" align="center">
                                <thead>
                                    <tr style="background-color: #0396D6; color: white">
                                        <th class="hidden-xs" style="vertical-align: middle; text-align: center">CAIXA</th>
                                        <th style="vertical-align: middle; text-align: center">NOME</th>
                                        <th style="vertical-align: middle; text-align: center">LOGIN</th>
                                        <th width="100" style="vertical-align: middle; text-align: center" title="Aqui você pode ativar ou desativar a conta do funcionário cadastrado!"><label class="btn btn-primary btn-xs" style="border-radius: 30%">?</label></th>
                                        <th width="100" style="vertical-align: middle; text-align: center" title="Aqui você pode deletar o cadastro do funcionário!"><label class="btn btn-primary btn-xs" style="border-radius: 30%">?</label></th>
                                        <th width="100" style="vertical-align: middle; text-align: center" title="Aqui você pode editar as informações cadastradas sobre o funcionário!"><label class="btn btn-primary btn-xs" style="border-radius: 30%">?</label></th>

                                    </tr>
                                </thead>
                            
                                <tbody>
                           
                            <?php while ($result = mysqli_fetch_array($query)) { ?>
                                 
                                    <tr <?php if($result['status_caixa']==0){ echo "style=\"background-color:lightgrey\""; }?>>
                                        <td class="hidden-xs" style="vertical-align: middle; text-align: center"><?=$result['numero_caixa']?></td>
                                        <td style="vertical-align: middle; text-align: center"><?=$result['nome_caixa']?></td>
                                        <td style="vertical-align: middle; text-align: center"><?=$result['login_caixa']?></td>


                                        <?php if($result['status_caixa']==1){ ?>  
                                            <td style="vertical-align: middle; text-align: center"><a class="btn btn-danger" href="php_adm/editar_status_caixa.php?ncx=<?=$result['numero_caixa']?>&st=0&idcaixa=<?=$result['idcaixa']?>" title="DESATIVAR FUNCIONÁRIO"><span class="glyphicon glyphicon-off"></span></a></td>
                                        <?php }else{ ?>
                                            <td style="vertical-align: middle; text-align: center"><a class="btn btn-success" href="php_adm/editar_status_caixa.php?ncx=<?=$result['numero_caixa']?>&st=1&idcaixa=<?=$result['idcaixa']?>" title="ATIVAR FUNCIONÁRIO!"><span class="glyphicon glyphicon-off"></span></a></td>
                                        <?php } ?>


                                        <td style="vertical-align: middle; text-align: center"><a class="btn btn-danger" href="php_adm/deletar_caixa.php?idusuario=<?=$idusuario;?>&idcaixa=<?=$result['idcaixa']?>" title="DELETAR FUNCIONÁRIO"><span class="glyphicon glyphicon-trash"></span></a></td>

                                        <td style="vertical-align: middle; text-align: center"><a class="btn btn-warning" href="editar_caixa.php?idusuario=<?=base64_encode($idusuario);?>&idcaixa=<?=base64_encode($result['idcaixa']);?>" title="EDITAR FUNCIONÁRIO"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                    </tr>


                            <?php } ?> 

                                </tbody>
                            </table>



                            
                        </div>
                        <div class="modal-footer"></div>
                    </div>
   
                    
                </div>
                
            </div>

            
        </div>
    
        </div>
     <footer></footer>


     <script type="text/javascript">
         

                window.onload = function(){
                    let url = window.location;
                    let u = new URL(url);
                    let valor = u.searchParams.get('deletado');
                    if(valor == 'true')
                      swal('Deletado com sucesso!', '', 'success');

                    let valor1 = u.searchParams.get('deletado');
                    if(valor1 == 'false')
                      swal('Caixa não deletado!', 'Existem contas vinculadas ao mesmo!', 'error');

                    let valor2 = u.searchParams.get('editado');
                    if(valor2 == 'true')
                      swal('Editado com sucesso!', '', 'success');

                    let valor4 = u.searchParams.get('editado');
                    if(valor4 == 'false')
                      swal('Caixa não editado!', '', 'error');

                    let valor5 = u.searchParams.get('ativado');
                    if(valor5 == 'true')
                      swal('Ativado com sucesso!', '', 'success');

                    let valor6 = u.searchParams.get('ativado');
                    if(valor6 == 'false')
                      swal('Caixa não pode ser ativado!', '', 'error');


                    let valor7 = u.searchParams.get('desativado');
                    if(valor7 == 'true')
                      swal('Desativado com sucesso!', '', 'success');

                    let valor8 = u.searchParams.get('desativado');
                    if(valor8 == 'false')
                      swal('Caixa não pode ser desativado!', '', 'error');

                    let valor9 = u.searchParams.get('naoativado');
                    if(valor9 == 'true')
                      swal('Caixa não pode ser ativado!', 'Existe outro caixa com a mesma numeração ativa!', 'error');

                }


     </script>

    </body>
</html>

