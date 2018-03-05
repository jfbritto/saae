<?php 
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

    if(isset($_SESSION['idusuario']) && $_SESSION['idusuariomaster'] == "") {
        header('location: ../usu/home.php');
        exit;
    }

    if (isset($_GET['usu'])) {
        $_SESSION['usu'] = $_GET['usu'];
        $_SESSION['dataBol'] = 0;
    }
            

    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CONTA-GOTAS - MASTER</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        <div class="container-fluid">
            
            <div class="row" style="margin-top: 50px">
                

                <div class="col-md-10  col-md-offset-1">


                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h1 class="text-center">MASTER</h1>
                            <h4 class="text-center"><?=$_SESSION['nome'];?></h4>

                            <center class="modal-body">
                            <div class="btn-group text-center"> 

                              <a type="button" class="btn" href="home_master.php"  style="background-color: #064D77; color: white">
                                HOME
                              </a>

                              <a type="button" class="btn" href="cadastrar_master.php" style="background-color: #0396D6; color: white">
                                CADASTRAR
                              </a>

<!--                               <a type="button" class="btn" href="php_master/backup_bd.php?bkpbd=true"  style="background-color: #0396D6; color: white">
                                BACKUP BD
                              </a> -->

                              <a type="button" class="btn" href="movimento_clientes.php"  style="background-color: #0396D6; color: white">
                                MOVIMENTAÇÃO
                              </a>                              

                              <a type="button" class="btn" href="acessos.php"  style="background-color: #0396D6; color: white">
                                ACESSOS
                              </a>

                              <a type="button" class="btn"  href="../index.php?sair=true"  style="background-color: #0396D6; color: white">
                                SAIR
                              </a>

                            </div>
                            </center>
                            
                        </div>
                        <div class="modal-body">
                           
                           <?php 

                            include('../php/config.php');

                            $query = mysqli_query($conexao, "SELECT * FROM usuario") or die(mysqli_error($conexao));
                           ?> 

                            <table class="tble table-hover table-condensed table-striped table-bordered" width="80%" align="center">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center">LOGIN</th>
                                        <th style="vertical-align: middle; text-align: center">NOME</th>
                                        <th style="vertical-align: middle; text-align: center">ESTABELECIMENTO</th>
                                        <th style="vertical-align: middle; text-align: center">NÍVEL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                           
                            <?php while ($result = mysqli_fetch_array($query)) { ?>
                                 
                                    <tr <?php if($result['status']==0){ echo "style=\"background-color:lightgrey\""; }if($result['nivel']==3){ echo "style=\"background-color:lightgreen\""; }?>>
                                        <td style="vertical-align: middle; text-align: center"><?=$result['login']?></td>
                                        <td style="vertical-align: middle; text-align: center"><?=$result['nome']?></td>
                                        <td style="vertical-align: middle; text-align: center"><?=$result['estabelecimento']?></td>
                                        <td style="vertical-align: middle; text-align: center"><?php if($result['nivel']==2){echo "ADMIN";}else{echo "MASTER";}?></td>
                                        <?php if($result['status'] == 1){?>
                                        <td style="vertical-align: middle; text-align: center;"><a style="<?php if($result['nivel'] == 3){echo 'visibility:hidden;';}?>" class="btn btn-danger" href="php_master/alterar_status_master_usu.php?status=0&idusuario=<?=$result['idusuario']?>" title="DESATIVAR USUÁRIO"><span class="glyphicon glyphicon-off"></span></a></td>
                                        <?php }else{?>
                                        <td style="vertical-align: middle; text-align: center"><a  style="<?php if($result['nivel'] == 3){echo 'visibility:hidden;';}?>" class="btn btn-success" href="php_master/alterar_status_master_usu.php?status=1&idusuario=<?=$result['idusuario']?>" title="ATIVAR USUÁRIO"><span class="glyphicon glyphicon-off"></span></a></td>
                                        <?php }?>
                                        <td style="vertical-align: middle; text-align: center;"><a  style="<?php if($result['nivel'] == 3){echo 'visibility:hidden;';}?>" class="btn btn-danger" href="php_master/deletar_master_usu.php?idusuario=<?=$result['idusuario']?>" title="DELETAR" ><span class="glyphicon glyphicon-trash"></span></a></td>
                                        <td style="vertical-align: middle; text-align: center"><a style="<?php if($result['nivel'] == 3){echo 'visibility:hidden;';}?>" class="btn btn-warning" href="editar_master.php?idusuario=<?=$result['idusuario']?>" title="EDITAR"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                    </tr>


                            <?php } ?> 

                                </tbody>
                            </table>



                            
                        </div>
                        <div class="modal-footer">
                            
                            <div id="dados"></div>
                            
                        </div>
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
                      swal('Usuário deletado com sucesso!', '', 'success');

                    let valor1 = u.searchParams.get('deletado');
                    if(valor1 == 'false')
                      swal('Usuário não deletado!', 'Existem registros vinculados ao mesmo', 'error');

                    let valor2 = u.searchParams.get('editado');
                    if(valor2 == 'true')
                      swal('Usuário editado com sucesso!', '', 'success');

                    let valor3 = u.searchParams.get('editado');
                    if(valor3 == 'false')
                      swal('Usuário não editado!', '', 'error');    

                    let valor4 = u.searchParams.get('ativado');
                    if(valor4 == 'true')
                      swal('Usuário ativado com sucesso!', '', 'success');

                    let valor5 = u.searchParams.get('ativado');
                    if(valor5 == 'false')
                      swal('Usuário não ativado!', '', 'error');  

                    let valor6 = u.searchParams.get('finalizado');
                    if(valor6 == 'true')
                      swal('Usuário desativado com sucesso!', '', 'success');

                    let valor7 = u.searchParams.get('finalizado');
                    if(valor7 == 'false')
                      swal('Usuário não desativado!', '', 'error');    

                    let valor8 = u.searchParams.get('bkp');
                    if(valor8 == 'true')
                      swal('Backup efetuado com sucesso!', '', 'success');                      

              }    

     </script>

    </body>
</html>

