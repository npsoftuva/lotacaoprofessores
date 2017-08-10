<?php
  require_once('verificaSessao.php');
  require_once('verificaPapel.php');
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
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <!--  Legenda do calendário  -->
    <link href="assets/css/legenda-calendario.css" rel="stylesheet" />
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
                    $calendario->__set("cld_dta", $_POST["cld_dtae"]);
                    $calendario->__set("cld_evt", $_POST["cld_evte"]);
                    $calendario->__set("cld_tpo", $_POST["cld_tpoe"]);
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
                  <div id="calendario">
                  </div>
                </div>
                <div id="legenda">
                  <strong>Legenda:</strong>
                  <div class="quadrado feriado"></div> <span>Feriado</span>
                  <div class="quadrado facultativo"></div> <span>Ponto Facultativo</span>
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
              <p>Você deseja excluir o evento <b id="cld_evtx"></b>?</p>
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
                  <input class="form-control" type="text" name="cld_dtae" id="cld_dtae" value="" readonly>
                </div>
                <div class="form-group">
                  <label>Nome</label>
                  <input class="form-control" type="text" name="cld_evte" id="cld_evte" value="" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Tipo *</label>
                  <select class="form-control" name="cld_tpoe" id="cld_tpoe" required>
                    <option value="1">Feriado</option>
                    <option value="3">Facultativo</option>
                  </select>
                </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
              <input id="btn-delete" type="button" class="btn btn-danger btn-fill" data-dismiss="modal" value="Deletar">
            </div>
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
                <input class="form-control" type="text" name="cld_dta" id="cld_dta" readonly>
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
            <button type="reset" class="btn btn-warning btn-fill">Limpar</button>
            <input type="submit" class="btn btn-success btn-fill" value="Adicionar" name="Adicionar" id="Adicionar">
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>


  <!--   Core JS Files   -->
  <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  
  <!--  FullCalendar  -->
  <link rel='stylesheet' href='assets/fullcalendar/fullcalendar.css' />
  <script src='assets/fullcalendar/lib/jquery.min.js'></script>
  <script src='assets/fullcalendar/lib/moment.min.js'></script>
  <script src='assets/fullcalendar/fullcalendar.js'></script>
  <!-- script de tradução -->
  <script src='assets/fullcalendar/locale/pt-br.js'></script>

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
    $('#btn-delete').on("click", function() {
      $('#delete').modal('show');
      var cld_dta = $('#cld_dtae').val();
      $(".modal-footer #cld_dtax").val(cld_dta);
      var cld_evt = $('#cld_evte').val();
      $(".modal-footer #cld_evtx").html(cld_evt);
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      
      $('#calendario').fullCalendar({
        /*customButtons: {
          botaoIrParaData: {
            text: 'Ir para',
            click: function() {
              // usar gotoDate
              alert('aqui vai aparecer um datepicker!');              
              //$('#calendario').fullCalendar('gotoDate', '2016-02-02');              
            }
          }
        },*/
        header: {
          left: 'prevYear prev',
          center: 'title',
          right: /*botaoIrParaData*/ 'today next nextYear'
        },
        validRange: {
          start: <?php echo "'" . $calendarioController->searchMinDate() . "'"; ?>
        },        
        defaultDate: $.now(),
        selectable: true,
        editable: false,        
        eventLimit: true,
        events: <?php echo $calendarios ?>,        
        hiddenDays: [0],
        dayClick: function(date) {
          jQuery.noConflict();       
          $('#add').modal('show');
          var month = parseInt(date.month()) + 1;
          $('.modal-body #cld_dta').val(date.date() + "/" + month + "/" + date.year());
        },        
        eventClick: function(event) {
          jQuery.noConflict();          
          $('#edit').modal('show');
          var month = parseInt(event.start.month()) + 1;
          $('.modal-body #cld_dtae').val(event.start.date() + "/" + month + "/" + event.start.year());
          $('.modal-body #cld_evte').val(event.title);
          $('.modal-body #cld_tpoe').val(event.type);
        }
      });
    });
  </script>

  <script>
    $(".alert").fadeTo(4000, 500).slideUp(1000, function(){
      $(".alert").slideUp(4000);
    });
  </script>
</html>
