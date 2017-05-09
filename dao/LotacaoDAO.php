<?php
// @arquivo = /dao/LotacaoDAO.php
// MVC = controller
// objeto = Lotacao

  require_once('../model/Lotacao.class.php');
  require_once('OfertaDAO.php');
  require_once('ProfessorDAO.php');
  require_once('SalaDAO.php');
  require_once('../lib/BD.class.php');

  class LotacaoDAO {

    public function register (Lotacao $lotacao) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_lot (ofr_cod, prf_cod, sla_cod, lot_dia, lot_hor, lot_int, lot_qtd) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $lotacao->__get("ofr_cod")->__get("ofr_cod"));
        $register->bindValue(2, $lotacao->__get("prf_cod")->__get("prf_cod"));
        $register->bindValue(3, $lotacao->__get("sla_cod")->__get("sla_cod"));
        $register->bindValue(4, $lotacao->__get("lot_dia"));
        $register->bindValue(5, $lotacao->__get("lot_hor"));
        $register->bindValue(6, $lotacao->__get("lot_int"));
        $register->bindValue(7, $lotacao->__get("lot_qtd"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
      }

    }

    public function remove ($ofr_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_lot WHERE ofr_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $ofr_cod);

        if ($remove->execute())
          return 1;
        
        return 0;
      } catch(Exception $e) {
        //echo "Failed: "  . $e->getMessage();
        return 0;
      }

    }

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
          $lotacao->__set("lot_cod", $lot["lot_cod"]);

          $ofertaDAO = new OfertaDAO();
          $lotacao->__set("ofr_cod", $ofertaDAO->search($lot["ofr_cod"]));

          $professorDAO = new ProfessorDAO();
          $professores = NULL;
          $professores[] = $professorDAO->search($lot["prf_cod"]);

          $lot_qtd = NULL;
          $lot_qtd = $lot["lot_qtd"];

          $sla_codx = NULL;
          $sla_codx[] = $lot["sla_cod"];

          $lot_dia = NULL;
          $hor = "SELECT hor2str(".$lot['lot_hor'].")";
          $searchHor = $dbh->prepare($hor);
          $searchHor->execute();
          $hor = $searchHor->fetch(PDO::FETCH_ASSOC);
          $lot_dia[] = $lot["lot_dia"] . $hor['hor2str'];

          while ($lot2 = $search2->fetch(PDO::FETCH_ASSOC)) {
            $professores[] = $professorDAO->search($lot2["prf_cod"]);

            $hor = "SELECT hor2str(".$lot2['lot_hor'].")";
            $searchHor = $dbh->prepare($hor);
            $searchHor->execute();
            $hor = $searchHor->fetch(PDO::FETCH_ASSOC);
            $lot_dia[] = $lot2["lot_dia"] . $hor['hor2str'];
            $sla_codx[] = $lot2["sla_cod"];
            $lot_qtd += $lot2["lot_qtd"];
          }

          $sla_cod = NULL;
          $salaDAO = new SalaDAO();
          $sla_codx = array_unique($sla_codx);
          foreach ($sla_codx as $codigo)
            $sla_cod[] = $salaDAO->search($codigo);

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
