<?php
// @arquivo = /dao/CalendarioDAO.php
// MVC = controller
// objeto = Calendario

  require_once('../model/Calendario.class.php');
  require_once('../lib/BD.class.php');

  class CalendarioDAO {

    public function register (Calendario $calendario) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_cld (cld_dta, cld_dia, cld_evt, cld_tpo) VALUES (?, ?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $calendario->__get("cld_dta"));
        $register->bindValue(2, $calendario->__get("cld_dia"));
        $register->bindValue(3, $calendario->__get("cld_evt"));
        $register->bindValue(4, $calendario->__get("cld_tpo"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
      }

    }

    public function update (Calendario $calendario) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_cld
                SET    cld_dia = ?,
                       cld_evt = ?,
                       cld_tpo = ?
                WHERE  cld_dta = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $calendario->__get("cld_dia"));
        $update->bindValue(2, $calendario->__get("cld_evt"));
        $update->bindValue(3, $calendario->__get("cld_tpo"));
        $update->bindValue(4, $calendario->__get("cld_dta"));

        if($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

    public function remove ($cld_dta) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_cld WHERE cld_dta = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $cld_dta);

        if ($remove->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
      }

      return 0;
    }

    public function search($data) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $data);
        $search->execute();

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Calendario();
        $aux->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cld ORDER BY cld_dta";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($cld = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Calendario();
          $aux->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $prf["cld_tpo"]);
          $clds[] = $aux;
        }

        return $clds;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

  }
?>
