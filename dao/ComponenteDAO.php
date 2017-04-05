<?php
// @arquivo = /dao/ComponenteDAO.php
// MVC = Controller
// objeto = ComponenteDAO

  require_once('../model/Componente.class.php');
  require_once('../lib/BD.class.php');
	
	
  class ComponenteDAO {
		
    public function register (Componente $componente, $flx_cod, $dcp_cod) {
		  
			try {
			  $dbh = Connection::connect();
				////???????
				$sql = "INSERT INTO tab_cmp (flx_cod, dcp_cod, cmp_sem, cmp_hor) VALUES (?,?,?,?)";
				
				////??????
				$register = $dbh->prepare($sql);
				$register->bindValue(1, $flx_cod);
				$register->bindValue(2, $dcp_cod);
				$register->bindValue(3, $componente->__get("cmp_sem"));
				$register->bindValue(4, $componente->__get("cmp_hor"));
				
				if ($register->execute())
					return 1;
				
				return 0;
			} catch (Exception $e){
				//echo "Failed: " . $e->getMessage();
			}		
    }	
		
		public function update (Componente $componente) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_cmp
                SET    cmp_sem = ?,
                       cmp_hor = ?
                WHERE  flx_cod = ? and dcp_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $componente->__get("cmp_sem"));
        $update->bindValue(2, $componente->__get("cmp_hor"));
        $update->bindValue(3, $componente->__get("flx_cod"));
        $update->bindValue(4, $componente->__get("dcp_cod"));
        

        if($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }
		
		public function remove ($flx_cod, $dcp_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_cmp WHERE flx_cod = ? and dcp_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $flx_cod);
				$remove->bindValue(2, $dcp_cod);

        if ($remove->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
      }

      return 0;
    }
		
		
		public function search($flx_cod, $dcp_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cmp WHERE flx_cod = ? and dcp_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $flx_cod);
				$search->bindValue(2, $dcp_cod);

        if (!$search->execute())
          return 0;

        $cmp = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Componente();
        $aux->setAll($cmp["flx_cod"], $cmp["dcp_cod"], $cmp["cmp_sem"], $cmp["cmp_hor"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
      }

      return 0;
    }
		
		public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_cmp";

        $search = $dbh->prepare($sql);

        if (!$search->execute())
          return 0;

        while ($cmp = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Componente();
          $aux->setAll($cmp["flx_cod"], $cmp["dcp_cod"], $cmp["cmp_sem"], $cmp["cmp_hor"]);
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
