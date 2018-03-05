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


    $idcaixa = base64_decode($_GET['idcaixa']);
    $fkusuario = base64_decode($_GET['idusuario']);

    include('../php/config.php');

    $query = mysqli_query($conexao, "SELECT * FROM caixa WHERE idcaixa = $idcaixa AND fkusuario = $fkusuario");
    $caixa = mysqli_fetch_array($query);
    
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
                            
                            <h1 class="text-center">EDITAR <?=$caixa['nome_caixa']?></h1>

                            

                        </div>
                        <div class="modal-body">
                           
                              <div class="row">
                                  <div class="col-md-4 col-md-offset-4">
                                  <form method="POST" action="php_adm/editar_caixas_bd.php"> 
                                        <div class="col-md-6">  
                                        <label>Nome:</label>  
                                        <input type="text" class="form-control" name="nome_caixa" value="<?=$caixa['nome_caixa']?>" required autofocus>

                                        <br>

                                        <label>Login:</label> 
                                        <input type="text" class="form-control" name="login_caixa" value="<?=$caixa['login_caixa']?>" required>
                                        
                                        </div>
                                        <div class="col-md-6"> 

                                        <label>Senha:</label> 
                                        <input type="password" class="form-control" name="senha_caixa" required>

                                        <br>

                                        <label>Caixa:</label> 
                                        <select type="text" class="form-control" name="numero_caixa" required>
                                            <option value="<?=$caixa['numero_caixa']?>"><?=$caixa['numero_caixa']?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>

                                        </div>
                                      
                                  </div>
                              </div>


                            
                        </div>
                        <div class="modal-footer">
                                        <input type="hidden" value="<?=$idcaixa?>" name="idcaixa">
                                        <p class="text-center">
                                        <a href="caixas.php" class="btn btn-danger">CANCELAR</a>    
                                        <button class="btn btn-warning">CONCLUIR</button></p>
                                 </form>   
                        </div>
                    </div>
   
                    
                </div>
                
            </div>

            
        </div>
        


        </div>
     <footer></footer>    
    </body>
</html>

