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
                  <div class="header">
                    <h4 class="title">Disciplinas</h4>
                    <p class="category">
                      Lista de disciplinas cadastradas
                      <span class="pull-right"><button class="btn btn-success btn-fill">Adicionar</button></span>
                    </p>
                  </div>
                  <div class="content table-responsive table-full-width">
                    <table class="table table-striped table-hover" id="dataTables-example">
                      <thead>
                        <th class="col-xs-10 col-sm-10 col-md-10 col-lg-10">Nome</th>
                        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Ações</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Lógica de Programação</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>Lógica Matemática</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>Estrutura de Dados</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>Programação Orientada ao Objeto</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>Construção e Análise de Algoritmos</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>Compiladores</td>
                          <td>
                            <button class="btn btn-warning"><i class="pe-7s-note"></i></button>
                            <button class="btn btn-danger"><i class="pe-7s-trash"></i></button>
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
</html>
