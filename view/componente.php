<?php
  require_once('verificaSessao.php');
  require_once('../controller/ComponenteController.php');
  require_once('../controller/FluxoController.php');
  require_once('../controller/DisciplinaController.php');

  $componenteController = new ComponenteController();
  $componentes = $componenteController->searchAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Componente</title>

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
                      // criando o objeto Componente
                      $componente = new Componente();
                      $componente->__set("cmp_sem", $_POST["cmp_sem"]);
                      $componente->__set("cmp_hor", $_POST["cmp_hor"]);                                                                      
                      // criando um objeto Fluxo para setar em Componente
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_cod"]);
                      $componente->__set("flx_cod", $fluxo);
                      // criando um objeto Disciplina para setar em Componente
                      $disciplina = new Disciplina();
                      $disciplina->__set("dcp_cod", $_POST["dcp_cod"]);
                      $componente->__set("dcp_cod", $disciplina);
                      if ($componenteController->register($componente)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Componente adicionado com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar adicionar o componente.</span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                      if ($componenteController->remove($_POST["flx_codx"],$_POST["dcp_codx"])) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Componente excluído com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar excluir o componente.</span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                      // criando o objeto Componente
                      $componente = new Componente();
                      $componente->__set("cmp_sem", $_POST["cmp_seme"]);
                      $componente->__set("cmp_hor", $_POST["cmp_hore"]);                                                                      
                      // criando um objeto Fluxo para setar em Componente
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_code"]);
                      $componente->__set("flx_cod", $fluxo);
                      // criando um objeto Disciplina para setar em Componente
                      $disciplina = new Disciplina();
                      $disciplina->__set("dcp_cod", $_POST["dcp_code"]);
                      $componente->__set("dcp_cod", $disciplina);
                      if ($componenteController->update($componente)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Componente editado com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-notebook"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar editar o componente.</span>
                        </div>
                      <?php }
                    }

                    $componentes = $componenteController->searchAll();
                  ?>
                  <div class="header">
                    <h4 class="title">Componentes</h4>
                    <p class="category">
                      Lista de componentes cadastrados
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
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Fluxo</th>
                        <th class="col-xs-7 col-sm-7 col-md-7 col-lg-7">Disciplina</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Semestre</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">CH</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php if(isset($componentes)) foreach ($componentes as $componente) { ?>
                        <tr>
                          <td><?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?></td>
                          <td><?php echo $componente->__get("dcp_cod")->__get("dcp_nom"); ?></td>
                          <td><?php echo $componente->__get("cmp_sem"); ?></td>
                          <td><?php echo $componente->__get("cmp_hor"); ?></td>
                          <td>
                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod")->__get("dcp_cod"); ?>" data-sem="<?php echo $componente->__get("cmp_sem"); ?>" data-hor="<?php echo $componente->__get("cmp_hor"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-flx="<?php echo $componente->__get("flx_cod")->__get("flx_cod"); ?>" data-dcp="<?php echo $componente->__get("dcp_cod")->__get("dcp_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-refresh-2"></span> Excluir Componente</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="flx_codx" id="flx_codx" value="">
              <input type="hidden" name="dcp_codx" id="dcp_codx" value="">
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
          <form role="form" method="POST">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="edit"><span class="pe-7s-refresh-2"></span> Editar Componente</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_code" id="flx_code" required>
                  <?php
                  $fluxoController = new FluxoController();
                  $fluxos = $fluxoController->searchAll();
                  foreach ($fluxos as $fluxo) {
                  ?>
                  <option value="<?php echo $fluxo->__get('flx_cod'); ?>"><?php echo $fluxo->__get('flx_cod'); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_code" id="dcp_code" required>
                  <?php
                  $disciplinaController = new DisciplinaController();
                  $disciplinas = $disciplinaController->searchAll();
                  foreach ($disciplinas as $disciplina) {
                  ?>
                  <option value="<?php echo $disciplina->__get('dcp_cod'); ?>"><?php echo $disciplina->__get('dcp_nom'); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_seme" id="cmp_seme" required></select>
              </div>
              <div class="form-group">
                <label>Carga horária *</label>
                <input class="form-control" type="number" placeholder="Carga horária da disciplina" name="cmp_hore" id="cmp_hore" required autocomplete="off" min="1">
              </div>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-warning btn-fill" data-dismiss="modal" value="Cancelar">
              <input type="submit" class="btn btn-success btn-fill" value="Salvar" name="Editar">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="add"><span class="pe-7s-refresh-2"></span> Adicionar Componente</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_cod" id="flx_cod" required>
                  <?php
                  $fluxoController = new FluxoController();
                  $fluxos = $fluxoController->searchAll();
                  foreach ($fluxos as $fluxo) {
                  ?>
                  <option value="<?php echo $fluxo->__get('flx_cod'); ?>"><?php echo $fluxo->__get('flx_cod'); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_cod" required>
                  <?php
                  $disciplinaController = new DisciplinaController();
                  $disciplinas = $disciplinaController->searchAll();
                  foreach ($disciplinas as $disciplina) {
                  ?>
                  <option value="<?php echo $disciplina->__get('dcp_cod'); ?>"><?php echo $disciplina->__get('dcp_nom'); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_sem" id="cmp_sem" required></select>
              </div>
              <div class="form-group">
                <label>Carga horária *</label>
                <input class="form-control" type="number" placeholder="Carga horária da disciplina" name="cmp_hor" required autocomplete="off" min="1">
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
  </body>


  <!--   Core JS Files   -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
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

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var flx_cod = $(this).data('flx');
      $(".modal-body #flx_code").val(flx_cod);
      var dcp_cod = $(this).data('dcp');
      $(".modal-body #dcp_code").val(dcp_cod);
      var cmp_sem = $(this).data('sem');
      $("#cmp_seme").val(cmp_sem);
      var cmp_hor = $(this).data('hor');
      $("#cmp_hore").val(cmp_hor);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var flx_cod = $(this).data('flx');
      $(".modal-footer #flx_codx").val( flx_cod );
      var dcp_cod = $(this).data('dcp');
      $(".modal-footer #dcp_codx").val( dcp_cod );
    });
  </script>

  <script type="text/javascript">
  $(document).ready(function() {
    var fluxo = {};

    <?php
      $fluxoController = new FluxoController();
      $fluxos = $fluxoController->searchAll();
      foreach ($fluxos as $f) { ?>
      fluxo[<?php echo $f->__get("flx_cod"); ?>] = [
      <?php for ($i = 1; $i < $f->__get("flx_sem"); $i++) { ?>
      {display: "<?php echo $i; ?>", value: "<?php echo $i; ?>" },
      <?php } ?>
      {display: "<?php echo $f->__get('flx_sem'); ?>", value: "<?php echo $f->__get('flx_sem'); ?>" }
      ];
    <?php } ?>

    $("#flx_cod").change(function() {
      var parent = $(this).val();
      list(fluxo[parent]);
    });

    list(fluxo[<?php echo $fluxos[0]->__get('flx_cod');?>]);

    function list(array_list) {
      $("#cmp_sem").html("");
      $(array_list).each(function (i) {
        $("#cmp_sem").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");
      });
    }

    $("#flx_code").change(function() {
      var parent = $(this).val();
      liste(fluxo[parent]);
    });

    liste(fluxo[$('#flx_code').val()]);

    function liste(array_list) {
      $("#cmp_seme").html("");
      $(array_list).each(function (i) {
        $("#cmp_seme").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");
      });
    }
  });
</script>

</html>
