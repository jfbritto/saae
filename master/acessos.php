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

                              <a type="button" class="btn" href="cadastrar_master.php" style="background-color: #0396D6; color: white">
                                CADASTRAR
                              </a>

<!--                               <a type="button" class="btn" href="php_master/backup_bd.php?bkpbd=true"  style="background-color: #0396D6; color: white">
                                BACKUP BD
                              </a> -->

                              <a type="button" class="btn" href="movimento_clientes.php"  style="background-color: #0396D6; color: white">
                                MOVIMENTAÇÃO
                              </a>                              

                              <a type="button" class="btn" href="acessos.php"  style="background-color: #064D77; color: white">
                                ACESSOS
                              </a>

                              <a type="button" class="btn"  href="../index.php?sair=true"  style="background-color: #0396D6; color: white">
                                SAIR
                              </a>

                            </div>
                            </center>
                            
                        </div>
                        <div class="modal-body">
                           

                            <h3 class="text-center">ACESSOS</h3>
                        


                             <div style="width: 100%;">
                                <div class="input-group" style="width: 150px;left: -125px; margin-left: 50%">
                                    <input type="date" class="form-control" id="data" value="<?php echo date('Y-m-d')?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="buscar" type="button">Buscar</button>
                                    </span>
                                </div>
                            </div>



                            
                        </div>
                        <div class="modal-footer">
                            
                            <div id="dados"></div>
                            
                        </div>
                    </div>
   
                    
                </div>
                
            </div>

            
        </div>
        


        </div>




        </div>
     <footer></footer>    

     <script type="text/javascript">


          window.onload = function(){
               document.getElementById("buscar").click();
            }


            function buscar(data){
                var page = "php_master/acessos_busca.php";
                $.ajax
                        ({
                            type: 'POST',
                            dataType: 'html',
                            url: page,
                            beforeSend: function () {
                                $("#dados").html("Carregando...");
                            },
                            data: {data: data},
                            success: function (msg)
                            {
                                $("#dados").html(msg);
                            }
                        });
            }
            
          $('#buscar').click(function () {
                buscar($("#data").val())
            });  
     </script>

    </body>
</html>

