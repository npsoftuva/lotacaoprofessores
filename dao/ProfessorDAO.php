<?php
// @arquivo = /dao/ProfessorDAO.php
// MVC = controller
// objeto = Professor

  require_once($_SERVER['DOCUMENT_ROOT'] . '/model/Professor.class.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/BD.class.php');

  class ProfessorDAO {

    public function register (Professor $professor) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_prf (prf_cod, prf_nom, prf_cpf, prf_eml, prf_sit) VALUES (NULL, ?, ?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $professor->__get("prf_nom"));
        $register->bindValue(2, $professor->__get("prf_cpf"));
        $register->bindValue(3, $professor->__get("prf_eml"));
        $register->bindValue(4, $professor->__get("prf_sit"));
        $register->execute();

        return 1;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
      }

    }

    public function update (Professor $professor) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_prf
                SET    prf_nom = ?,
                       prf_cpf = ?,
                       prf_eml = ?,
                       prf_sit = ?
                WHERE  prf_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $professor->__get("prf_nom"));
        $update->bindValue(2, $professor->__get("prf_cpf"));
        $update->bindValue(3, $professor->__get("prf_eml"));
        $update->bindValue(4, $professor->__get("prf_sit"));
        $update->bindValue(5, $professor->__get("prf_cod"));
        $update->execute();

        return 1;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

    public function remove ($prf_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_prf WHERE prf_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $prf_cod);
        $remove->execute();

        return 1;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
      }

      return 0;
    }

    public function search($id) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_prf WHERE prf_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $id);
        $search->execute();

        $prf = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Professor();
        $aux->setAll($prf["prf_cod"], $prf["prf_nom"], $prf["prf_cpf"], $prf["prf_eml"], $prf["prf_sit"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

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
