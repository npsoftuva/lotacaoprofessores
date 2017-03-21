<?php
// @arquivo = /dao/ProfessorDAO.php
// MVC = controller
// objeto = Professor

  require_once('../model/Professor.class.php');
  require_once('../lib/BD.class.php');

  class ProfessorDAO {

    public function register (Professor $professor) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_prf (prf_cpf, prf_nom, prf_eml, prf_sit) VALUES (?, ?, ?, 1)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $professor->__get("prf_cpf"));
        $register->bindValue(2, strtoupper($professor->__get("prf_nom")));
        $register->bindValue(3, $professor->__get("prf_eml"));

        if ($register->execute())
          return 1;

        return 0;
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
        $update->bindValue(1, strtoupper($professor->__get("prf_nom")));
        $update->bindValue(2, $professor->__get("prf_cpf"));
        $update->bindValue(3, $professor->__get("prf_eml"));
        $update->bindValue(4, $professor->__get("prf_sit"));
        $update->bindValue(5, $professor->__get("prf_cod"));

        if($update->execute())
          return 1;

        return 0;
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

        if ($remove->execute())
          return 1;

        return 0;
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

        if (!$search->execute())
          return 0;

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

        $sql = "SELECT * FROM tab_prf ORDER BY prf_nom";

        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

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
