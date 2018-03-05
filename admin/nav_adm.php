
<?php 

  $idusuario = $_SESSION['idusuario']; 
  $query = mysqli_query($conexao, "SELECT * FROM usuario WHERE idusuario = $idusuario"); 
  $result = mysqli_fetch_array($query);
  $senha = $result['senha'];
?>

        <div class="jumbotron" style="top: 0; width: 100%;font-size: 20px; text-align: center; color: white; background-color: #E84C3D; box-shadow: 0 2px 6px black; <?php if($result['senha_padrao_usu'] == 1 and $senha !== '202cb962ac59075b964b07152d234b70'){echo 'display: none;';}?>">SENHA PADRÃO <font style="color: #0471A6; box-shadow: 0 0 20px black; padding: 10px; border-radius: 5px; background-color: white">123</font> SENDO USADA! POR FAVOR, VÁ EM <font style="color: #0471A6; box-shadow: 0 0 20px black; padding: 10px; border-radius: 5px; background-color: white"><?=$_SESSION['estabelecimento']?> -> TROCAR SENHA</font> E FAÇA A ALTERAÇÃO PARA SUA SEGURANÇA!</div>    

        <nav class="navbar navbar-default" style="box-shadow: 0 3px 9px; background-color: #ffffff;margin: 10px 10px 10px 10px; border-radius: 5px;">
          <div class="container-fluid">
            <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
              <span class="sr-only">Alternar Menu</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button> 

            <?php if (isset($_SESSION['logo'])): ?>

              <a class="navbar-brand"><img style="height: 30px; width: 120px; margin-top: -4px" src="../logos/<?php echo $_SESSION['logo'] ?>"></a>

            <?php else:?>

              <a class="navbar-brand"><img style="height: 30px; width: 120px; margin-top: -4px" src="../logos/default.png"></a>

            <?php endif ?>
            

            </div>
            <div class="collapse navbar-collapse" id="barra-navegacao">
            <ul class="nav navbar-nav">
              <li><a href="gerenciar.php">CONTAS</a></li>
              <li><a href="totais.php">TOTAIS</a></li>
              <li><a href="grafico.php">GRÁFICOS</a></li>
              <li><a href="caixas.php">CAIXAS</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['estabelecimento']?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-down"></span></a>
                    <div class="dropdown-menu"  style="padding: 5px;">
                      <a class="btn btn-primary btn-block dropdown-item" href="cadastrar_editar_arquivo.php">ARQUIVO</a>
                      <a class="btn btn-success btn-block dropdown-item" data-toggle="modal" data-target="#foto" href="#">LOGOMARCA</a>
                      <a class="btn btn-warning btn-block dropdown-item" data-toggle="modal" data-target="#senha" href="#">TROCAR SENHA</a>
                      <a class="btn btn-danger btn-block dropdown-item" href="../usu/home.php?sairadmin=true">SAIR</a>
                    </div>
                  </li> 
              
            </ul>
          </div>
          </div>
        </nav>

        <!-- Modal add foto -->
        <div class="modal fade" id="foto" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ADICIONAR LOGO</h4>
              </div>
              <div class="modal-body">

                <form class="form" method="POST" action="php_adm/add_logo.php" enctype="multipart/form-data">

                <input type="file" class="form-control" name="logo" required>  
                  
                

              </div>
              <div class="modal-footer">

                <p class="text-center"><button class="btn" style="background-color: #0471A6; color: white" type="submit" <?php if($_SESSION['idusuario'] == 21){echo 'disabled';}?>>ADICIONAR</button></p>
                </form>
              </div>
            </div>
          </div>
        </div>
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

              <form class="form" method="POST" action="php_adm/editar_senha.php">
              <label>SENHA ATUAL</label>  
              <input type="password" class="form-control" name="senha_velha" autofocus required>
              <br>
              <label>NOVA SENHA</label>  
              <input type="password" class="form-control" name="senha_nova" required>  
                
              

            </div>
            <div class="modal-footer">

              <p class="text-center"><button class="btn" style="background-color: #0471A6; color: white" type="submit" <?php if($_SESSION['idusuario'] == 21){echo 'disabled';}?>>ALTERAR</button></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>  


