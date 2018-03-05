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
            

    $idusuario = $_GET['idusuario'];

    include('../php/config.php');

    $sql = "SELECT * FROM usuario WHERE idusuario = $idusuario";
    $query = mysqli_query($conexao, $sql);
    $result = mysqli_fetch_array($query);

    
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
                <div class="col-md-3 col-lg-3"></div>

                <div class="col-md-6  col-lg-6">


                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h1 class="text-center">MASTER</h1>
                            <h4 class="text-center"><?=$_SESSION['nome'];?></h4>

                            
                        </div>
                        <div class="modal-body">
                           
                            <h4 class="text-center">EDITAR USUÁRIO</h4>                       

                          <form method="post" action="php_master/editar_master_usu.php">
                              
                              <div class="modal-body">

                              <div class="row">
                                  <div class="col-md-6">
                                      
                                <label>Nome:</label>  
                                <input type="text" class="form-control" name="nome" value="<?=$result['nome']?>" required autofocus>

                                <br>

                                <label>Estabelecimento:</label> 
                                <input type="text" class="form-control" name="estabelecimento" value="<?=$result['estabelecimento']?>" required>
                                  
                                  </div>
                                  <div class="col-md-6">
                                  

                                <label>Login:</label>  <label id="resultado" ></label>
                                <input type="text" class="form-control" name="login" minlength="5" value="<?=$result['login']?>" required>

                                <br>

                                <label>Senha:</label> 
                                <input type="password" class="form-control" name="senha" minlength="5" required>


                                  </div>
                              </div>



                                <br>

                                <label>Nível:</label> 
                                <select class="form-control" name="nivel" required>
                                    <option value="<?=$result['nivel']?>"><?php if($result['nivel']==2){echo "ADMINISTRADOR";}else{echo "MASTER";}?></option>
                                    <option value="2">ADMINISTRADOR</option>
                                    <option value="3">MASTER</option>
                                </select>

                              </div>

                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idusuario" value="<?=$result['idusuario']?>">
                            <p class="text-center"><a type="button" class="btn btn-danger" href="home_master.php">
                                CANCELAR EDIÇÃO
                              </a>
                            <button class="btn" style="background-color: #0396D6; color: white">EDITAR</button></p>
                            
                        </div>
                    </div>
   
                    
                </div>
                
            </div>

            <div class="col-md-3 col-lg-3"></div>
        </div>
        


        </div>
     <footer></footer>    
    </body>
</html>

