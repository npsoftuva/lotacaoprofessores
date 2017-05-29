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

    public function remove ($lot_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_lot WHERE lot_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $lot_cod);

        if ($remove->execute())
          return 1;
        
        return 0;
      } catch(Exception $e) {
        //echo "Failed: "  . $e->getMessage();
        return 0;
      }

    }

    public function update (Lotacao $lotacao) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE  tab_lot
                SET     ofr_cod = ?,
                        prf_cod = ?,
                        sla_cod = ?,
                        lot_dia = ?,
                        lot_hor = ?,
                        lot_int = ?,
                        lot_qtd = ?
                WHERE   lot_cod = ?;

                ";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $lotacao->__get("ofr_cod")->__get("ofr_cod"));
        $update->bindValue(2, $lotacao->__get("prf_cod")->__get("prf_cod"));
        $update->bindValue(3, $lotacao->__get("sla_cod")->__get("sla_cod"));
        $update->bindValue(4, $lotacao->__get("lot_dia"));
        $update->bindValue(5, $lotacao->__get("lot_hor"));
        $update->bindValue(6, $lotacao->__get("lot_int"));
        $update->bindValue(7, $lotacao->__get("lot_qtd"));
        $update->bindValue(8, $lotacao->__get("lot_cod"));

        if($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * 
                FROM tab_lot L
                INNER JOIN tab_ofr O ON L.ofr_cod = O.ofr_cod
                INNER JOIN tab_cmp C ON (O.flx_cod = C.flx_cod AND O.dcp_cod = C.dcp_cod)
                ORDER BY C.cmp_sem";

        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

        $lotacoes = NULL;
        $ofertaDAO = new OfertaDAO();
        $professorDAO = new ProfessorDAO();
        $salaDAO = new SalaDAO();

        while ($aux = $search->fetch(PDO::FETCH_ASSOC)) {
          $lotacao = new Lotacao();
          $lotacao->__set("lot_cod", $aux["lot_cod"]);
          $lotacao->__set("ofr_cod", $ofertaDAO->search($aux["ofr_cod"]));
          $lotacao->__set("prf_cod", $professorDAO->search($aux["prf_cod"]));
          $lotacao->__set("sla_cod", $salaDAO->search($aux["sla_cod"]));
          $lotacao->__set("lot_dia", $aux["lot_dia"]);
          $lotacao->__set("lot_hor", $aux["lot_hor"]);

          $hor = "SELECT hor2str(".$aux['lot_hor'].")";
          $searchHor = $dbh->prepare($hor);
          $searchHor->execute();
          $hor = $searchHor->fetch(PDO::FETCH_ASSOC);

          $lotacao->__set("lot_int", $hor['hor2str']);
          $lotacao->__set("lot_qtd", $aux['lot_qtd']);

          $lotacoes[] = $lotacao;
        }

        return $lotacoes;
      } catch(Exception $e) {
        die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAllReport() {

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

    public function searchClassInRoom($cod_sala) {
      
      try {
        $dbh = Connection::connect();

        $sql = "SELECT L.lot_dia, L.lot_int, D.dcp_nom
                FROM tab_dcp D 
                INNER JOIN tab_ofr O ON D.dcp_cod = O.dcp_cod
                INNER JOIN tab_lot L ON O.ofr_cod = L.ofr_cod
                INNER JOIN tab_sla S ON S.sla_cod = L.sla_cod
                WHERE S.sla_cod = ?
                ORDER BY L.lot_dia";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $cod_sala);
       
        if (!$search->execute())
          return 0;

        $matriz = array(
          'A' => array('', '', '', '', ''),
          'B' => array('', '', '', '', ''),
          'C' => array('', '', '', '', ''),
          'D' => array('', '', '', '', ''),
          'E' => array('', '', '', '', ''),
          'F' => array('', '', '', '', ''),
          'G' => array('', '', '', '', ''),
          'H' => array('', '', '', '', ''),
          'I' => array('', '', '', '', ''),
          'J' => array('', '', '', '', ''),
          'K' => array('', '', '', '', ''),
          'L' => array('', '', '', '', ''),
          'M' => array('', '', '', '', ''),
          'N' => array('', '', '', '', ''),
          'O' => array('', '', '', '', ''),
          'P' => array('', '', '', '', ''),
          'Q' => array('', '', '', '', '')
        );

        while ($class = $search->fetch(PDO::FETCH_ASSOC)) {
          $horario = $class['lot_int'];
          $tam = strlen($horario);
          $dia = $class['lot_dia'] - 1; // diminui o dia da semana em um para ficar igual ao indice do vetor

          for ($i = 0; $i < $tam; $i++) {
            $matriz[ $horario[$i] ][ $dia ] = $class['dcp_nom'];
          }
        }
        
        return $matriz;

      } catch(PDOException $e) {
        die($e->getMessage());
        return 0;
      }
      
    }
    
  }
?>
