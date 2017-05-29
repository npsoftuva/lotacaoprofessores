<?php
// @arquivo = /dao/ComponenteDAO.php
// MVC = Controller
// objeto = ComponenteDAO

  require_once('../model/Componente.class.php');
  require_once('../lib/BD.class.php');
  require_once('FluxoDAO.php');
  require_once('DisciplinaDAO.php');
  
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
        
      } catch (Exception $e){
        if ($e->getCode() == '23505')
          return 'ERRO: A componente (fluxo, disciplina) já existe';
      }

      return 'Ocorreu um erro ao tentar adicionar a componente.';

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

      } catch (Exception $e) {
        if ($e->getCode() == '23503')
          return 'ERRO: Componente está sendo usada em alguma oferta';
      }

      return 'Ocorreu um erro ao tentar excluir a componente.';

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
      $componentes = NULL;

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cmp ORDER BY flx_cod, cmp_sem";

        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

        $fluxoDAO = new FluxoDAO();
        $disciplinaDAO = new DisciplinaDAO();

        while ($cmp = $search->fetch(PDO::FETCH_ASSOC)) {
          $componente = new Componente();
          $componente->__set("cmp_sem", $cmp["cmp_sem"]);
          $componente->__set("cmp_hor", $cmp["cmp_hor"]);
          $componente->__set("flx_cod", $fluxoDAO->search($cmp["flx_cod"]));
          $componente->__set("dcp_cod", $disciplinaDAO->search($cmp["dcp_cod"]));
          $componentes[] = $componente;
        }

        return $componentes;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function componenteBySemestre($semestre) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * 
                FROM tab_cmp C
                INNER JOIN tab_dcp D ON D.dcp_cod = C.dcp_cod
                WHERE cmp_sem = ?
                ORDER BY D.dcp_nom";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $semestre);

        if (!$search->execute())
          return 0;

        $componentes = NULL;
        $fluxoDAO = new FluxoDAO();

        while ($cmp = $search->fetch(PDO::FETCH_ASSOC)) {
          $disciplina = new Disciplina();
          $disciplina->__set("dcp_cod", $cmp["dcp_cod"]);
          $disciplina->__set("dcp_nom", $cmp["dcp_nom"]);

          $componente = new Componente();
          $componente->__set("flx_cod", $fluxoDAO->search($cmp["flx_cod"]));
          $componente->__set("dcp_cod", $disciplina);
          $componente->__set("cmp_sem", $cmp["cmp_sem"]);
          $componente->__set("cmp_hor", $cmp["cmp_hor"]);

          $componentes[] = $componente;
        }

        return $componentes;
      } catch(Exception $e) {
        return 0;
      }
    }

  }

?>