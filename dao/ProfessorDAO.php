<?php
// @arquivo = /dao/ProfessorDAO.php
// MVC = controller
// objeto = Professor

  require_once($_SERVER['DOCUMENT_ROOT'] . '/model/Professor.class.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/BD.class.php');

  class ProfessorDAO {

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_prf";

        $search = $dbh->prepare($sql);
        $search->execute();

        while ($prf = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Professor();
          $aux->setAll($prf["prf_cod"], $prf["prf_nom"], $prf["prf_cpf"], $prf["prf_eml"], $prf["prf_sit"]);
          $prfs[] = $aux;
        }

        return $prfs;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

  }
?>
