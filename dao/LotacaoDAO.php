<?php
// @arquivo = /dao/LotacaoDAO.php
// MVC = controller
// objeto = Lotacao

  require_once('../model/Lotacao.class.php');
  require_once('OfertaDAO.php');
  require_once('ProfessorDAO.php');
  require_once('../lib/BD.class.php');

  class LotacaoDAO {

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT ofr_cod FROM tab_lot GROUP BY ofr_cod";
        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

        $lotacoes = NULL;
        while ($aux = $search->fetch(PDO::FETCH_ASSOC)) {

          $sql = "SELECT * FROM tab_lot WHERE ofr_cod = ?";
          $search2 = $dbh->prepare($sql);
          $search2->bindValue(1, $aux["ofr_cod"]);

          if (!$search2->execute())
            return 0;

          $lot = $search2->fetch(PDO::FETCH_ASSOC);

          $lotacao = new Lotacao();

          $ofertaDAO = new OfertaDAO();
          $lotacao->__set("ofr_cod", $ofertaDAO->search($lot["ofr_cod"]));

          $professorDAO = new ProfessorDAO();
          $professores = NULL;
          $professores[] = $professorDAO->search($lot["prf_cod"]);

          $lot_qtd = NULL;
          $lot_qtd = $lot["lot_qtd"];

          $sla_cod = NULL;
          $sla_cod[] = $lot["sla_cod"];

          $lot_dia = NULL;
          $lot_dia[] = $lot["lot_dia"] . $lot["lot_hor"];

          while ($lot2 = $search2->fetch(PDO::FETCH_ASSOC)) {
            $professores[] = $professorDAO->search($lot2["prf_cod"]);

            $lot_dia[] = $lot2["lot_dia"] . $lot2["lot_hor"];
            $sla_cod[] = $lot2["sla_cod"];
            $lot_qtd += $lot2["lot_qtd"];
          }

          $lotacao->__set("prf_cod", $professores);
          $lotacao->__set("lot_qtd", $lot_qtd);
          $lotacao->__set("sla_cod", $sla_cod);
          $lotacao->__set("lot_dia", $lot_dia);

          $lotacoes[] = $lotacao;
        }

        return $lotacoes;
      } catch(Exception $e) {
        die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
  }
?>
