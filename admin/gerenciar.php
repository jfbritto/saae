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
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="../img/drop.png">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/sweetalert.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../bootstrap/css/estilo.css" />
        
        <script src="../bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/sweetalert.min.js"></script>


    </head>
    <body>

        <?php include('nav_adm.php') ?>




        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-0 col-lg-0"></div>

                <div class="col-md-12  col-lg-12">

                <div class="modal-content">
                        <div class="modal-header">

                            <h1 class="text-center">CONTAS</h1>
                        
                        </div>
                        <div class="modal-body">
                            


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
            <div class="col-md-0 col-lg-0"></div>
        </div>
        
        <script>
            window.onload = function(){
               document.getElementById("buscar").click();
            }


            function buscar(data){
                var page = "../ajax/buscar_boletos_adm.php";
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

            window.onload = function(){
                    let url = window.location;
                    let u = new URL(url);
                    let valor = u.searchParams.get('deletada');
                    if(valor == 'true')
                      swal('Conta deletada com sucesso!', '', 'success');
                      document.getElementById("buscar").click();

                    let valor1 = u.searchParams.get('deletada');
                    if(valor1 == 'false')
                      swal('Conta não deletada!', '', 'error');
                      document.getElementById("buscar").click();  

                    let valor2 = u.searchParams.get('senha_alterada');
                    if(valor2 == 'true')
                      swal('Senha alterada com sucesso!', '', 'success');
                      
                    let valor3 = u.searchParams.get('senha_alterada');
                    if(valor3 == 'false')
                      swal('Senha não alterada!', 'Dados informados incorretamente', 'error');


                    let valor4 = u.searchParams.get('adicionada');
                    if(valor4 == 'true')
                      swal('Logo alterada com sucesso!', '', 'success');
                      
                    let valor5 = u.searchParams.get('adicionada');
                    if(valor5 == 'false')
                      swal('Logo não alterada!', 'Arquivo não é uma imagem ou seu tamanho é maior que o permitido!', 'error');
                       
              }    

            function confirmacao(id){

                swal({
                  title: "Tem certeza?",
                  // text: "Your will not be able to recover this imaginary file!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Sim, deletar!",
                  closeOnConfirm: false
                },
                function(){
                  window.location.href='php_adm/deletar_conta.php?id=' +id+'';
                });

            }              


            
        </script>

        </div>
        <footer></footer>
    </body>
</html>

