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

        $sql = "UPDATE tab_cld
                SET    cld_evt = ?,
                       cld_tpo = ?
                WHERE  cld_dta = ?";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $calendario->__get("cld_evt"));
        $register->bindValue(2, $calendario->__get("cld_tpo"));
        $register->bindValue(3, $calendario->__get("cld_dta"));

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
                SET    cld_evt = ?,
                       cld_tpo = ?
                WHERE  cld_dta = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $calendario->__get("cld_evt"));
        $update->bindValue(2, $calendario->__get("cld_tpo"));
        $update->bindValue(3, $calendario->__get("cld_dta"));

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

        $sql = "UPDATE tab_cld
                SET    cld_evt = ?,
                       cld_tpo = ?
                WHERE  cld_dta = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, "");
        $remove->bindValue(2, 2);
        $remove->bindValue(3, $cld_dta);

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

        $sql = "SELECT * FROM tab_cld WHERE cld_tpo <> '2' ORDER BY cld_dta";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($cld = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Calendario();
          $aux->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);
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
