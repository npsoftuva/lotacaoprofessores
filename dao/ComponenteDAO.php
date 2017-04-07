<?php
// @arquivo = /dao/ComponenteDAO.php
// MVC = Controller
// objeto = ComponenteDAO

  require_once('../model/Componente.class.php');
  require_once('../lib/BD.class.php');
  
  class ComponenteDAO {
    
    public function register (Componente $componente) {
      
      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_cmp (flx_cod, dcp_cod, cmp_sem, cmp_hor) VALUES (?, ?, ?, ?)";
                
        $register = $dbh->prepare($sql);
        $register->bindValue(1, $componente->__get("flx_cod")->__get("flx_cod"));
        $register->bindValue(2, $componente->__get("dcp_cod")->__get("dcp_cod"));
        $register->bindValue(3, $componente->__get("cmp_sem"));
        $register->bindValue(4, $componente->__get("cmp_hor"));        
        
        if ($register->execute())
          return 1;
        
        return 0;
      } catch (Exception $e){
        //echo "Failed: " . $e->getMessage();
        return 0;
      }   
    } 
    
    public function update (Componente $componente) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_cmp
                SET    cmp_sem = ?,
                       cmp_hor = ?
                WHERE  flx_cod = ? AND dcp_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $componente->__get("cmp_sem"));
        $update->bindValue(2, $componente->__get("cmp_hor"));
        $update->bindValue(3, $componente->__get("flx_cod")->__get("flx_cod"));
        $update->bindValue(4, $componente->__get("dcp_cod")->__get("dcp_cod"));

        if($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function remove ($flx_cod, $dcp_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_cmp WHERE flx_cod = ? AND dcp_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $flx_cod);
        $remove->bindValue(2, $dcp_cod);

        if ($remove->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

    }
    
    public function search($flx_cod, $dcp_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cmp WHERE flx_cod = ? AND dcp_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $flx_cod);
        $search->bindValue(2, $dcp_cod);

        if (!$search->execute())
          return 0;

        // Inicia o objeto componente
        $cmp = $search->fetch(PDO::FETCH_ASSOC);
        $componente = new Componente();
        $componente->__set("cmp_sem", $cmp["cmp_sem"]);
        $componente->__set("cmp_hor", $cmp["cmp_hor"]);

        // Seta o objeto Fluxo em FLX_COD
        $sql = "SELECT * FROM tab_flx WHERE flx_cod = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $cmp["flx_cod"]);
        
        if (!$search->execute())
          return 0;

        $flx = $search->fetch(PDO::FETCH_ASSOC);
        $flx_cod = new Fluxo();
        $flx_cod->setAll($flx["flx_cod"], $flx["flx_trn"], $flx["flx_sem"]);
        $componente->__set("flx_cod", $flx_cod);
        
        // Seta o objeto Disciplina em DCP_COD
        $sql = "SELECT * FROM tab_dcp WHERE dcp_cod = ?";
        $search = $dbh->prepare($sql);
        $search->bindValue(1, $cmp["dcp_cod"]);
        
        if (!$search->execute())
          return 0;

        $dcp = $search->fetch(PDO::FETCH_ASSOC);
        $dcp_cod = new Disciplina();
        $dcp_cod->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
        $componente->__set("dcp_cod", $dcp_cod);
        
        return $componente;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cmp ORDER BY flx_cod, dcp_cod";

        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

        while ($cmp = $search->fetch(PDO::FETCH_ASSOC)) {
          $componente = new Componente();
          $componente->__set("cmp_sem", $cmp["cmp_sem"]);
          $componente->__set("cmp_hor", $cmp["cmp_hor"]);

          // Seta o objeto Fluxo em FLX_COD
          $sql = "SELECT * FROM tab_flx WHERE flx_cod = ?";
          $search2 = $dbh->prepare($sql);
          $search2->bindValue(1, $cmp["flx_cod"]);

          if (!$search2->execute())
            return 0;

          $flx = $search2->fetch(PDO::FETCH_ASSOC);
          $flx_cod = new Fluxo();
          $flx_cod->setAll($flx["flx_cod"], $flx["flx_trn"], $flx["flx_sem"]);
          $componente->__set("flx_cod", $flx_cod);

          // Seta o objeto Disciplina em DCP_COD
          $sql = "SELECT * FROM tab_dcp WHERE dcp_cod = ?";
          $search2 = $dbh->prepare($sql);
          $search2->bindValue(1, $cmp["dcp_cod"]);

          if (!$search2->execute())
            return 0;

          $dcp = $search2->fetch(PDO::FETCH_ASSOC);
          $dcp_cod = new Disciplina();
          $dcp_cod->setAll($dcp["dcp_cod"], $dcp["dcp_nom"]);
          $componente->__set("dcp_cod", $dcp_cod);
          $componentes[] = $componente;
        }

        return $componentes;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function searchDisciplinas($flx_cod, $cmp_sem) {
      
      try {
        $dbh = Connection::connect();

        $sql = "SELECT dcp_cod FROM tab_cmp WHERE flx_cod = ? AND cmp_sem = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $flx_cod);
        $search->bindValue(2, $cmp_sem);

        if (!$search->execute())
          return 0;

        $disciplinas = null;
        
        while ($dcp = $search->fetch(PDO::FETCH_ASSOC)) {
          $disciplina = new Disciplina();
          $disciplina->__set("dcp_cod", $dcp["dcp_cod"]);

          // Seta o nome da disciplina em $disciplina
          $sql = "SELECT dcp_nom FROM tab_dcp WHERE dcp_cod = ?";
          $searchAux = $dbh->prepare($sql);
          $searchAux->bindValue(1, $dcp["dcp_cod"]);

          if (!$searchAux->execute())
            return 0;

          $dcp_nom = $searchAux->fetch(PDO::FETCH_ASSOC);
          $disciplina->__set("dcp_nom", $dcp_nom["dcp_nom"]);
          $disciplinas[] = $disciplina;
        }
        
        return $disciplinas;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }
      
    }
  }

?>