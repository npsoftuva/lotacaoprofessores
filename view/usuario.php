<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
  require_once('../controller/UsuarioController.php');

  $usuarioController = new UsuarioController();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Usuário</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
  </head>
  <body>
    <div class="wrapper">
      <?php include ("sidebar.inc"); ?>

      <div class="main-panel">
        <?php include("navbar.inc"); ?>

        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
                  <?php
                    if (isset($_POST["Adicionar"])) {
                      $usuario = new Usuario();
                      $usuario->__set("usu_log", $_POST["usu_log"]);
                      $usuario->__set("usu_sen", $_POST["usu_sen"]);
                      $usuario->__set("usu_tpo", $_POST["usu_tpo"]);
                      if ($usuarioController->register($usuario)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Usuário adicionado com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar adicionar o usuário.</span>
                      </div>
                    <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                      $return = $usuarioController->remove($_POST["usu_codx"]);
                      if ($return === 1) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Usuário excluído com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message"><?php echo $return; ?></span>
                      </div>
                    <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                      $usuario = new Usuario();
                      $usuario->__set("usu_cod", $_POST["usu_cod"]);
                      $usuario->__set("usu_log", $_POST["usu_log"]);
                      $usuario->__set("usu_tpo", $_POST["usu_tpo"]);
											$return = $usuarioController->update($usuario);
                      if ($return === 1) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Usuário editado com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message"><?php echo $return; ?></span>
                      </div>
                    <?php }
                    } else
                    if (isset($_POST["NewPass"])) {
                      $usuario = new Usuario();
                      $usuario->__set("usu_cod", $_POST["usu_codp"]);
                      $usuario->__set("usu_sen", $_POST["usu_senp"]);
                      if ($usuarioController->newPassword($usuario)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Senha alterada com sucesso!</span>
                      </div>  
                      <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-user"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar editar a senha do usuário.</span>
                      </div>
                      <?php }
                    }

                    $usuarios = $usuarioController->searchAll();
                  ?>

                  <div class="header">
                    <h4 class="title">Usuários</h4>
                    <p class="category">
                      Lista de usuários do sistema
                      <span class="pull-right">
                        <button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#add">
                          Adicionar
                        </button>
                      </span>
                    </p>
                  </div>
                  <div class="content table-responsive table-full-width">
                    <table class="table table-striped table-hover" id="dataTables-example">
                      <thead>
                        <th class="col-xs-5 col-sm-5 col-md-5 col-lg-5">Login</th>
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Nível</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Ações</th>
                      </thead>
                      <tbody>
<?php if ($usuarios) foreach ($usuarios as $usuario) { ?>
                        <tr>
                          <td><?php echo $usuario->__get("usu_log"); ?></td>
                          <td><?php echo $usuario->__get("usu_tpo") ? "Secretário(a)" : "Coordenador(a)"; ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $usuario->__get("usu_cod"); ?>" title="Nova senha" class="openNewPass btn btn-info" href="#new-pass"><span class="pe-7s-lock" aria-hidden="true"></span> </a>
                            <a data-toggle="modal" data-cod="<?php echo $usuario->__get("usu_cod"); ?>" data-log="<?php echo $usuario->__get("usu_log"); ?>" data-tpo="<?php echo $usuario->__get("usu_tpo"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>
                            <a data-toggle="modal" data-cod="<?php echo $usuario->__get("usu_cod"); ?>" data-log="<?php echo $usuario->__get("usu_log"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
                          </td>
                        </tr>
<?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include("footer.inc"); ?>
      </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="pe-7s-user"></span> Excluir Usuário</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="usu_codx" id="usu_codx" value="">
              <p>Você deseja excluir o usuário <b id="usu_logx"></b>?</p>
              <input type="button" class="btn btn-danger btn-fill" data-dismiss="modal" value="Não">
              <input type="submit" class="btn btn-success btn-fill" value="Sim" name="Excluir">
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="edit"><span class="pe-7s-user"></span> Editar Usuário</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <input type="hidden" name="usu_cod" id="usu_cod" value="">
								<div class="form-group">
                  <label>Login</label>
                  <input class="form-control" type="text" name="usu_log" id="usu_log" value="" maxlength="25" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Nível *</label>
                  <select class="form-control" name="usu_tpo" id="usu_tpo">
                    <option value="0">Coordenador(a)</option>
                    <option value="1">Secretário(a)</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
            <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="add"><span class="pe-7s-user"></span> Adicionar Usuário</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Login *</label>
                <input class="form-control" placeholder="Login do Usuário" name="usu_log" required maxlength="25" autocomplete="off">
              </div>
              <div class="form-group">
                <label>Senha *</label>
                <input class="form-control" placeholder="Senha do Usuário" name="usu_sen" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nível *</label>
                <select class="form-control" required name="usu_tpo">
                  <option value="">Selecione uma opção</option>
                  <option value="0">Coordenador(a)</option>
                  <option value="1">Secretário(a)</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
            <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  
    <!-- Modal Nova Senha -->
    <div class="modal fade" id="new-pass" tabindex="-1" role="dialog" aria-labelledby="new-pass">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="new-pass"><span class="pe-7s-lock"></span> Nova senha</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <input type="hidden" name="usu_codp" id="usu_codp" value="">
              <div class="form-group">
                <label>Nova senha *</label>
                <input class="form-control" placeholder="Nova senha" name="usu_senp" id="usu_senp" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Repita a senha *</label>
                <input class="form-control" placeholder="Repita a senha" name="rep_senp" id="rep_senp" required autocomplete="off">
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="NewPass" id="NewPass">
            <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
  
  <!--   Core JS Files   -->
  <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

  <!--  Checkbox, Radio & Switch Plugins -->
  <script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>


  <!--  Charts Plugin -->
  <script src="assets/js/chartist.min.js"></script>

  <!--  Notifications Plugin    -->
  <script src="assets/js/bootstrap-notify.js"></script>

  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var usu_cod = $(this).data('cod');
      $(".modal-body #usu_cod").val(usu_cod);
      var usu_log = $(this).data('log');
      $(".modal-body #usu_log").val(usu_log);
      var usu_tpo = $(this).data('tpo');
      $("#usu_tpo").val(usu_tpo);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var usu_cod = $(this).data('cod');
      $(".modal-footer #usu_codx").val(usu_cod);
      var usu_log = $(this).data('log');
      $(".modal-footer #usu_logx").html(usu_log);
    });
  </script>
  
  <script type="text/javascript">
    $(document).on("click", ".openNewPass", function () {
      var usu_cod = $(this).data('cod');
      $(".modal-body #usu_codp").val(usu_cod);
    });
  </script>
  
  <script type="text/javascript">
    $("#NewPass").click(function() {
      var usu_sen = $("#usu_senp").val();
      var rep_sen = $("#rep_senp").val();
      
      if (usu_sen != rep_sen) {
        return false;
      }
    });
  </script>

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
