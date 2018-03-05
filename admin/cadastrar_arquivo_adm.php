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

                            

                            
                        </div>
                        <div class="modal-body">
                           
                              <div class="row">
                                  <div class="col-md-8 col-md-offset-2">

                                    <form method="POST" action="php_adm/cadastrar_cabecalho_arq.php">

                                    <div class="row" style="line-height: 30px">
                                        <div class="col-md-3">   
                                            <label>Código convênio:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="cod_convenio" placeholder="Código do convênio(empresa)"> 
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nome convênio:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="nome_convenio" placeholder="Nome do convênio (empresa)">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Código banco:</label>
                                            <input type="text" style="text-align: center" maxlength="3" class="form-control" name="cod_banco" placeholder="Código do banco">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nome banco:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="nome_banco" placeholder="Nome do banco">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Código da agência arrecadadora:</label>
                                            <input type="text" style="text-align: center" maxlength="8" class="form-control" name="ag_arrecadadora" placeholder="Agência arrecadadora">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Conta creditada:</label>
                                            <input type="text" style="text-align: center" maxlength="20" class="form-control" name="conta_creditada" placeholder="Conta a ser creditada">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Número de autenticação:</label>
                                            <input type="text" style="text-align: center" maxlength="23" class="form-control" name="numero_autenticacao" placeholder="Número de autenticação">
                                        </div>                                        
                                    </div>

                                                
                                  </div>
                              </div>


                            
                        </div>
                        <div class="modal-footer">
                            
                                        <p class="text-center">
                                            <a class="btn btn-danger" style="<?php echo ($atv == 1 ? 'display:none;' : '') ?>" href="cadastrar_editar_arquivo.php">CANCELAR</a>
                                            <button class="btn btn-success">CADASTRAR</button>
                                        </p>
                                 </form>   

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

                }


         
     </script>

    </body>
</html>

