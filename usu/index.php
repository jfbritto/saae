<?php 
    session_start();         
    if (!isset($_SESSION['idusuario']) && !isset($_SESSION['usu'])) {
        if (isset($_COOKIE["idusuario"])) {
        header('location: home.php?salvopelocookie=true');exit;}
        header('location: ../index.php?naologado=true');
        exit;
    }

    if (!isset($_SESSION['idcaixa']) && $_SESSION['idcaixa'] == "") {
        header('location: home.php');
    }

        


    $_SESSION['cod'] = 0;
    $_SESSION['verif'] = " ";
    
   
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
            <a href="index.php"><div class="barra text-center espaco active "><label class="txt-barra">RECEBER</label></div></a>
            
            <a href="contas_recebidas.php"><div class="barra text-center espaco"><label class="txt-barra">CONTAS</label></div></a>
            
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



        <div class="container">
            <div class="row" style="margin-top: 80px">

                <div class="col-md-2 col-lg-2"></div>

                <div class="col-md-8  col-lg-8">
                
                    <div class="modal-content">
                        <div class="modal-header">
                        
                            <h1 class="text-center">RECEBER</h1>
                            <h4 class="text-center" style="opacity: 0.2;"><?=$_SESSION['nome_caixa']?> - <?=$_SESSION['estabelecimento']?></h4>

                        </div>
                        <div class="modal-body">
                        



                            <!-- INPUT PARA INSERIR O CÓDIGO DE BARRAS  -->
                            <form method="POST" name="formcod" action="index.php"> 
                                <div class="input-group">
                                    <input onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;" required type="text" class="form-control jf-input-cod" id="codigo" name="codigo" minlength="44" maxlength="48" placeholder="Código de barras..." <?php if(!isset($_POST['codigo'])){echo "autofocus";} ?>>
                                    <span class="input-group-btn">
                                        <input style="height: 40px" class="btn btn-default" id="buscar" type="submit" value="Ler">
                                    </span>
                                </div>
                            </form>
                            

                            <h3 class="text-center" id="resultado"><?php echo $_SESSION['verif'];?></h3>

                            
                            <!-- QUEBRAS DOS NUMEROS PARAS OS CÁLCULOS -->
                            <?php  

                                if (isset($_POST['codigo'])) {
                             
                                        $codigo = $_POST['codigo'];
                                        $tamanho = strlen($codigo);

                                    // com o digito verificador
                                        if ($tamanho == 48 or $tamanho > 44) {

                                        $valor1 = substr($codigo, 4, -37);

                                        $valor2 = substr($codigo, 12, -34);

                                        $centavos = substr($codigo, 14, -32);

                                        $data = substr($codigo, 27, -13);

                                        $final = intval($valor1.$valor2);

                                        $final = $final.','.$centavos;
                                    }

                                    // sem digito verificador
                                        elseif ($tamanho == 44) {

                                        $codigo = $_POST['codigo'];

                                        $valor1 = substr($codigo, 4, -31);

                                        $centavos = substr($codigo, 13, -29);
                   
                                        $data = substr($codigo, 25, -11);

                                        $final = intval($valor1);

                                        $final = $final.','.$centavos;
                                    }

                                }
                            ?>


                            
                            <?php if(isset($_GET['recebida'])): ?>
                                <div id="trocoRetorno">
                                    <h3 class="text-center" style="color: green">CONTA RECEBIDA COM SUCESSO!</h3>
                                    <h3 class="text-center" style="color: green"><?php if(!empty($_SESSION['troco'])){echo '<font style="color:black">TROCO:</font> '; echo $_SESSION['troco'];}  ?></h3>
                                </div>
                            <?php endif ?>

                            <!-- SÓ ENTRA NO CÓDIGO PHP SE O POST FOR PASSADO -->
                            <?php if(isset($_POST['codigo'])): ?>

                            <!-- EXIBE O VALOR A SER PAGO     -->
                            <label>VALOR:</label>  
                            <input type="text" class="form-control text-center jf-input green" value="<?php if(isset($_POST['codigo'])){ echo "R$ ".$final;} ?>" readonly>
                            <!-- INPUT PARA SER USADO NO CALCULO     -->
                            <input type="hidden" value="<?php if(isset($_POST['codigo'])){ echo $final;} ?>" id="val1" name="codigo">

                            <br>

                            <!-- RECEBE O VALOR EM DINHEIRO ENTREGUE AO CAIXA    -->
                            <label>DINHEIRO:</label> 
                                <input onkeyup="moeda(this);" onkeyup="sub()" type="text" class="form-control text-center jf-input green" id="val2" name="dinheiro" <?php if(isset($_POST['codigo'])){echo "autofocus";} ?>>

                            <br>

                            <form method="POST" id="receber" action="../php/cadastrar_codigo.php">
                            <!-- RETORNA O VALOR DO TROCO A SER DEVOLVIDO     -->
                                <label>TROCO:</label>
                                <input readonly class="form-control text-center jf-input green" id="result" type="text" name="troco">
                                





                        </div>
                        <div class="modal-footer">
                            





                            <div style="width: 100%">
                                <div style="display: inline-block; float: left;">
                                <!-- CANCELA A OPERAÇÃO     -->
                                    <a class="btn btn-danger btn-lg jf-btn text-left" id="cancelar" href="index.php">CANCELAR</a>
                                </div>
                                <div style="display: inline-block; float: right;">    
                                    <!-- RECEBE A CONTA     -->
                                
                                    <input type="hidden" name="codigo" value="<?php echo $codigo;?>">
                                    <input type="hidden" name="valor" value="<?php echo $final;?>">
                                
                                    <button class="btn btn-success btn-lg jf-btn">RECEBER</button>
                            </form>
                            </div>    
                            </div>

                             <?php endif ?>







                        </div>
                    </div>
                
                </div>

                <div class="col-md-2 col-lg-2"></div>

            </div>

        </div>
            
            <script type="text/javascript">
               
                function moeda(z){
                    //faz a conta para retornar troco
                    var val1 = document.getElementById('val1').value;
                    var val2 = document.getElementById('val2').value;
                    val1 = parseFloat(val1.replace(',', '.'));
                    val2 = parseFloat(val2.replace(',', '.'));
                    document.getElementById('result').value = numeral(val2 - val1).format('$0,0.00');
                    }


                //verifica se o codigo já esta cadastrado no banco    
                $("input[name='codigo']").on('keyup', function(){  
                  var codigo = $(this).val();
                  $.get('../ajax/verificar_codigo.php?codigo=' + codigo, function(data){
                    $('#resultado').html(data.retorno);
                    // var retorno = data.retorno;
                    if (data.retorno == '1') {
                        document.getElementById('buscar').setAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "CÓDIGO INVÁLIDO";
                        document.getElementById("resultado").style.color = "red";
                    }
                    if (data.retorno == '2') {
                        document.getElementById('buscar').removeAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "CÓDIGO VÁLIDO";
                        document.getElementById("resultado").style.color = "green";
                    }
                    if (data.retorno == '3') {
                        document.getElementById('buscar').setAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "CONTA JÁ RECEBIDA";
                        document.getElementById("resultado").style.color = "red";
                    }
                    if (data.retorno == '4') {
                        document.getElementById('buscar').setAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "";
                    }
                    if (data.retorno == '5') {
                        document.getElementById('buscar').removeAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "";
                    }
                    if (data.retorno == '6') {
                        document.getElementById('buscar').setAttribute('disabled', 'true');
                        var buscar = document.getElementById('buscar');
                        document.getElementById("resultado").innerHTML = "CÓDIGO INCOMPLETO";
                        document.getElementById("resultado").style.color = "blue";
                    }

                    
                  },"json");
                });


                var result = document.getElementById('resultado');
                if (result = 'CÓDIGO INVÁLIDO') {
                    document.getElementById("resultado").style.color = "red";
                }
                if (result = 'CONTA JÁ RECEBIDA') {
                    document.getElementById("resultado").style.color = "red";
                }

                
                //se o cursor estiver no campo dinheiro e o enter for clicado, o sistema cadastra a conta
                $('#val2').keydown(function(e){
                    if(e.which == 13)
                        $('#receber').submit();
                });


                $('#codigo').keydown(function(e){
                    if(e.which == 32)
                        document.getElementById('codigo').value='';//se a tecla de espaço for pressionada o campo codigo é apagado
                });

                $('#codigo').keydown(function(e){
                    document.getElementById('trocoRetorno').style.display = "none";//se o campo codigo sofrer clique, o campo trocoRetorno fica invisivel
                });


                //quando a pagina carregar e o retorno get for "recebida", é gereda a tela de impressao
                window.onload = function(){
                    let url = window.location;
                    let u = new URL(url);
                    let valor = u.searchParams.get('recebida');
                    if(valor == 'false')
                      swal('Erro', 'Conta já recebida!', 'error');

                    let valor1 = u.searchParams.get('invalida');
                    if(valor1 == 'true')
                      swal('Erro', 'Código inválido', 'error');

                    let valor2 = u.searchParams.get('senha_alterada');
                    if(valor2 == 'true')
                      swal('Senha alterada!', '', 'success');

                    let valor3 = u.searchParams.get('senha_alterada');
                    if(valor3 == 'false')
                      swal('Senha não pode ser alterada!', '', 'error');

                    let valor4 = u.searchParams.get('recebida');
                    if(valor4 == 'true')
                      window.open('../php/gerar_recibo.php?cod=<?php echo $_SESSION['cod'];?>','galeria','width=680,height=470,top=150,left=100');
                      return false;
                }
                document.getElementById("codigo").focus();

                  
            </script>
    <footer></footer>        
    </body>
</html>


