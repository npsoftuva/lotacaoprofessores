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
        return 0;
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
        return 0;
      }

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
        return 0;
      }

    }

    public function search($cld_dta) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cld WHERE cld_dta = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $cld_dta);
        
        if (!$search->execute())
          return 0;

        $cld = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Calendario();
        $aux->setAll($cld["cld_dta"], $cld["cld_dia"], $cld["cld_evt"], $cld["cld_tpo"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {
      $clds = NULL;

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cld WHERE cld_tpo <> 2";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;
        
        while ($cld = $search->fetch(PDO::FETCH_ASSOC)) {
          $cor = ($cld["cld_tpo"] == 1) ? '#378006' : '#9e0b0b';
          
          $aux = array(
            'title' => $cld["cld_evt"],
            'start' => $cld["cld_dta"],
            'type' => $cld["cld_tpo"],
            'color' => $cor);

          $clds[] = $aux;
        }

        return json_encode($clds);
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchMinDate() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT MIN(cld_dta) as cld_dta FROM tab_cld";

        $search = $dbh->prepare($sql);        
        
        if (!$search->execute())
          return 0;

        $data = $search->fetch(PDO::FETCH_ASSOC);

        return $data['cld_dta'];
      } catch(Exception $e) {
        return 0;
      }
    }
  }
?>
