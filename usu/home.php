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

    if (isset($_GET['saircx']) or isset($_GET['sairadmin'])) {
        unset($_SESSION['idcaixa']);
        unset($_SESSION['nome_caixa']);
        unset($_SESSION['login_caixa']);
        unset($_SESSION['idusuarioadmin']);
    }

    $logo = $_SESSION['logo'];
    $estabelecimento = $_SESSION['estabelecimento'];
    $login = $_SESSION['login'];
    $idusuario = $_SESSION['idusuario'];
    setcookie("logo", $logo, time()+172800); 
    setcookie("estabelecimento", $estabelecimento, time()+172800); 
    setcookie("login", $login, time()+172800); 
    setcookie("idusuario", $idusuario, time()+172800); 
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

<!--         <div class="jumbotron msg">
        <h4 class="text-center">SISTEMA NÃO FOI FEITO PARA TELAS PEQUENAS</h4>
        </div> -->

        <div class="fixa-sair">
          <a href="#" data-toggle="modal" data-target="#login"><div class="sair text-center espaco"><label class="">ADM</label></div></a>
          
          <a href="../index.php?sair=true"><div class="sair text-center espaco"><label class="">SAIR</label></div></a>
        </div>

        <div class="container">


            <div class="row topo-index">

                <div class="col-xs-10 col-xs-offset-1 col-sm-6  col-sm-offset-3  col-md-4  col-md-offset-4">

                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <center>
                          <?php if (isset($_SESSION['logo'])): ?>

                            <h1 class="text-center"><img class="img img-responsive" src="../logos/<?php echo $_SESSION['logo'] ?>"></h1>

                          <?php else:?>

                            <h1 class="text-center"><img class="img img-responsive" src="../logos/default.png"></h1>

                          <?php endif ?>
                          </center>

                        </div>
                        <div class="modal-footer text-center" style="margin-bottom: 5px; background: transparent;">
                            
                          <div class="col-xs-10 col-xs-offset-1" style=" box-shadow: 0 3px 9px; border-radius: 10px; z-index: 1">

                          <h2 class="text-center" style="color: #0471A6;">CAIXA</h2>
                          <br>
                                <div class="form-inline has-feedback" id="errocx"> 
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                      <input class="form-control" type="text" placeholder="Login" name="login_caixa" id="login_caixa" required>
                                    </div>
                                </div>
                                
                                <br>
                                
                                <div class="form-inline has-feedback" id="erro2cx"> 
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                      <input class="form-control" type="password" placeholder="Senha" name="senha_caixa" id="senha_caixa" required>
                                    </div>
                                </div>
                                <br>
                                <p class="text-center"><button class="btn" style="background-color:  #0471A6; color: white" type="submit" name="entrarcx" id="entrarcx">ENTRAR</button></p>

                          </div>

                        


                        </div>
                    </div>

              <!-- Modal login -->
              <div class="modal fade" id="login" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">LOGIN</h4>
                    </div>
                    <div class="modal-body text-center">



                        <div class="form-inline has-feedback" id="erro"> 
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input class="form-control" type="text" placeholder="Usuário" name="usuario" id="usuario" required autofocus>
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="form-inline has-feedback" id="erro2"> 
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                              <input class="form-control" type="password" placeholder="Senha" name="senha" id="senha" required>
                            </div>
                        </div>
                        

                        <!-- <span class="psw">Esqueceu a <a href="#">senha?</a></span> -->
                        
                    
                        </div>
                        <div class="modal-footer">

                        <p class="text-center"><button class="btn" style="background-color: #0471A6; color: white" type="submit" id="entrar">ENTRAR</button></p>

                    </div>
                  </div>
                </div>
              </div>
            </div>



        </div>
        <script type="text/javascript">
            window.onload = function(){
                document.getElementById('login_caixa').focus();

                let url = window.location;
                let u = new URL(url);
                let valor = u.searchParams.get('naologado');
                if(valor == 'true')
                  swal('Não logado', 'Usuário ou senha incorretos!', 'error');

                  // document.getElementById("erro").classList.add('has-error');
                  // document.getElementById("erro").classList.add('has-feedback');
                  // document.getElementById("erro2").classList.add('has-error');
                  // document.getElementById("erro2").classList.add('has-feedback');
              }  


            //autentica usu    
            $("#entrar").on('click', function(){ 

              var usuario = $("input[name='usuario']").val();
              var senha = $("input[name='senha']").val();

              $.get('../php/autenticar_usu.php?usuario=' + usuario + '&senha='+ senha, function(data){


                if (data.retorno == '0') {
                      document.getElementById('usuario').value='';
                      document.getElementById('senha').value='';
                      document.getElementById('usuario').focus();
                      document.getElementById("erro").classList.add('has-error');
                      document.getElementById("erro2").classList.add('has-error');
                }

                if (data.retorno == '1') {
                      document.getElementById("erro").classList.add('has-success');
                      document.getElementById("erro2").classList.add('has-success');
                      window.location.href = "../admin/gerenciar.php";
                }


                
                
              },"json");
            });   

            $('#usuario').keydown(function(e){
                if(e.which == 13)
                    $('#entrar').click();
            });

            $('#senha').keydown(function(e){
                if(e.which == 13)
                    $('#entrar').click();
            });









            $("#entrarcx").on('click', function(){ 

              var login_caixa = $("input[name='login_caixa']").val();
              var senha_caixa = $("input[name='senha_caixa']").val();

              $.get('../php/verificar_caixa.php?login_caixa=' + login_caixa + '&senha_caixa='+ senha_caixa, function(data){


                if (data.retorno == '0') {
                      document.getElementById('login_caixa').value='';
                      document.getElementById('senha_caixa').value='';
                      document.getElementById('login_caixa').focus();
                      document.getElementById("errocx").classList.add('has-error');
                      document.getElementById("erro2cx").classList.add('has-error');
                }

                if (data.retorno == '1') {
                      document.getElementById("errocx").classList.add('has-success');
                      document.getElementById("erro2cx").classList.add('has-success');
                      window.location.href = "index.php";
                }



                
                
              },"json");
            });   

            $('#login_caixa').keydown(function(e){
                if(e.which == 13)
                    $('#entrarcx').click();
            });

            $('#senha_caixa').keydown(function(e){
                if(e.which == 13)
                    $('#entrarcx').click();
            });








            // function pula(){

            //   if(document.getElementById('caixa').value.length==0){

            //   document.getElementById('senha_caixa').focus();

            // }}


            // function vercaixa(){

            //   if(document.getElementById('senha_caixa').value.length==3){

            //     var caixa = $("input[name='caixa']").val();
            //     var senha_caixa = $("input[name='senha_caixa']").val();

            //     $.get('../php/verificar_caixa.php?caixa=' + caixa + '&senha='+ senha_caixa, function(data){


            //       if (data.retorno == '0') {
            //             document.getElementById('caixa').value='';
            //             document.getElementById('senha_caixa').value='';
            //             document.getElementById('caixa').focus();
            //             document.getElementById("errocx").classList.add('has-error');
            //             document.getElementById("erro2cx").classList.add('has-error');
            //       }

            //       if (data.retorno == '1') {
            //             document.getElementById("errocx").classList.add('has-success');
            //             document.getElementById("erro2cx").classList.add('has-success');
            //             // window.location.href = "../admin/gerenciar.php";
            //       }


                  
                  
            //     },"json");

            // }}


        </script>
    </body>
</html>