<?php
// @arquivo = /dao/OfertaDAO.php
// MVC = controller
// objeto = Oferta

  require_once('../model/Oferta.class.php');
  require_once('../lib/BD.class.php');

	class SalaDAO {
    
    public function register (Oferta $oferta) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_ofr (prd_cod, flx_cod, dcp_cod, ofr_trm, ofr_vag) VALUES (?, ?, ?, ?, ?)";

        $register = $dbh->prepare($sql);
        $register->bindValue(1, $oferta->__get("prd_cod"));
        $register->bindValue(2, $oferta->__get("flx_cod"));
        $register->bindValue(3, $oferta->__get("dcp_cod"));
        $register->bindValue(4, $oferta->__get("ofr_trm"));
        $register->bindValue(5, $oferta->__get("ofr_vag"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
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
        $update->bindValue(1, $sala->__get("prd_cod"));
        $update->bindValue(2, $sala->__get("flx_cod"));
        $update->bindValue(3, $sala->__get("dcp_cod"));
        $update->bindValue(4, $sala->__get("ofr_trm"));
        $update->bindValue(5, $sala->__get("ofr_vag"));
        $update->bindValue(6, $sala->__get("ofr_cod"));

        if ($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }
    
    public function remove ($ofr_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_ofr WHERE ofr_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $ofr_cod);

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

        $sql = "SELECT * FROM tab_ofr WHERE ofr_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $id);
        
        if (!$search->execute())
          return 0;

        $ofr = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Oferta();
        $aux->setAll($sla["ofr_cod"], $sla["prd_cod"], $sla["flx_cod"], $sla["dcp_cod"], $sla["ofr_trm"], $sla["ofr_vag"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_ofr"; //falta ordenar

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($ofr = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Oferta();
          $aux->setAll($sla["ofr_cod"], $sla["prd_cod"], $sla["flx_cod"], $sla["dcp_cod"], $sla["ofr_trm"], $sla["ofr_vag"]);
          $ofrs[] = $aux;
        }

        return $ofrs;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }
  }
?>
