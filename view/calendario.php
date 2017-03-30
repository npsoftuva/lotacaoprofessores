<?php
  require_once('../controller/CalendarioController.php');

  $calendarioController = new CalendarioController();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Calendário</title>

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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
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
                    $calendario = new Calendario();
                    $calendario->__set("cld_dta", date_format(date_create(implode("-",array_reverse(explode("/",$_POST["cld_dta"])))), 'Y-m-d'));
                    $calendario->__set("cld_evt", $_POST["cld_evt"]);
                    $calendario->__set("cld_tpo", $_POST["cld_tpo"]);
                    if ($calendarioController->register($calendario)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Evento adicionado com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar adicionar o evento.</span>
                      </div>
                    <?php }
                  } else
                  if (isset($_POST["Excluir"])) {
                    if ($calendarioController->remove($_POST["cld_dtax"])) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Evento excluído com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar excluir o evento.</span>
                      </div>
                    <?php }
                  } else
                  if (isset($_POST["Editar"])) {
                    $calendario = new Calendario();
                    $calendario->__set("cld_dta", $_POST["cld_dta"]);
                    $calendario->__set("cld_evt", $_POST["cld_evt"]);
                    $calendario->__set("cld_tpo", $_POST["cld_tpo"]);
                    if ($calendarioController->update($calendario)) { ?>
                      <div class="alert alert-success alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Evento editado com sucesso!</span>
                      </div>
                    <?php } else { ?>
                      <div class="alert alert-danger alert-with-icon" data-notify="container">
                        <span data-notify="icon" class="pe-7s-date"></span>
                        <span data-notify="message">Ocorreu um erro ao tentar editar o evento.</span>
                      </div>
                    <?php }
                  }

                  $calendarios = $calendarioController->searchAll();
                ?>
                  <div class="header">
                    <h4 class="title">Eventos</h4>
                    <p class="category">
                      Lista de eventos cadastradas
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
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Data</th>
                        <th class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Nome</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Tipo</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($calendarios as $calendario) { ?>
                        <tr>
                          <td><?php echo date_format(date_create($calendario->__get("cld_dta")), 'd/m/Y'); ?></td>
                          <td><?php echo $calendario->__get("cld_evt"); ?></td>
                          <td><?php echo ($calendario->__get("cld_tpo") == "1" ? "Feriado" : ($calendario->__get("cld_tpo") == "3" ? "Facultativo" : "-")); ?></td>
                          <td>
                            <a data-toggle="modal" data-dta="<?php echo $calendario->__get("cld_dta"); ?>" data-evt="<?php echo $calendario->__get("cld_evt"); ?>" data-tpo="<?php echo $calendario->__get("cld_tpo"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-dta="<?php echo $calendario->__get("cld_dta"); ?>" data-evt="<?php echo $calendario->__get("cld_evt"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-date"></span> Excluir Evento</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="cld_dtax" id="cld_dtax" value="">
              <p>Você deseja excluir o evento "<b id="cld_evtx"></b>"?</p>
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-date"></span> Editar Evento</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
                <div class="form-group">
                  <label>Data</label>
                  <input class="form-control" type="text" name="cld_dta" id="cld_dta" value="" readonly>
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input class="form-control" type="text" name="cld_evt" id="cld_evt" value="" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Tipo *</label>
                  <select class="form-control" name="cld_tpo" id="cld_tpo" required>
                    <option value="1">Feriado</option>
                    <option value="3">Facultativo</option>
                  </select>
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
            <h4 class="modal-title" id="add"><span class="pe-7s-date"></span> Adicionar Evento</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                  <label>Data</label>
                  <input class="form-control" type="text" name="cld_dta" id="cld_dta" placeholder="01/01/2017" required autocomplete="off" onkeyup="mascara( this, mskDate );" maxlength="10" min="10" max="10">
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input class="form-control" type="text" name="cld_evt" id="cld_evt" placeholder="Nome do Evento" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Tipo *</label>
                  <select class="form-control" name="cld_tpo" id="cld_tpo" required>
                    <option value="1">Feriado</option>
                    <option value="3">Facultativo</option>
                  </select>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
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


  <!--  Google Maps Plugin    -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>


  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script src="assets/js/mask.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var cld_dta = $(this).data('dta');
      cld_dta = cld_dta.substr(8,2) + "/" + cld_dta.substr(5,2) + "/" + cld_dta.substr(0,4);
      $(".modal-body #cld_dta").val(cld_dta);
      var cld_evt = $(this).data('evt');
      $(".modal-body #cld_evt").val(cld_evt);
      var cld_tpo = $(this).data('tpo');
      $(".modal-body #cld_tpo").val(cld_tpo);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var cld_dta = $(this).data('dta');
      $(".modal-footer #cld_dtax").val( cld_dta );
      var cld_evt = $(this).data('evt');
      $(".modal-footer #cld_evtx").html(cld_evt);
    });
  </script>

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
