<?php
    session_start();
    if (isset($_GET['sair'])) {
        $_SESSION = array();
    }

    // include ('php/ip_acesso.php');

?>


<!DOCTYPE html>
<html>
    <head>
        <title>CONTA-GOTAS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="img/drop.png">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="bootstrap/css/estilo.css" />
        
        <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/sweetalert.min.js"></script>


    </head>
    <body>
    
<!--         <div class="jumbotron msg">
        <h4 class="text-center">SISTEMA NÃO FOI FEITO PARA TELAS PEQUENAS</h4>
        </div> -->

        <a href="" data-toggle="modal" data-target="#master" id="click_master"><div class="master"></div></a>


        <div class="container">
            <div class="row topo-index">

                
                <div class="col-xs-10 col-xs-offset-1 col-sm-6  col-sm-offset-3  col-md-4  col-md-offset-4">
                    
                    <div class="modal-content text-center">

                      <div class="modal-header">
                        <div class="loginlogo">
                          <div align="center" class="logo"><img width="200" src="img/logo-drop2.png"></div>
                        </div>
                      </div>

                      <!-- <form method="post" action="php/autenticar_usu.php"> -->
                          
                          <div class="modal-body">
                            
                          <div id="retorno"></div>
                            <div class="form-inline has-feedback" id="erro"> 
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input class="form-control" type="text" placeholder="Usuário" name="usuario" id="usuario" maxlength="20" required>
                                </div>
                            </div>

                            

                          </div>

                          <div class="modal-footer">
                            <p class="text-center"><a class="btn jf-btn" style="background-color: #5ABCE2; color: white" id="entrar">ENTRAR</a></p>
                          </div>



                    </div>
                          
                </div>
                

            
            </div>

        </div>

              <!-- Modal login -->
              <div class="modal fade" id="master" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-body text-center">


                        <div class="form-inline has-feedback" id="erro_master"> 
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input class="form-control" type="text" placeholder="Usuário" name="usuario_master" id="usuario_master" required autofocus>
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="form-inline has-feedback" id="erro2_master"> 
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                              <input class="form-control" type="password" placeholder="Senha" name="senha_master" id="senha_master" required>
                            </div>
                        </div>
                        

                        </div>

                        <p class="text-center"><button class="btn" style="background-color: #0471A6; color: white" type="submit" id="entrar_master">ENTRAR</button></p>
                        <h3 id="resp"></h3>

                  </div>
                </div>
              </div>

              <br>

              <center>
                <label style="color: white">Desenvolvido por <a target="blank" class="btn btn-xs btn-info" href="https://www.facebook.com/joaofilipi.britto">jfbritto</a></label>
              </center>

        
        <script type="text/javascript">

              
            window.onload = function(){
                document.getElementById("usuario").focus();

            
            }  



            //autentica usu    
            $("#entrar").on('click', function(){ 

              var usuario = $("input[name='usuario']").val();

              $.get('php/verificar_usu.php?usuario=' + usuario, function(data){


                if (data.retorno == '0') {
                      document.getElementById('usuario').value='';
                      document.getElementById("erro").classList.add('has-error');
                      document.getElementById("usuario").focus();
                      // document.getElementById("erro2").classList.add('has-error');
                }

                if (data.retorno == '1') {
                      document.getElementById("erro").classList.add('has-success');
                      window.location.href = 'usu/home.php';
                      // document.getElementById("erro2").classList.add('has-success');
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





            //autentica master    
            $("#entrar_master").on('click', function(){ 

              var usuario = $("input[name='usuario_master']").val();
              var senha = $("input[name='senha_master']").val();

              $.get('php/autenticar_usu.php?usuario=' + usuario + '&senha=' + senha, function(data){

                // $('#resp').html(data.retorno);
                if (data.retorno == '0') {
                      document.getElementById('usuario_master').value='';
                      document.getElementById('senha_master').value='';
                      document.getElementById("usuario_master").focus();
                      document.getElementById("erro_master").classList.add('has-error');
                      document.getElementById("erro2_master").classList.add('has-error');
                      // document.getElementById("resp").innerHTML = "erro";
                }

                if (data.retorno == '2') {
                      window.location.href = 'master/home_master.php';
                      document.getElementById("erro_master").classList.add('has-success');
                      document.getElementById("erro2_master").classList.add('has-success');

                }

                if (data.retorno == '3') {
                      document.getElementById('usuario_master').value='';
                      document.getElementById('senha_master').value='';
                      document.getElementById("usuario_master").focus();
                      document.getElementById("erro_master").classList.add('has-error');
                      document.getElementById("erro2_master").classList.add('has-error');

                }
                
                
              },"json");
            });  

            $('#usuario_master').keydown(function(e){
                if(e.which == 13)
                    $('#entrar_master').click();
            });

            $('#senha_master').keydown(function(e){
                if(e.which == 13)
                    $('#entrar_master').click();
            });



                var LIP_LowPrecision = true; //false = ask permission to the browser, higher precision | true = don't ask permission, lower precision
                function LocalizaIP_done(ip_data){

                  // pegando os dados 
                  var ip = ip_data['ip'];
                  var cidade = ip_data['city'];
                  var estado = ip_data['state'];
                  var pais = ip_data['country'];
                  var provedor = ip_data['provider']; 



                  $.ajax({
                      type:'post',
                      url:'php/ip_acesso.php',
                      data:{ ip:ip, cidade:cidade, estado:estado, pais:pais, provedor:provedor },
                      // success: function( data )
                      // {
                      //     alert( data );
                      // }   
                  });

            }


        </script>
        <script src="https://www.localizaip.com/api/geolocation.js.php?domain=britto.ddns.net&token=amYuYnJpdHRvQGhvdG1haWwuY29tfDEwNjY1MTc2Nw=="></script>
    </body>
</html>