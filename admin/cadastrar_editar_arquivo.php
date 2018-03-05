<?php 
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        header('location: ../index.php?naologado=true');
        exit;
    }

    if(isset($_SESSION['idusuario']) && $_SESSION['idusuarioadmin'] == "") {
        header('location: ../usu/home.php');
        exit;
    }

    if(isset($_GET['atv'])){$atv=$_GET['atv'];}else{$atv = 1;}
    include('../php/config.php');
    
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
                            
                            <h1 class="text-center">CABEÇALHO DO ARQUIVO</h1>
                            <h3 class="text-center" style="color: #E7A64B;<?php echo ($atv == 1 ? 'display: none' : '') ?>">EDITANDO</h3>
                            

                            
                        </div>
                        <div class="modal-body">
                           
                              <div class="row">
                                  <div class="col-md-8 col-md-offset-2">

                                    <?php
                                        $idusuario = $_SESSION['idusuario'];
                                        $query = mysqli_query($conexao, "SELECT * FROM arquivo WHERE fkusuario = $idusuario") or die(mysqli_error($conexao));
                                        $cont = mysqli_num_rows($query);
                                        $result = mysqli_fetch_array($query);
                                        
                                        if($cont>0){
                                    ?>
                                    <form method="POST" action="php_adm/editar_cabecalho_arq.php">

                                    <div class="row" style="line-height: 30px">

                                        <div class="col-md-3">   
                                            <label>Código convênio:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="cod_convenio" value="<?=$result['arq_codconvenio'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>> 
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nome convênio:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="nome_convenio" value="<?=$result['arq_nomeconvenio'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Código banco:</label>
                                            <input type="text" style="text-align: center" maxlength="3" class="form-control" name="cod_banco" value="<?=$result['arq_codbanco'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nome banco:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="nome_banco" value="<?=$result['arq_nomebanco'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Conta creditada:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="conta_creditada" value="<?=$result['conta_creditada'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Código da agência arrecadadora:</label>
                                            <input type="text" style="text-align: center" maxlength="8" class="form-control" name="ag_arrecadadora" value="<?=$result['ag_arrecadadora'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Número de autenticação:</label>
                                            <input type="text" style="text-align: center" maxlength="23" class="form-control" name="numero_autenticacao" value="<?=$result['numero_autenticacao'];?>" <?php echo ($atv == 1 ? 'disabled' : '') ?>>
                                        </div>

                                    </div>

                                                
                                  </div>
                              </div>


                            
                        </div>
                        <div class="modal-footer">
                                        <p class="text-center"><a class="btn btn-danger" style="<?php echo ($atv == 1 ? 'display:none;' : '') ?>" href="cadastrar_editar_arquivo.php">CANCELAR</a>
                                            <a class="btn btn-warning" style="<?php echo ($atv == 1 ? '' : 'display:none;') ?>" href="cadastrar_editar_arquivo.php?atv=0">EDITAR</a>
                                            <button class="btn btn-success" style="<?php echo ($atv == 1 ? 'display:none;' : '') ?>">CONCLUIR</button></p>
                                 </form>   
                                 <?php }else{?>
                                    <h4 class="text-center" style="color: red">ARQUIVO NÃO CADASTRADO.</h4>
                                    <p class="text-center"><a class="btn btn-success" href="cadastrar_arquivo_adm.php">CADASTRAR</a></p>
                                 <?php }?>
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

                    let valor1 = u.searchParams.get('editado');
                    if(valor1 == 'true')
                      swal('Editado com sucesso!', '', 'success');

                    let valor2 = u.searchParams.get('editado');
                    if(valor2 == 'false')
                      swal('Arquivo não pode ser editado!', '!', 'error');

                    let valor3 = u.searchParams.get('cadastrado');
                    if(valor3 == 'true')
                      swal('Cadastrado com sucesso!', '', 'success');

                    let valor4 = u.searchParams.get('cadastrado');
                    if(valor4 == 'false')
                      swal('Arquivo não pode ser cadastrado!', '!', 'error');                  

                }


         
     </script>

    </body>
</html>

