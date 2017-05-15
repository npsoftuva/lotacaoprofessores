<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
  require_once('../controller/OfertaController.php');
  require_once('../controller/FluxoController.php');
  require_once('../controller/PeriodoController.php');
  require_once('../controller/DisciplinaController.php');
  require_once('../controller/ComponenteController.php');

  $ofertaController = new OfertaController();
  $fluxoController = new FluxoController();
  $periodoController = new PeriodoController();
  $disciplinaController = new DisciplinaController();
  $componenteController = new ComponenteController();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Oferta</title>

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
                      // criando um objeto Oferta
                      $oferta = new Oferta();
                      $oferta->__set("ofr_trm", $_POST["ofr_trma"]);
                      $oferta->__set("ofr_vag", $_POST["ofr_vaga"]);
                      // criando um objeto Periodo para setar em Oferta
                      $periodo = new Periodo();
                      $periodo->__set("prd_cod", $_POST["prd_coda"]);
                      $oferta->__set("prd_cod", $periodo);
                      // criando um objeto Fluxo para setar em Oferta
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_coda"]);
                      // criando um objeto Disciplina para setar em Oferta
                      $disciplina = new Disciplina();
                      $disciplina->__set("dcp_cod", $_POST["dcp_coda"]);
                      // criando um objeto Componente para setar em Oferta
                      $componente = new Componente();
                      $componente->__set("flx_cod", $fluxo);
                      $componente->__set("dcp_cod", $disciplina);
                      $oferta->__set("cmp", $componente);
                      
                      if ($ofertaController->register($oferta)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Oferta adicionada com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar adicionar a oferta.</span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Excluir"])) {
                      if ($ofertaController->remove($_POST["ofr_codx"])) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Oferta removida com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar excluir a oferta.</span>
                        </div>
                      <?php }
                    } else
                    if (isset($_POST["Editar"])) {
                      // criando um objeto Oferta
                      $oferta = new Oferta();
                      $oferta->__set("ofr_cod", $_POST["ofr_cod"]);
                      $oferta->__set("ofr_trm", $_POST["ofr_trm"]);
                      $oferta->__set("ofr_vag", $_POST["ofr_vag"]);
                      // criando um objeto Periodo para setar em Oferta
                      $periodo = new Periodo();
                      $periodo->__set("prd_cod", $_POST["prd_cod"]);
                      $oferta->__set("prd_cod", $periodo);
                      // criando um objeto Fluxo para setar em Oferta
                      $fluxo = new Fluxo();
                      $fluxo->__set("flx_cod", $_POST["flx_cod"]);
                      // criando um objeto Disciplina para setar em Oferta
                      $disciplina = new Disciplina();
                      $disciplina->__set("dcp_cod", $_POST["dcp_cod"]);
                      // criando um objeto Componente para setar em Oferta
                      $componente = new Componente();
                      $componente->__set("flx_cod", $fluxo);
                      $componente->__set("dcp_cod", $disciplina);
                      $oferta->__set("cmp", $componente);
                      
                      if ($ofertaController->update($oferta)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Oferta editada com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar editar a oferta.</span>
                        </div>
                      <?php }
                    }

                    $ofertas = $ofertaController->searchAll();
                    $fluxos = $fluxoController->searchAll();
                    $lastPeriodo = $periodoController->searchLastCod();
                    $lastFluxo = $fluxoController->searchLastCod();
                  ?>
                  <div class="header">
                    <h4 class="title">Ofertas</h4>
                    <p class="category">
                      Lista de ofertas cadastrados
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
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Período</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Semestre</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Fluxo</th>
                        <th class="col-xs-5 col-sm-5 col-md-5 col-lg-5">Disciplina</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Turma</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Vagas</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php if (isset($ofertas)) foreach ($ofertas as $oferta) { ?>
                        <tr>
                          <td><?php echo $oferta->__get("prd_cod")->__get("prd_cod"); ?></td>
                          <td><?php echo $oferta->__get("cmp")->__get("cmp_sem"); ?></td>
                          <td><?php echo $oferta->__get("cmp")->__get("flx_cod")->__get("flx_cod"); ?></td>
                          <td><?php echo $oferta->__get("cmp")->__get("dcp_cod")->__get("dcp_nom"); ?></td>
                          <td><?php echo $oferta->__get("ofr_trm"); ?></td>
                          <td><?php echo $oferta->__get("ofr_vag"); ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $oferta->__get("ofr_cod"); ?>" data-prd="<?php echo $oferta->__get("prd_cod")->__get("prd_cod"); ?>" data-sem="<?php echo $oferta->__get("cmp")->__get("cmp_sem"); ?>" data-flx="<?php echo $oferta->__get("cmp")->__get("flx_cod")->__get("flx_cod"); ?>" data-dcp="<?php echo $oferta->__get("cmp")->__get("dcp_cod")->__get("dcp_nom"); ?>" data-trm="<?php echo $oferta->__get("ofr_trm"); ?>" data-vag="<?php echo $oferta->__get("ofr_vag"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $oferta->__get("ofr_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-users"></span> Excluir Oferta</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="ofr_codx" id="ofr_codx" value="">
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-users"></span> Editar Oferta</h4>
          </div>
          <form role="form" method="POST">
            <div class="modal-body">
              <input type="hidden" name="ofr_cod" id="ofr_cod" value="">
              <div class="form-group">
                <label>Período *</label>
                <select class="form-control" name="prd_cod" id="prd_cod">
                  <option value="<?php echo $lastPeriodo->__get("prd_cod"); ?>"><?php echo $lastPeriodo->__get("prd_cod"); ?></option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_sem" id="cmp_sem">
                  <?php
                  for ($i = 1; $i <= $lastFluxo->__get("flx_sem"); $i++) { ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_cod" id="dcp_cod">
                </select>
              </div>
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_cod" id="flx_cod">
                  <?php foreach ($fluxos as $fluxo) { ?>
                  <option value="<?php echo $fluxo->__get("flx_cod"); ?>"><?php echo $fluxo->__get("flx_cod"); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Turma *</label>
                <input class="form-control" type="number" placeholder="Nº da Turma" id="ofr_trm" name="ofr_trm" min="1" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Vagas *</label>
                <input class="form-control" type="number" placeholder="Quat. de vagas da oferta" id="ofr_vag" name="ofr_vag" min="1" required autocomplete="off">
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
            <h4 class="modal-title" id="add"><span class="pe-7s-users"></span> Adicionar Oferta</h4>
          </div>
          <form role="form" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label>Período *</label>
                <select class="form-control" name="prd_coda" id="prd_coda">
                  <option value="<?php echo $lastPeriodo->__get("prd_cod"); ?>"><?php echo $lastPeriodo->__get("prd_cod"); ?></option>
                </select>
              </div>
              <div class="form-group">
                <label>Semestre *</label>
                <select class="form-control" name="cmp_sema" id="cmp_sema">
                  <?php
                  for ($i = 1; $i <= $lastFluxo->__get("flx_sem"); $i++) { ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Disciplina *</label>
                <select class="form-control" name="dcp_coda" id="dcp_coda">
                </select>
              </div>
              <div class="form-group">
                <label>Fluxo *</label>
                <select class="form-control" name="flx_coda" id="flx_coda">
                  <?php foreach ($fluxos as $fluxo) { ?>
                  <option value="<?php echo $fluxo->__get("flx_cod"); ?>"><?php echo $fluxo->__get("flx_cod"); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Turma *</label>
                <input class="form-control" type="number" placeholder="Nº da Turma" id="ofr_trma" name="ofr_trma" min="1" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Vagas *</label>
                <input class="form-control" type="number" placeholder="Quat. de vagas da oferta" id="ofr_vaga" name="ofr_vaga" min="1" required autocomplete="off">
              </div>
            </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
                <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
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


  <!--  Google Maps Plugin    -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>


  <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  <script src="assets/js/light-bootstrap-dashboard.js"></script>

  <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script src="assets/js/mask.js"></script>
  
  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var ofr_cod = $(this).data('cod');
      $(".modal-body #ofr_cod").val(ofr_cod);
      var prd_cod = $(this).data('prd');
      $(".modal-body #cmp_sem").val(cmp_sem);
      var cmp_sem = $(this).data('sem');
      $(".modal-body #prd_cod").val(prd_cod);
      var dcp_cod = $(this).data('dcp');
      $(".modal-body #dcp_cod").val(dcp_cod);
      var flx_cod = $(this).data('flx');
      $(".modal-body #flx_cod").val(flx_cod);
      var ofr_trm = $(this).data('trm');
      $(".modal-body #ofr_trm").val(ofr_trm);
      var ofr_vag = $(this).data('vag');
      $(".modal-body #ofr_vag").val(ofr_vag);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var ofr_cod = $(this).data('cod');
      $(".modal-footer #ofr_codx").val(ofr_cod);
    });
  </script>
  <script>
    $(".alert").fadeTo(1000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
  
  <script type="text/javascript">
    $(document).ready(function() {
      var disciplinas = {};
      
      <?php      
      for ($i = 1; $i <= $lastFluxo->__get("flx_sem"); $i++) {
        $disciplinas = $disciplinaController->disciplinasFromSemestre($i); 
        if ($disciplinas != null) { ?>
          disciplinas[<?php echo $i; ?>] = [
            <?php foreach ($disciplinas as $d) { ?>
            {display: "<?php echo $d->__get("dcp_nom"); ?>", value: "<?php echo $d->__get("dcp_cod"); ?>" },
            <?php } ?>
          ];
        <?php }
      } ?>
        
      $("#cmp_sema").change(function() {
        var parent = $(this).val();
        listaDisciplinasA(disciplinas[parent]);
      });
      
      function listaDisciplinasA(array_list) {
        $("#dcp_coda").html("");
        $(array_list).each(function (i) {
          $("#dcp_coda").append("<option value='"+array_list[i].value+"'>"+array_list[i].display+"</option>");
        });
      }
      
      $("#cmp_sem").change(function() {
        var parent = $(this).val();
        listaDisciplinasE(disciplinas[parent]);
      });
      
      function listaDisciplinasE(array_list) {
        $("#dcp_cod").html("");
        $(array_list).each(function (i) {
          $("#dcp_cod").append("<option value='"+array_list[i].value+"'>"+array_list[i].display+"</option>");
        });
      }
    });
  </script>
</html>