<?php
  require_once('../controller/ProfessorController.php');

  $professorController = new ProfessorController();
  $professores = $professorController->searchAll();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Professor</title>

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
    <script>
      $(document).ready(function () {
        var $Cpf = $("#cpf");
        $Cpf.mask('000.000.000-00', {reverse: true});
      });
    </script>
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
                    <h4 class="title">Professores</h4>
                    <p class="category">
                      Lista de professores cadastrados
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
                        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Nome</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">CPF</th>
                        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">E-mail</th>
                        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Situação</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($professores as $professor) { ?>
                        <tr>
                          <td><?php echo $professor->__get("prf_nom"); ?></td>
                          <td><?php echo $professor->__get("prf_cpf"); ?></td>
                          <td><?php echo $professor->__get("prf_eml"); ?></td>
                          <td><input type="checkbox" checked="checked"></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $professor->__get("prf_cod"); ?>" data-nom="<?php echo $professor->__get("prf_nom"); ?>" data-cpf="<?php echo $professor->__get("prf_cpf"); ?>" data-eml="<?php echo $professor->__get("prf_eml"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $professor->__get("prf_cod"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title">Excluir Professor</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="prf_codx" id="prf_codx" value="">
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
            <h4 class="modal-title" id="edit">Editar Professor</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <input type="hidden" name="prf_cod" id="prf_cod" value="">
                <div class="form-group">
                  <label>Nome *</label>
                  <input class="form-control" type="text" name="prf_nom" id="prf_nom" value="" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>CPF *</label>
                  <input class="form-control" id="prf_cpf" name="prf_cpf" maxlength="11" required autocomplete="off" onblur="ValidaCPF(this)">
                </div>
                <div class="form-group">
                  <label>E-mail *</label>
                  <input class="form-control" id="prf_eml" name="prf_eml" required autocomplete="off">
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
            <h4 class="modal-title" id="add">Adionar Professor</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Nome *</label>
                <input class="form-control" placeholder="Nome do Professor" name="" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>CPF *</label>
                <input class="form-control" placeholder="000.000.000-00" id="cpf" name="cpf" maxlength="11" required autocomplete="off" onblur="ValidaCPF(this)">
              </div>
              <div class="form-group">
                <label>E-mail *</label>
                <input class="form-control" placeholder="usuario@uvanet.br" name="" required autocomplete="off">
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
    jQuery("#cpf").mask("999.999.999-99");

    function ValidaCPF(elemento) {
      cpf = elemento.value;
      cpf = cpf.replace(/[^\d]+/g, '');
      if (cpf == '') {
        $("#Adicionar").attr('disabled', 'disabled');
        $('#cpf').closest('.form-group').addClass('has-error');
        return elemento.style.borderColor = "#a94442";
      }

      // Elimina CPFs invalidos conhecidos
      if (cpf.length != 11 ||
          cpf == "00000000000" ||
          cpf == "11111111111" ||
          cpf == "22222222222" ||
          cpf == "33333333333" ||
          cpf == "44444444444" ||
          cpf == "55555555555" ||
          cpf == "66666666666" ||
          cpf == "77777777777" ||
          cpf == "88888888888" ||
          cpf == "99999999999") {
        $("#Adicionar").attr('disabled', 'disabled');
        $('#cpf').closest('.form-group').addClass('has-error');
        return elemento.style.borderColor = "#a94442";
      }
      // Valida 1o digito
      add = 0;
      for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11)
        rev = 0;
      if (rev != parseInt(cpf.charAt(9))) {
        $("#Adicionar").attr('disabled', 'disabled');
        $('#cpf').closest('.form-group').addClass('has-error');
        return elemento.style.borderColor = "#a94442";
      }
      // Valida 2o digito
      add = 0;
      for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11)
        rev = 0;
      if (rev != parseInt(cpf.charAt(10))) {
        $("#Adicionar").attr('disabled', 'disabled');
        $('#cpf').closest('.form-group').addClass('has-error');
        return elemento.style.borderColor = "#a94442";
      }
      $("#Adicionar").removeAttr('disabled');
      $('#cpf').closest('.form-group').removeClass('has-error');
      return elemento.style.borderColor = "#e3e3e3";
    }
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openEdit", function () {
      var prf_cod = $(this).data('cod');
      $(".modal-body #prf_cod").val(prf_cod);
      var prf_nom = $(this).data('nom');
      $(".modal-body #prf_nom").val(prf_nom);
      var prf_cpf = $(this).data('cpf');
      $(".modal-body #prf_cpf").val(prf_cpf);
      var prf_eml = $(this).data('eml');
      $(".modal-body #prf_eml").val(prf_eml);
    });
  </script>

  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var prf_cod = $(this).data('cod');
      $(".modal-footer #prf_codx").val( prf_cod );
    });
  </script>
</html>
