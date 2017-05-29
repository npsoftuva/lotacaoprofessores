<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
  require_once('../controller/PeriodoController.php');

  $periodoController = new PeriodoController();
  $periodos = $periodoController->searchAll();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Período</title>

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

<?php
	$periodos = $periodoController->searchAll();
?>

        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
                 <?php
                    if (isset($_POST["Adicionar"])) {
                        // criando um objeto Periodo.
                        $periodo = new Periodo();
                        $periodo->__set("prd_cod", $_POST["prd_coda"]);
                        // criando um objeto Calendario para setar em Periodo
                        $prd_ini = new Calendario();
                        $prd_ini->__set("cld_dta", $_POST["prd_inia"]);
                        $periodo->__set("prd_ini", $prd_ini);
                        // criando um objeto Calendario para setar em Periodo
                        $prd_fim = new Calendario();
                        $prd_fim->__set("cld_dta", $_POST["prd_fima"]);
                        $periodo->__set("prd_fim", $prd_fim);
                        if ($periodoController->register($periodo)) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Período adicionado com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar adicionar o período.</span>
                          </div>
                        <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                        $return = $periodoController->remove($_POST["prd_codx"]);
                        if ($return === 1) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Período excluído com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message"><?php echo $return; ?></span>
                          </div>
                        <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                        // criando um objeto Periodo.
                        $periodo = new Periodo();
                        $periodo->__set("prd_cod", $_POST["prd_cod"]);
                        // criando um objeto Calendario para setar em Periodo
                        $prd_ini = new Calendario();
                        $prd_ini->__set("cld_dta", $_POST["prd_ini"]);
                        $periodo->__set("prd_ini", $prd_ini);
                        // criando um objeto Calendario para setar em Periodo
                        $prd_fim = new Calendario();
                        $prd_fim->__set("cld_dta", $_POST["prd_fim"]);
                        $periodo->__set("prd_fim", $prd_fim);
                        $return = $periodoController->update($periodo);
                        if ($return === 1) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Período editado com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message"><?php echo $return; ?></span>
                          </div>
                        <?php }
                    }

                    $periodos = $periodoController->searchAll();
                ?>
                  <div class="header">
                    <h4 class="title">Períodos</h4>
                    <p class="category">
                      Lista de períodos cadastrados
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
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Período</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Início</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Fim</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php if (isset($periodos)) foreach ($periodos as $periodo) { ?>
                        <tr>
                          <td><?php echo substr($periodo->__get("prd_cod"), 0, 4) . '.' . substr($periodo->__get("prd_cod"), 4, 1); ?></td>
                          <td><?php echo $periodo->__get("prd_ini")->__get("cld_dta"); ?></td>
                          <td><?php echo $periodo->__get("prd_fim")->__get("cld_dta"); ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $periodo->__get("prd_cod"); ?>" data-ini="<?php echo $periodo->__get("prd_ini")->__get("cld_dta"); ?>" data-fim="<?php echo $periodo->__get("prd_fim")->__get("cld_dta"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $periodo->__get("prd_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title">Excluir Período</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="prd_codx" id="prd_codx" value="">
              <p>Você deseja excluir o período <b id="prd_codxx"></b>?</p>
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
        <form role="form" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="edit">Editar Período</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" type="text" name="prd_cod" id="prd_cod" value="" readonly>
              </div>
              <div class="form-group">
                <label>Início *</label>
                <input class="form-control" type="text" name="prd_ini" id="prd_ini" value="" maxlength="10" onkeyup="mascara( this, mskDate );" pattern=".{10}">
              </div>
              <div class="form-group">
                <label>Fim *</label>
                <input class="form-control" type="text" name="prd_fim" id="prd_fim" value="" maxlength="10" onkeyup="mascara( this, mskDate );" pattern=".{10}">
              </div>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
              <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <form role="form" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="add">Adionar Período</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Código *</label>
                <input class="form-control" placeholder="Código do Período" type="text" name="prd_coda" id="prd_coda">
              </div>
              <div class="form-group">
                <label>Início *</label>
                <input class="form-control" placeholder="Início do Período" type="text" name="prd_inia" id="prd_inia" maxlength="10" onkeyup="mascara( this, mskDate );" pattern=".{10}">
              </div>
              <div class="form-group">
                <label>Fim *</label>
                <input class="form-control" placeholder="Fim do Período" type="text" name="prd_fima" id="prd_fima" maxlength="10" onkeyup="mascara( this, mskDate );" pattern=".{10}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
              <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
            </div>
          </form>
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

  <script src="assets/js/mask.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var prd_cod = $(this).data('cod');
      $(".modal-body #prd_cod").val(prd_cod.toString().substr(0, 4)+'.'+prd_cod.toString().substr(4, 5));
      var prd_ini = $(this).data('ini');
      $(".modal-body #prd_ini").val(prd_ini);
      var prd_fim = $(this).data('fim');
      $(".modal-body #prd_fim").val(prd_fim);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var prd_cod = $(this).data('cod');
      $(".modal-footer #prd_codx").val( prd_cod );
      $(".modal-footer #prd_codxx").html(prd_cod.toString().substr(0, 4)+'.'+prd_cod.toString().substr(4, 5));
    });
  </script>
  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
