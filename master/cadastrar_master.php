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

                              <a type="button" class="btn" href="home_master.php"  style="background-color: #0396D6; color: white">
                                HOME
                              </a>

                              <a type="button" class="btn" href="cadastrar_master.php" style="background-color: #064D77; color: white">
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
                           
                            <h4 class="text-center">CADASTRAR USUÁRIO</h4>                       

                          <form method="post" action="php_master/cadastrar_master_usu.php">
                              
                              <div class="modal-body">

                              <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                                  <div class="col-md-6">
                                      
                                <label>Nome:</label>  
                                <input type="text" class="form-control" name="nome" placeholder="Nome do usuário" required autofocus>

                                <br>

                                <label>Estabelecimento:</label> 
                                <input type="text" class="form-control" name="estabelecimento" placeholder="Nome da empresa" required>
                                  <br>
                                  </div>
                                  
                                  <div class="col-md-6">
                                  

                                <label>Login:</label>  <label id="resultado" ></label>
                                <input type="text" class="form-control" name="login" id="login" minlength="3" maxlength="20" placeholder="Login para acesso ao sistema" required>

                                <br>

                                <!-- <label>Senha:</label> 
                                <input type="password" class="form-control" name="senha" minlength="5" required> -->


                                <label>Nível:</label> 
                                <select class="form-control" name="nivel" required>
                                    <option value="2">ADMINISTRADOR</option>
                                    <!-- <option value="3">MASTER</option> -->
                                </select>

                                  </div>
                              </div>
                              </div>



                              </div>

                            
                        </div>
                        <div class="modal-footer">
                            
                            <p class="text-center"><button class="btn" id="cadastrar" style="background-color: #0396D6; color: white">CADASTRAR</button></p>
                            
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
                    let valor = u.searchParams.get('cadastrado');
                    if(valor == 'true')
                      swal('Usuário cadastrado com sucesso!', '', 'success');

                    let valor1 = u.searchParams.get('cadastrado');
                    if(valor1 == 'false')
                      swal('Usuário não cadastrado!', 'Login ou estabelecimento já existe no sistema', 'error');
    
              }    

              $("input[name='login']").on('keyup', function(){  
                var login = $(this).val();
                $.get('../php/verificar_login_existente.php?login=' + login, function(data){
                  $('#resultado').html(data.retorno);
                  // var retorno = data.retorno;
                  if (data.retorno == '0') {
                      document.getElementById('cadastrar').removeAttribute('disabled', 'true');
                      var cadastrar = document.getElementById('cadastrar');
                      document.getElementById("resultado").innerHTML = "*";
                      document.getElementById("resultado").style.color = "green";
                  }
                  
                  if (data.retorno == '1') {
                      document.getElementById('cadastrar').setAttribute('disabled', 'true');
                      var cadastrar = document.getElementById('cadastrar');
                      document.getElementById("resultado").innerHTML = "LOGIN EM USO";
                      document.getElementById("resultado").style.color = "red";
                  }


                  
                },"json");
              }); 


     </script>

    </body>
</html>

