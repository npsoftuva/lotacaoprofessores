<?php
  require_once('verificaSessao.php');
  require_once('../lib/Report.php');
	require_once('../controller/LotacaoController.php');
  require_once('../controller/SalaController.php');

  $lotacaoController = new LotacaoController();
	$lotacoes = $lotacaoController->searchClassInRoom($_GET['sla_cod']);

  $salaController = new SalaController();
  $sala = $salaController->search($_GET['sla_cod']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>LotaProf | Relatório</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	</head>
	<body>
	  <?php
	  	$header = "<br><h2>LOTAÇÃO DE SALA - " . $sala->__get('sla_nom') . "</h2>";
      
	  	$content = "<br><br><br><table><tr><th>HORÁRIOS</th><th>SEGUNDA-FEIRA</th><th>TERÇA-FEIRA</th><th>QUARTA-FEIRA</th><th>QUINTA-FEIRA</th><th>SEXTA-FEIRA</th></tr>";

		  foreach ($lotacoes as $key => $line) {
		    $content .= "<tr><td>" . $key . "</td>";

        foreach ($line as $col) {
			    $content .= "<td>" . $col . "</td>";
        }

			  $content .= "</tr>";
      }

		  $content .= "</table>";
		
		  $report = new report();
		  // caminho relativo a localização da classe Report
		  $report->setCss('../view/assets/css/css-lot-sala.css'); 
			$report->setHeader($header);
			$report->setContent($content);
			$report->buildPDF();
			$report->displayPDF('lota_sala_' . $sala->__get('sla_nom') . 'pdf');
			exit;
		?>	 
	</body>
</html>