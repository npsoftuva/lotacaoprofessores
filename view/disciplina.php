<?php
  require_once('../controller/DisciplinaController.php');

  $disciplinaController = new DisciplinaController();
  $disciplinas = $disciplinaController->searchAll();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Disciplina</title>

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
                    if (isset($_POST["Adicionar"])){
                        $disciplina = new Disciplina();
                        $disciplina->__set("dcp_nom", $_POST["nom"]);
                        if ($disciplinaController->register($disciplina)) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Disciplina adicionada com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar adicionar a disciplina.</span>
                          </div>
                        <?php }

                    } else if (isset($_POST["Excluir"])) {
                        if ($disciplinaController->remove($_POST["dcp_codx"])) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Disciplina excluída com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar excluir a disciplina.</span>
                          </div>
                        <?php }

                    } else if (isset($_POST["Editar"])){
                        $disciplina = new Disciplina();
                        $disciplina->__set("dcp_cod", $_POST["dcp_cod"]);
                        $disciplina->__set("dcp_nom", $_POST["dcp_nom"]);

                        if ($disciplinaController->update($disciplina)) { ?>
                          <div class="alert alert-success alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Disciplina editada com sucesso!</span>
                          </div>
                        <?php } else { ?>
                          <div class="alert alert-danger alert-with-icon" data-notify="container">
                            <span data-notify="icon" class="pe-7s-notebook"></span>
                            <span data-notify="message">Ocorreu um erro ao tentar editar a disciplina.</span>
                          </div>
                        <?php }
                    }


                    $disciplinas  = $disciplinaController->searchAll();
                ?>
                  <div class="header">
                    <h4 class="title">Disciplinas</h4>
                    <p class="category">
                      Lista de disciplinas cadastradas
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
                        <th class="col-xs-10 col-sm-10 col-md-10 col-lg-10">Nome</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
<?php foreach ($disciplinas as $disciplina) { ?>
                        <tr>
                          <td><?php echo $disciplina->__get("dcp_nom"); ?></td>
                          <td>
                            <a data-toggle="modal" data-cod="<?php echo $disciplina->__get("dcp_cod"); ?>" data-nom="<?php echo $disciplina->__get("dcp_nom"); ?>" title="Editar" class="openEdit btn btn-warning" href="#edit"><span class="pe-7s-note" aria-hidden="true"></span></a>

                            <a data-toggle="modal" data-cod="<?php echo $disciplina->__get("dcp_cod"); ?>" data-nom="<?php echo $disciplina->__get("dcp_nom"); ?>" title="Excluir" class="openDelete btn btn-danger" href="#delete"><span class="pe-7s-trash" aria-hidden="true"></span></a>
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
            <h4 class="modal-title"><span class="pe-7s-notebook"></span> Excluir Disciplina</h4>
          </div>
          <div class="modal-footer">
            <form role="form" method="POST">
              <input type="hidden" name="dcp_codx" id="dcp_codx" value="">
              <p>Você deseja excluir a disciplina "<b id="dcp_nomx"></b>"?</p>
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
            <h4 class="modal-title" id="edit"><span class="pe-7s-notebook"></span> Editar Disciplina</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <input type="hidden" name="dcp_cod" id="dcp_cod" value="">
                <div class="form-group">
                  <label>Nome</label>
                  <input class="form-control" type="text" name="dcp_nom" id="dcp_nom" value="" required autocomplete="off">
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
            <h4 class="modal-title" id="add"><span class="pe-7s-notebook"></span> Adicionar Disciplina</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST">
              <div class="form-group">
                <label>Nome *</label>
                <input class="form-control" placeholder="Nome da Disciplina" name="nom" id="nom" required autocomplete="off">
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
    $(document).on("click", ".openEdit", function () {
      var dcp_cod = $(this).data('cod');
      $(".modal-body #dcp_cod").val(dcp_cod);
      var dcp_nom = $(this).data('nom');
      $(".modal-body #dcp_nom").val(dcp_nom);
    });
  </script>


  <script type="text/javascript">
    $(document).on("click", ".openDelete", function () {
      var dcp_cod = $(this).data('cod');
      $(".modal-footer #dcp_codx").val( dcp_cod );
      var dcp_nom = $(this).data('nom');
      $(".modal-footer #dcp_nomx").html(dcp_nom);
    });
  </script>

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
