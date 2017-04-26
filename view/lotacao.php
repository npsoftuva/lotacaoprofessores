<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
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
                        <tr>
                          <td>1º</td>
                          <td>Cálculo I</td>
                          <td>2016.1</td>
                          <td>1</td>
                          <td>80</td>
                          <td>5</td>
                          <td>19</td>
                          <td>5BCD 6EF</td>
                          <td>50</td>
                          <td>37</td>
                          <td>Marcus Fábio Lima Ferreira</td>
                          <td>
                            <a data-toggle="modal" data-cod="1" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="1" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
                          </td>
                        </tr>
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-users"></span> Editar Lotacao</h4>
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
                <input class="form-control" type="number" placeholder="Quat. de vagas da lotacao" id="ofr_vag" name="ofr_vag" min="1" required autocomplete="off">
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
            <h4 class="modal-title" id="add"><span class="pe-7s-users"></span> Adicionar Lotacao</h4>
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
                <input class="form-control" type="number" placeholder="Quat. de vagas da lotacao" id="ofr_vaga" name="ofr_vaga" min="1" required autocomplete="off">
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