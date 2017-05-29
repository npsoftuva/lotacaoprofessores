<?php
// @arquivo = /dao/OfertaDAO.php
// MVC = controller
// objeto = Oferta

  require_once('../model/Oferta.class.php');
  require_once('../lib/BD.class.php');
  require_once('PeriodoDAO.php');
  require_once('ComponenteDAO.php');

	class OfertaDAO {
    
    public function register (Oferta $oferta) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_ofr (prd_cod, flx_cod, dcp_cod, ofr_trm, ofr_vag) VALUES (?, ?, ?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $oferta->__get("prd_cod")->__get("prd_cod"));
        $register->bindValue(2, $oferta->__get("cmp")->__get("flx_cod")->__get("flx_cod"));
        $register->bindValue(3, $oferta->__get("cmp")->__get("dcp_cod")->__get("dcp_cod"));
        $register->bindValue(4, $oferta->__get("ofr_trm"));
        $register->bindValue(5, $oferta->__get("ofr_vag"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

    }
    
    public function update (Oferta $oferta) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_ofr
                SET    prd_cod = ?,
                       flx_cod = ?,
                       dcp_cod = ?,
                       ofr_trm = ?,
                       ofr_vag = ?
                WHERE  ofr_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $oferta->__get("prd_cod")->__get("prd_cod"));
        $update->bindValue(2, $oferta->__get("cmp")->__get("flx_cod")->__get("flx_cod"));
        $update->bindValue(3, $oferta->__get("cmp")->__get("dcp_cod")->__get("dcp_cod"));
        $update->bindValue(4, $oferta->__get("ofr_trm"));
        $update->bindValue(5, $oferta->__get("ofr_vag"));
        $update->bindValue(6, $oferta->__get("ofr_cod"));

        if ($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }
      
    }
    
    public function remove ($ofr_cod) {
      
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_ofr WHERE ofr_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $ofr_cod);

        if ($remove->execute())
          return 1;
        
      } catch (Exception $e) {
        if ($e->getCode() == '23503')
          return 'ERRO: Oferta está sendo usada em alguma lotação';
      }

      return 'Ocorreu um erro ao tentar excluir a oferta.';

    }

    public function search($ofr_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_ofr WHERE ofr_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $ofr_cod);
        
        if (!$search->execute())
          return 0;

        $ofr = $search->fetch(PDO::FETCH_ASSOC);

          $oferta = new Oferta();
          $oferta->__set("ofr_cod", $ofr["ofr_cod"]);
          $oferta->__set("ofr_trm", $ofr["ofr_trm"]);
          $oferta->__set("ofr_vag", $ofr["ofr_vag"]);
          
          // Seta o objeto Período em PRD_COD
          $sql = "SELECT * FROM tab_prd WHERE prd_cod = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $ofr["prd_cod"]);
          
          if (!$searchAux->execute())
            return 0;

          $per = $searchAux->fetch(PDO::FETCH_ASSOC);
          $periodo = new Periodo();
          $periodo->__set("prd_cod", $per["prd_cod"]);

          // Seta o objeto Calendario em PRD_INI
          $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $per["prd_ini"]);
          
          if (!$searchAux->execute())
            return 0;

          $cld = $searchAux->fetch(PDO::FETCH_ASSOC);
          $prd_ini = new Calendario();
          $prd_ini->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
          $periodo->__set("prd_ini", $prd_ini);

          // Seta o objeto Calendario em PRD_FIM
          $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $per["prd_fim"]);
          
          if (!$searchAux->execute())
            return 0;

          $cld = $searchAux->fetch(PDO::FETCH_ASSOC);
          $prd_fim = new Calendario();
          $prd_fim->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
          $periodo->__set("prd_fim", $prd_fim);
          $oferta->__set("prd_cod", $periodo);
          
          // Seta o objeto Componente em CMP
          $sql = "SELECT * FROM tab_cmp WHERE flx_cod = ? AND dcp_cod = ?";
          $searchAux = $dbh->prepare($sql);          
          $searchAux->bindValue(1, $ofr["flx_cod"]);
          $searchAux->bindValue(2, $ofr["dcp_cod"]);
          
          if (!$searchAux->execute())
            return 0;
          
          $cmp = $searchAux->fetch(PDO::FETCH_ASSOC);
          $componente = new Componente();
          $componente->__set("cmp_sem", $cmp["cmp_sem"]);
          $componente->__set("cmp_hor", $cmp["cmp_hor"]);

          // Seta o objeto Fluxo em COD_FLX
          $sql = "SELECT * FROM tab_flx WHERE flx_cod = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $cmp["flx_cod"]);

          if (!$searchAux->execute())
            return 0;

          $flx = $searchAux->fetch(PDO::FETCH_ASSOC);
          $fluxo = new Fluxo();
          $fluxo->setAll($flx["flx_cod"], $flx["flx_trn"], $flx["flx_sem"]);        
          $componente->__set("flx_cod", $fluxo);

          // Seta o objeto Disciplina em DCP_COD
          $sql = "SELECT * FROM tab_dcp WHERE dcp_cod = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $cmp["dcp_cod"]);

          if (!$searchAux->execute())
            return 0;

          $dcp = $searchAux->fetch(PDO::FETCH_ASSOC);
          $disciplina = new Disciplina();
          $disciplina->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
          $componente->__set("dcp_cod", $disciplina);
          $oferta->__set("cmp", $componente);
        
        return $oferta;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {
      $ofertas = NULL;

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_ofr ORDER BY flx_cod, prd_cod";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        $periodoDAO = new PeriodoDAO();
        $componenteDAO = new ComponenteDAO();

        while ($ofr = $search->fetch(PDO::FETCH_ASSOC)) {
          $oferta = new Oferta();
          $oferta->__set("ofr_cod", $ofr["ofr_cod"]);
          $oferta->__set("ofr_trm", $ofr["ofr_trm"]);
          $oferta->__set("ofr_vag", $ofr["ofr_vag"]);
          $oferta->__set("prd_cod", $periodoDAO->search($ofr["prd_cod"]));
          $oferta->__set("cmp", $componenteDAO->search($ofr["flx_cod"], $ofr["dcp_cod"]));
          
          $ofertas[] = $oferta;
        }

        return $ofertas;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function gerarFrequencia ($ofr_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT gerarfrequencia(?)";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $ofr_cod);

        if (!$search->execute())
          return 0;

        $frequencia = NULL;
        while ($freq = $search->fetch(PDO::FETCH_ASSOC))
          $frequencia[] = $freq;

        return $frequencia;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

    }

  }
?>
