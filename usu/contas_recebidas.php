<?php 
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        if (isset($_COOKIE["idusuario"])) {

        $_SESSION['logo'] = $_COOKIE["logo"];
        $_SESSION['estabelecimento'] = $_COOKIE["estabelecimento"];  
        $_SESSION['login'] = $_COOKIE["login"];          
        $_SESSION['idusuario'] = $_COOKIE["idusuario"];
        header('location: home.php?salvopelocookie=true');
        exit;
      }
        header('location: ../index.php?naologado=true');
        exit;
    }

        $_SESSION['dataBol'] = 0;
    
      // echo $_COOKIE["estabelecimento"];      

  include('../php/config.php');  
  $idusuario = $_SESSION['idusuario']; 
  $idcaixa = $_SESSION['idcaixa']; 
  $query = mysqli_query($conexao, "SELECT * FROM caixa WHERE fkusuario = $idusuario and idcaixa = $idcaixa"); 
  $result = mysqli_fetch_array($query);
  $senha = $result['senha_caixa'];
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

        <div class="jumbotron" style="top: 0; width: 100%;font-size: 20px; text-align: center; color: white; background-color: #E84C3D; box-shadow: 0 2px 6px black; <?php if($result['senha_padrao_cx'] == 1 and $senha !== '202cb962ac59075b964b07152d234b70'){echo 'display: none;';}?>">SENHA PADRÃO <font style="color: #0471A6; box-shadow: 0 0 20px black; padding: 10px; border-radius: 5px; background-color: white">123</font> SENDO USADA! POR FAVOR, VÁ EM <font style="color: #0471A6; box-shadow: 0 0 20px black; padding: 10px; border-radius: 5px; background-color: white">SENHA</font> E FAÇA A ALTERAÇÃO PARA SUA SEGURANÇA!</div>    

<!--         <div class="jumbotron msg">
        <h4 class="text-center">SISTEMA NÃO FOI FEITO PARA TELAS PEQUENAS</h4>
        </div> -->
        
        <div class="fixa">
            <a href="index.php"><div class="barra text-center espaco"><label class="txt-barra">RECEBER</label></div></a>
            
            <a href="contas_recebidas.php"><div class="barra text-center espaco active"><label class="txt-barra">CONTAS</label></div></a>
            
            <a href="arquivos_gerados.php"><div class="barra text-center espaco"><label class="txt-barra">ARQUIVOS</label></div></a>
        </div>

        <div class="fixa-sair">
            <a href="#" data-toggle="modal" data-target="#senha"><div class="sair text-center espaco"><label class="">SENHA</label></div></a>
            
            <a href="home.php?saircx=true"><div class="sair text-center espaco"><label class="">SAIR</label></div></a>
        </div>

              <!-- Modal troca senha -->
          <div class="modal fade" id="senha" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">TROCAR SENHA</h4>
                </div>
                <div class="modal-body">

                  <form class="form" method="POST" action="../php/editar_senha_caixa.php">
                  <label>SENHA ATUAL</label>  
                  <input type="password" class="form-control" name="senha_velha" autofocus required>
                  <br>
                  <label>NOVA SENHA</label>  
                  <input type="password" class="form-control" name="senha_nova" required>  
                    
                  

                </div>
                <div class="modal-footer">

                  <p class="text-center"><button class="btn btn-info" type="submit" <?php if($_SESSION['idusuario'] == 21){echo 'disabled';}?>>ALTERAR</button></p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div> 


        <div class="container-fluid">
            
            <div class="row" style="margin-top: 50px">
                <div class="col-md-1 col-lg-1"></div>

                <div class="col-md-10  col-lg-10">


                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h1 class="text-center">CONTAS</h1>
                            <h4 class="text-center" style="opacity: 0.2;"><?=$_SESSION['nome_caixa']?> - <?=$_SESSION['estabelecimento']?></h4>
                            
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

            <div class="col-md-1 col-lg-1"></div>
        </div>
        
        <script>
            window.onload = function(){
               document.getElementById("buscar").click();
            }


            function buscar(data){
                var page = "../ajax/buscar_boletos.php";
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

            function confirmacao(id){

                swal({
                  title: "Tem certeza?",
                  // text: "Your will not be able to recover this imaginary file!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "Sim, gerar!",
                  closeOnConfirm: false
                },
                function(){
                  window.location.href='../php/gerar_txt.php';
                });

                }

            window.onload = function(){
                    let url = window.location;
                    let u = new URL(url);
                    let valor = u.searchParams.get('txt');
                    if(valor == 'true')
                      swal('Arquivo gerado com sucesso!', '', 'success');
                      document.getElementById("buscar").click();

                    let valor1 = u.searchParams.get('txt');
                    if(valor1 == 'false')
                      swal('Arquivo não gerado!', 'Verifique com o administrador se o cabeçalho do arquivo foi cadastrado', 'error');
              }    
        </script>

        </div>
     <footer></footer>    
    </body>
</html>

