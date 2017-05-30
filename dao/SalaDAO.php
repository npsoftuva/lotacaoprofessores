<?php
// @arquivo = /dao/SalaDAO.php
// MVC = controller
// objeto = Sala

  require_once('../model/Sala.class.php');
  require_once('../lib/BD.class.php');

	class SalaDAO {
    
    public function register (Sala $sala) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_sla (sla_cod, sla_nom, sla_cap) VALUES (?, ?, ?)";

        $register = $dbh->prepare($sql);
				$register->bindValue(1, $sala->__get("sla_cod"));
        $register->bindValue(2, $sala->__get("sla_nom"));
        $register->bindValue(3, $sala->__get("sla_cap"));

        if ($register->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

    }
    
    public function update (Sala $sala) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_sla
                SET    sla_nom = ?,
                       sla_cap = ?
                WHERE  sla_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $sala->__get("sla_nom"));
        $update->bindValue(2, $sala->__get("sla_cap"));
        $update->bindValue(3, $sala->__get("sla_cod"));

        if ($update->execute())
          return 1;

        return 0;
      } catch (Exception $e) {
        if ($e->getCode() == 'P0001')
          return $e->errorInfo[2];
      }

      return 'Ocorreu um erro ao tentar editar a sala.';

    }
    
    public function remove ($sla_cod) {
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_sla WHERE sla_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $sla_cod);

        if ($remove->execute())
          return 1;

      } catch (Exception $e) {
        if ($e->getCode() == '23503')
          return 'ERRO: Sala está sendo usada em alguma lotação';
      }

      return 'Ocorreu um erro ao tentar excluir a sala.';

    }

    public function search($sla_cod) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_sla WHERE sla_cod = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $sla_cod);
        $search->execute();

        $sla = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Sala();
        $aux->setAll($sla["sla_cod"], $sla["sla_nom"], $sla["sla_cap"]);

        return $aux;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_sla ORDER BY sla_nom";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($sla = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Sala();
          $aux->setAll($sla["sla_cod"], $sla["sla_nom"], $sla["sla_cap"]);
          $slas[] = $aux;
        }

        return $slas;
      } catch (Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
  }
?>
