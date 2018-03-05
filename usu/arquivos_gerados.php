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

    $idcaixa = $_SESSION['idcaixa'];
    $nomecx = $_SESSION['nome_caixa'];
    $estabelecimento = $_SESSION['estabelecimento'];

    $nomecx = str_replace(" ", "_", $nomecx);
    $estabelecimento = str_replace(" ", "_", $estabelecimento);
        
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
            
            <a href="contas_recebidas.php"><div class="barra text-center espaco"><label class="txt-barra">CONTAS</label></div></a>
            
            <a href="arquivos_gerados.php"><div class="barra text-center espaco active"><label class="txt-barra">ARQUIVOS</label></div></a>
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
            <div class="row" style="margin-top: 50px">

                <div class="col-md-2 col-lg-2"></div>

                <div class="col-md-8  col-lg-8">

                <div class="modal-content">
                        <div class="modal-header">

                            <h1 class="text-center">ARQUIVOS</h1>
                            <h4 class="text-center" style="opacity: 0.2;"><?=$_SESSION['nome_caixa']?> - <?=$_SESSION['estabelecimento']?></h4>
                        
                        </div>
                        <div class="modal-body">
                            

<!-- windows -->


<!--                             <?php

                            // Pasta onde estão as fotos
                            $pasta = "C:\\xampp\\htdocs\\saae\\sistema\\saae\\".$_SESSION['usu']."\\";

                            // Pegar todas as fotos (a função glob diferencia letras maiúsculas de minúsculas)
                            $fotos = glob($pasta . "{*.txt}", GLOB_BRACE);
                            // Note que as fotos devem estar com uma das extensões acima. Você pode adicionar mais, se quiser

                            // Pegar o data da modificação de cada foto
                            $datas_mod = array();
                            foreach ($fotos as $i => $foto) {
                              $datas_mod[$i] = filemtime($foto);
                            }

                            // Ordenar o array das datas
                            arsort($datas_mod);
                            // Usando arsort porque essa função preserva as chaves associativas e ordenar reversamente, do maior p/ o menor

                            // Pegamos a chave do primeiro elemento do array, ou seja, da data-hora mais recente
                            $uf = key($datas_mod);

                            // Por fim, o nome do arquivo da foto mais recente
                            $ultima_foto = $fotos[$uf];



                            //retira o diretorio atrelado ao nome do arquivo
                            $ultima_foto = str_replace($pasta, "", $ultima_foto);

              
                            ?> -->
<!--                             <center>

                            <h4 style="color: red"><?php if ($ultima_foto == 1) echo "Nenhum arquivo gerado."; ?></h4>

                            <a <?php if($ultima_foto == '..' or $ultima_foto == '.' or $ultima_foto == 1)echo 'style=" display: none;"' ?> class="btn btn-primary btn-md btn-lg" href='../php/baixar_txt.php?path=<?php echo $pasta; ?>&nome=<?php echo $ultima_foto; ?>'>
                            <span class="glyphicon glyphicon-download-alt"></span>      
                            &nbsp;&nbsp;&nbsp;<?php echo $ultima_foto; ?>&nbsp;&nbsp;&nbsp;                  
                            <span class="glyphicon glyphicon-download-alt"></span>
                            </a>
                            <br> -->

                            <!-- mostrando todos os arquivos -->

<!--                             <?php

                            /* Diretorio que deve ser lido */

                            $dir = "C:\\xampp\\htdocs\\saae\\sistema\\saae\\".$_SESSION['usu']."\\";

                            /* Abre o diretório */

                            $pasta= opendir($dir);

                            /* Loop para ler os arquivos do diretorio */

                            while ($arquivo = readdir($pasta)){

                            /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */

                            if ($arquivo != "." && $arquivo != ".."){ ?>
                            
                            <br>

                            <a <?php if($arquivo == '..' or $arquivo == '.' or $arquivo == $ultima_foto)echo 'style=" display: none;"' ?> class="btn btn-default btn-md btn-lg" href='../php/baixar_txt.php?path=<?php echo $dir; ?>&nome=<?php echo $arquivo; ?>'>
                            <span class="glyphicon glyphicon-download-alt"></span>      
                            &nbsp;&nbsp;&nbsp;<?php echo $arquivo; ?>&nbsp;&nbsp;&nbsp;                  
                            <span class="glyphicon glyphicon-download-alt"></span>
                            </a>


                            <?php } } ?>        --> 







<!-- linux -->





                            <?php

                            if (!file_exists("../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/")){
                                echo "<h4 class=\"text-center\" style=\"color: red\">Não foram encotrados registros.</h4>";exit;
                            }

                            // Pasta onde estão os arquivos
                            $pasta = "../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/";

                            // Pegar todas as fotos (a função glob diferencia letras maiúsculas de minúsculas)
                            $fotos = glob($pasta . "/{*.txt}", GLOB_BRACE);
                            // Note que as fotos devem estar com uma das extensões acima. Você pode adicionar mais, se quiser

                            // Pegar o data da modificação de cada foto
                            $datas_mod = array();
                            foreach ($fotos as $i => $foto) {
                              $datas_mod[$i] = filemtime($foto);
                            }

                            // Ordenar o array das datas
                            arsort($datas_mod);
                            // Usando arsort porque essa função preserva as chaves associativas e ordenar reversamente, do maior p/ o menor

                            // Pegamos a chave do primeiro elemento do array, ou seja, da data-hora mais recente
                            $uf = key($datas_mod);

                            // Por fim, o nome do arquivo da foto mais recente
                            $ultima_foto = $fotos[$uf];

                            // $str = "saae/".$_SESSION['usu']."/";
                            $ultima_foto = str_replace($pasta."/", "", $ultima_foto);

                            // Exibir...
                            // header('Content-Type: image/jpeg');
                            // echo file_get_contents($ultima_foto);
                            // echo $ultima_foto;

                            ?>

                            <a <?php if($ultima_foto == '..' or $ultima_foto == '.')echo 'style=" display: none;"' ?> class="btn btn-primary btn-block btn-lg menos_xs" href='../php/baixar_txt.php?path=<?php echo $pasta; ?>&nome=<?php echo $ultima_foto; ?>'><?php echo $ultima_foto; ?></a>

                            <?php

                            /* Diretorio que deve ser lido */

                            $dir = "../arquivos_saae/".$estabelecimento."/".$idcaixa."_".$nomecx."/";

                            /* Abre o diretório */

                            $pasta= opendir($dir);

                            /* Loop para ler os arquivos do diretorio */

                            while ($arquivo = readdir($pasta)){

                            /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */

                            if ($arquivo != "." && $arquivo != ".."){ ?>
                            

                            <a <?php if($arquivo == '..' or $arquivo == '.')echo 'style=" display: none;"' ?> class="btn btn-default btn-block btn-lg menos_xs" href='../php/baixar_txt.php?path=<?php echo $dir; ?>&nome=<?php echo $arquivo; ?>'><?php echo $arquivo; ?></a>


                            <?php } } ?>







                            </center>


                        </div>




                </div>

                <div class="col-md-2 col-lg-2">
                    
                </div>
            </div>

        </div>
        <footer></footer>
    </body>
</html>


