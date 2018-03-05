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
                            
                            <h1 class="text-center">CADASTRAR CAIXA</h1>

                            <center class="modal-body">
                            <div class="btn-group text-center"> 

                              <a type="button" class="btn menos_xs" href="caixas.php" style="background-color: #0396D6; color: white">
                                CAIXAS
                              </a>

                              <a type="button" class="btn menos_xs" href="cadastrar_caixas.php" style="background-color: #064D77; color: white">
                                CADASTRAR CAIXA
                              </a>

                            </div>
                            </center>
                            
                        </div>
                        <div class="modal-body">
                           
                              <div class="row">
                                  <div class="col-md-4 col-md-offset-4">
                                  <form method="POST" action="php_adm/cadastrar_caixas_bd.php"> 
                                        <div class="col-md-6 col-md-offset-3">  
                                        <label>Nome:</label>  
                                        <input type="text" class="form-control" name="nome_caixa" placeholder="Nome do funcionário" required autofocus>

                                        <br>

                                        <label>Login:</label> 
                                        <input type="text" class="form-control" name="login_caixa" placeholder="Login" required>
                                        

                                        <!-- <label>Senha:</label> 
                                        <input type="password" class="form-control" name="senha_caixa" placeholder="senha do caixa" required> -->

                                        <br>

                                        <label>Caixa:</label> 
                                        <select type="text" class="form-control" name="numero_caixa" required>
                                            <option>-</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>

                                        </div>
                                      
                                  </div>
                              </div>


                            
                        </div>
                        <div class="modal-footer">
                            
                                        <p class="text-center"><button class="btn" style="background-color: #0396D6; color: white">CADASTRAR</button></p>
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

                    let valor = u.searchParams.get('naocadastrado');
                    if(valor == 'true')
                      swal('Caixa não pode ser cadastrado!', 'Existe outro caixa com a mesma numeração ou login ativos!', 'error');

                    let valor1 = u.searchParams.get('cadastrado');
                    if(valor1 == 'true')
                      swal('Cadastrado com sucesso!', '', 'success');

                    let valor2 = u.searchParams.get('cadastrado');
                    if(valor2 == 'false')
                      swal('Caixa não pode ser cadastrado!', '!', 'error');

                }


         
     </script>

    </body>
</html>

