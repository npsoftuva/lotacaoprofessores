<?php
// @arquivo = /dao/PeriodoDAO.php
// MVC = controller
// objeto = Periodo

  require_once('../model/Periodo.class.php');
  require_once('../lib/BD.class.php');

  class PeriodoDAO {
    
    public function register (Periodo $periodo) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_prd (prd_cod, prd_ini, prd_fim) VALUES (?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $periodo->__get("prd_cod"));
        $register->bindValue(2, $periodo->__get("prd_ini")->__get("cld_dta"));
        $register->bindValue(3, $periodo->__get("prd_fim")->__get("cld_dta"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
        return 0;
      }

    }
    
    public function update (Periodo $periodo) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_prd
                SET    prd_ini = ?,
                       prd_fim = ?
                WHERE  prd_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $periodo->__get("prd_ini")->__get("cld_dta"));
        $update->bindValue(2, $periodo->__get("prd_fim")->__get("cld_dta"));
        $update->bindValue(3, $periodo->__get("prd_cod"));

        if ($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function remove ($prd_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_prd WHERE prd_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $prd_cod);

        if ($remove->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

      return 0;
    }

    public function search($prd_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_prd WHERE prd_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $prd_cod);
        $search->execute();

        // Inicia o objeto Periodo
        $per = $search->fetch(PDO::FETCH_ASSOC);
        $periodo = new Periodo();
        $periodo->__set("prd_cod", $per["prd_cod"]); //$per["prd_ini"], $per["prd_fim"]);

        // Seta o objeto Calendario em PRD_INI
        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $per["prd_ini"]);
        $search->execute();

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $prd_ini = new Calendario();
        $prd_ini->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
        $periodo->__set("prd_ini", $prd_ini);

        // Seta o objeto Calendario em PRD_FIM
        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $per["prd_fim"]);
        $search->execute();

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $prd_fim = new Calendario();
        $prd_fim->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
        $periodo->__set("prd_fim", $prd_fim);

        return $periodo;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {
      $periodos = NULL;

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_prd ORDER BY prd_cod DESC";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($per = $search->fetch(PDO::FETCH_ASSOC)) {
          $periodo = new Periodo();
          $periodo->__set("prd_cod", $per["prd_cod"]);

          // Seta o objeto Calendario em PRD_INI
          $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
          $searchCalendario = $dbh->prepare($sql);
          $searchCalendario->bindValue(1, $per["prd_ini"]);
          $searchCalendario->execute();

          $cld = $searchCalendario->fetch(PDO::FETCH_ASSOC);
          $prd_ini = new Calendario();
          $prd_ini->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
          $periodo->__set("prd_ini", $prd_ini);

          // Seta o objeto Calendario em PRD_FIM
          $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
          $searchCalendario = $dbh->prepare($sql);
          $searchCalendario->bindValue(1, $per["prd_fim"]);
          $searchCalendario->execute();

          $cld = $searchCalendario->fetch(PDO::FETCH_ASSOC);
          $prd_fim = new Calendario();
          $prd_fim->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
          $periodo->__set("prd_fim", $prd_fim);
          $periodos[] = $periodo;
        }

        return $periodos;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchLastCod() {
      
      try {
        $dbh = Connection::connect();

        $sql = "SELECT * 
                FROM   tab_prd
                WHERE  prd_cod = (SELECT MAX(prd_cod) FROM tab_prd)";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        // Inicia o objeto Periodo
        $per = $search->fetch(PDO::FETCH_ASSOC);
        $periodo = new Periodo();
        $periodo->__set("prd_cod", $per["prd_cod"]);

        // Seta o objeto Calendario em PRD_INI
        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $per["prd_ini"]);
        
        if (!$search->execute())
          return 0;

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $prd_ini = new Calendario();
        $prd_ini->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
        $periodo->__set("prd_ini", $prd_ini);

        // Seta o objeto Calendario em PRD_FIM
        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $per["prd_fim"]);
        
        if (!$search->execute())
          return 0;

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $prd_fim = new Calendario();
        $prd_fim->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
        $periodo->__set("prd_fim", $prd_fim);

        return $periodo;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }
      
    }
  }
?>
