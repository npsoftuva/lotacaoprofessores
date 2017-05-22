<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
  require_once('../controller/LotacaoController.php');
  require_once('../controller/OfertaController.php');
  require_once('../controller/ProfessorController.php');
  require_once('../controller/SalaController.php');

  $lotacaoController = new LotacaoController();

  $ofertaController = new OfertaController();
  $professorController = new ProfessorController();
  $salaController = new SalaController();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Lotação</title>

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
                    if (isset($_POST["Excluir"])) {
                      if ($lotacaoController->remove($_POST["lot_codx"])) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Lotação removida com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar remover a lotação.</span>
                        </div>
                      <?php }
                    } else if (isset($_POST["Adicionar"])) {
                      $lotacao = new Lotacao();

                      $oferta = new Oferta();
                      $oferta->__set("ofr_cod", $_POST["ofr_cod"]);
                      $lotacao->__set("ofr_cod", $oferta);

                      $professor = new Professor();
                      $professor->__set("prf_cod", $_POST["prf_cod"]);
                      $lotacao->__set("prf_cod", $professor);

                      $sala = new Sala();
                      $sala->__set("sla_cod", $_POST["sla_cod"]);
                      $lotacao->__set("sla_cod", $sala);

                      $lot_int = 0;
                      $lot_dia = "2";

                      /*
                        A B C D  E  F
                        0 2 4 8 16 32
                      */
                      $aux = ["2", "3", "4", "5", "6", "7"];
                      foreach ($aux as $dia)
                        if (isset($_POST[$dia])) {
                          $lot_dia = $dia;
                          $lot_int = 0;
                          foreach ($_POST[$dia] as $value)
                            $lot_int += pow(2, $value);
                        }

                      $lotacao->__set("lot_dia", $lot_dia);
                      $lotacao->__set("lot_hor", $lot_int);
                      $lotacao->__set("lot_int", $lot_int);
                      $lotacao->__set("lot_qtd", 5);

                      if ($lotacaoController->register($lotacao)) { ?>
                        <div class="alert alert-success alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Lotação adicionada com sucesso!</span>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-with-icon" data-notify="container">
                          <span data-notify="icon" class="pe-7s-users"></span>
                          <span data-notify="message">Ocorreu um erro ao tentar adicionar a lotação.</span>
                        </div>
                      <?php }
                    }
                  ?>
                  <div class="header">
                    <h4 class="title">Lotações</h4>
                    <p class="category">
                      Lista de lotações cadastrados
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
                        <th>Período</th>
                        <th>Disciplina</th>
                        <th>Fluxo</th>
                        <th>Turma</th>
                        <th>CH</th>
                        <th>Aulas</th>
                        <th>Semanas</th>
                        <th>Horários</th>
                        <th>Vagas</th>
                        <th>Sala</th>
                        <th>Professor(a)</th>
                        <th>Ações</th>
                      </thead>
                      <tbody>
                      <?php
                      $lotacoes = $lotacaoController->searchAll();
                      if ($lotacoes) foreach ($lotacoes as $lotacao) { ?>
                        <tr>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("cmp")->__get("cmp_sem"); ?></td>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("cmp")->__get("dcp_cod")->__get("dcp_nom"); ?></td>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("cmp")->__get("flx_cod")->__get("flx_cod"); ?></td>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("ofr_trm"); ?></td>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("cmp")->__get("cmp_hor"); ?></td>
                          <td><?php echo $lotacao->__get("lot_qtd"); ?></td>
                          <td><?php echo count($ofertaController->gerarFrequencia($lotacao->__get("ofr_cod")->__get("ofr_cod"))); ?></td>
                          <td><?php
                            foreach ($lotacao->__get("lot_dia") as $dia) {
                              echo $dia . "<br>";
                            }
                        ?></td>
                          <td><?php echo $lotacao->__get("ofr_cod")->__get("ofr_vag"); ?></td>
                          <td><?php
                            foreach ($lotacao->__get("sla_cod") as $sala) {
                              echo $sala->__get("sla_nom") . "<br>";
                            }
                        ?></td>
                          <td><?php
                            foreach ($lotacao->__get("prf_cod") as $professor) {
                              echo $professor->__get("prf_nom") . "<br>";
                            }
                        ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $lotacao->__get("lot_cod"); ?>" data-prd="" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $lotacao->__get("ofr_cod")->__get("ofr_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-users"></span> Excluir Lotacao</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="lot_codx" id="lot_codx" value="">
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-users"></span> Editar Lotacao</h4>
          </div>
          <form role="form" method="POST">
            <div class="modal-body">
            <div class="form-group">
              <label>Oferta *</label>
              <select class="form-control" name="ofr_cod" id="ofr_cod">
                <?php foreach ($ofertaController->searchAll() as $oferta) { ?>
                <option value="<?php echo $oferta->__get("ofr_cod"); ?>"><?php echo $oferta->__get("ofr_cod"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Professor *</label>
              <select class="form-control" name="prf_cod" id="prf_cod">
                <?php foreach ($professorController->searchAll() as $professor) { ?>
                <option value="<?php echo $professor->__get("prf_cod"); ?>"><?php echo $professor->__get("prf_nom"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Sala *</label>
              <select class="form-control" name="flx_cod" id="flx_cod">
                <?php foreach ($salaController->searchAll() as $sala) { ?>
                <option value="<?php echo $sala->__get("sla_cod"); ?>"><?php echo $sala->__get("sla_nom"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <div class="content table-responsive table-full-width">
                <table class="table table-striped table-hover" id="dataTables-example">
                  <thead>
                    <th> </th>
                    <?php for ($i = ord('A'); $i <= ord('Q'); $i++) { ?>
                      <th><?php echo chr($i); ?></th>
                    <?php } ?>
                  </thead>
                  <tbody>
                    <?php for ($i = 2; $i <= 7; $i++) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <?php for ($c = ord('A'); $c <= ord('Q'); $c++) { ?>
                      <td>
                        <input type="checkbox">
                      </td>
                      <?php } ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
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
            <h4 class="modal-title" id="add"><span class="pe-7s-notebook"></span> Adicionar Lotação</h4>
          </div>
          <form role="form" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label>Oferta *</label>
              <small>Semestre / Fluxo / Disciplina / Turma</small>
              <select class="form-control" name="ofr_cod" id="ofr_cod">
                <?php foreach ($ofertaController->searchAll() as $key => $oferta) { ?>
                <option value="<?php echo $oferta->__get("ofr_cod"); ?>"><?php echo $oferta->__get("cmp")->__get("cmp_sem") . " - " . $oferta->__get("cmp")->__get("flx_cod")->__get("flx_cod") . " - " . $oferta->__get("cmp")->__get("dcp_cod")->__get("dcp_nom") . " - " . $oferta->__get("ofr_trm"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Professor *</label>
              <select class="form-control" name="prf_cod" id="prf_cod">
                <?php foreach ($professorController->searchAll() as $professor) { ?>
                <option value="<?php echo $professor->__get("prf_cod"); ?>"><?php echo $professor->__get("prf_nom"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Sala *</label>
              <select class="form-control" name="sla_cod" id="sla_cod">
                <?php foreach ($salaController->searchAll() as $sala) { ?>
                <option value="<?php echo $sala->__get("sla_cod"); ?>"><?php echo $sala->__get("sla_nom"); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <div class="content table-responsive table-full-width">
                <table class="table table-striped table-hover" id="dataTables-example">
                  <thead>
                    <th> </th>
                    <?php for ($i = ord('A'); $i <= ord('Q'); $i++) { ?>
                      <th><?php echo chr($i); ?></th>
                    <?php } ?>
                  </thead>
                  <tbody>
                    <?php for ($i = 2; $i <= 7; $i++) { $j = 0; ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <?php for ($c = ord('A'); $c <= ord('Q'); $c++) { ?>
                      <td>
                        <input type="checkbox" name="<?php echo $i; ?>[]" value="<?php echo $j++; ?>">
                      </td>
                      <?php } ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
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
      $(".modal-body #prd_cod").val(prd_cod);
      var cmp_sem = $(this).data('sem');
      $(".modal-body #cmp_sem").val(cmp_sem);
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
      var lot_cod = $(this).data('cod');
      $(".modal-footer #lot_codx").val(lot_cod);
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

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>