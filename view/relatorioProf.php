<?php
  require_once('verificaSessao.php');
  require_once('../lib/Report.php');
  require_once('../controller/LotacaoController.php');
  require_once('../controller/OfertaController.php');

  $lotacaoController = new LotacaoController();
  $lotacoes = $lotacaoController->searchAllReport();

  $ofertaController = new OfertaController();
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
	    /* Se existirem lotações cadastradas cria uma linha de tabela para cada lotação */
	    if (isset($lotacoes)) {
		    $lots = "";
				
				foreach ($lotacoes as $lotacao) {
					$semestre = $lotacao->__get("ofr_cod")->__get("cmp")->__get("cmp_sem");
					$trn = $lotacao->__get("ofr_cod")->__get("cmp")->__get("flx_cod")->__get("flx_trn");
					$fluxo = $lotacao->__get("ofr_cod")->__get("cmp")->__get("flx_cod")->__get("flx_cod");
					
					if ($trn == "0")
						$turno = "INT.";
					else if ($trn == "1")
						$turno = "MAN.";
					else if ($trn == "2")
						$turno = "TAR.";
					else
						$turno = "NOI.";
						
					$lots .= "<tr" . (($semestre % 2) ? "" : " class='zebra'") . ">
						<td>" . $semestre . "° </td>
						<td class='esquerda'>" . $lotacao->__get("ofr_cod")->__get("cmp")->__get("dcp_cod")->__get("dcp_nom") . "</td>
						<td>" . substr($fluxo, 0, 4) . "." . substr($fluxo, 4, 1) . "</td>
						<td>" . $lotacao->__get("ofr_cod")->__get("ofr_trm") . "</td>
						<td>" . $turno . "</td>
						<td>" . $lotacao->__get("ofr_cod")->__get("cmp")->__get("cmp_hor") . "</td>
						<td>" . $lotacao->__get("lot_qtd") . "</td>
						<td>" . count($ofertaController->gerarFrequencia($lotacao->__get("ofr_cod")->__get("ofr_cod"))) . "</td>
						<td>";

					foreach ($lotacao->__get("lot_dia") as $dia) {
						$lots .= ($dia . "<br>");
					}

					$lots .= "</td>
						<td>" . $lotacao->__get("ofr_cod")->__get("ofr_vag") . "</td>
						<td>";

					foreach ($lotacao->__get("sla_cod") as $sala) {
						$lots .= ($sala->__get("sla_nom") . "<br>");
					}

					$lots .= "</td>
						<td class='esquerda'>";

					foreach ($lotacao->__get("prf_cod") as $professor) {
						$lots .= ($professor->__get("prf_nom") . "<br>");
					}

					$lots .= "</td>				
						</tr>";
		  	}
				
				$periodo = $lotacao->__get("ofr_cod")->__get("prd_cod")->__get("prd_cod");
		
			  $header = "<table class='header'><tr><td><strong>Ofertas Ciências da Computação - Bacharelado - Semestre: " . substr($periodo, 0, 4) . "." . substr($periodo, 4, 1) . " - Ofício " . $_POST['num_ofc'] . "</strong></td></tr></table>";
		
			  $content = "<br><table class='content'><tr><th>Período</th><th>Disciplina</th><th>Fluxo</th><th>Turma</th><th>Turno</th><th>C.H.</th><th>Aulas</th><th>Semanas</th><th>Horário</th><th>Vagas</th><th>Sala</th><th>Professor(a)</th></tr>" . $lots . "</table>";

			  $report = new Report();
			  $report->setCss('../view/assets/css/css-lot-prof.css'); // caminho relativo a localização da classe Report
				$report->setHeader($header);
				$report->setContent($content);
				$report->buildPDF();
				$report->displayPDF('lota_prof_' . $periodo . '.pdf');
				exit;
			} else {
				echo 'nao há lotações cadastradas';
			}
		?>
	</body>
</html>