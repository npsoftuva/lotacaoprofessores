<?php
// @arquivo = /dao/UsuarioDAO.php
// MVC = controller
// objeto = Usuario

  require_once('../model/Usuario.class.php');
  require_once('../lib/BD.class.php');

	class UsuarioDAO {
    
    public function register(Usuario $usuario) {

      try {
        $dbh = Connection::connect();

        $sql = "INSERT INTO tab_usu (usu_log, usu_sen, usu_tpo) VALUES (?, ?, ?)";

        $register = $dbh->prepare($sql);
				$register->bindValue(1, $usuario->__get("usu_log"));
        $register->bindValue(2, md5($usuario->__get("usu_sen")));
        $register->bindValue(3, $usuario->__get("usu_tpo"));

        if ($register->execute())
          return 1;

        return 0;
      } catch(Exception $e) {
        //echo "Failed: " . $e->getMessage();
        return 0;
      }

    }
    
    public function update(Usuario $usuario) {

      try {
        $dbh = Connection::connect();

        $sql = "UPDATE tab_usu
                SET    usu_log = ?,
                       usu_sen = ?,
                       usu_tpo = ?
                WHERE  usu_cod = ?";

        $update = $dbh->prepare($sql);
        $update->bindValue(1, $usuario->__get("usu_log"));
        $update->bindValue(2, $usuario->__get("usu_sen"));
        $update->bindValue(3, $usuario->__get("usu_tpo"));
        $update->bindValue(4, $usuario->__get("usu_cod"));

        if ($update->execute())
          return 1;

        return 0;
      } catch(Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function remove($usu_cod) {
      
      try {
        $dbh = Connection::connect();

        $sql = "DELETE FROM tab_usu WHERE usu_cod = ?";

        $remove = $dbh->prepare($sql);
        $remove->bindValue(1, $usu_cod);

        if ($remove->execute())
          return 1;
        
        return 0;
      } catch(PDOException $e) {
        //var_dump($e);
        if ($e->getCode() == "P0001")
          echo $e->errorInfo[2];
        
        return 0;
      }
      
    }
    
    public function search($usu_log, $usu_sen) {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_usu WHERE usu_log = ? AND usu_sen = ?";

        $search = $dbh->prepare($sql);
        $search->bindValue(1, $usu_log);
        $search->bindValue(2, md5($usu_sen));
        
        if (!$search->execute() || $search->rowCount() == 0)
          return null;
        
        $user = $search->fetch(PDO::FETCH_ASSOC);
        $aux = new Usuario();
        $aux->setAll($user["usu_cod"], $user["usu_log"], $user["usu_sen"], $user["usu_tpo"]);

        return $aux;
      } catch(Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }

    public function searchAll() {

      try {
        $dbh = Connection::connect();

        $sql = "SELECT * FROM tab_usu";

        $search = $dbh->prepare($sql);
        
        if (!$search->execute())
          return 0;

        while ($user = $search->fetch(PDO::FETCH_ASSOC)) {
          $aux = new Usuario();
          $aux->setAll($user["usu_cod"], $user["usu_log"], $user["usu_sen"], $user["usu_tpo"]);
          $users[] = $aux;
        }

        return $users;
      } catch(Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }

    }
    
    public function newPassword(Usuario $usuario) {
      
      try {
        $dbh = Connection::connect();
        
        $sql = "UPDATE tab_usu SET usu_sen = ? WHERE usu_cod = ?";
        
        $update = $dbh->prepare($sql);
        $update->bindValue(1, md5($usuario->__get("usu_sen")));
        $update->bindValue(2, $usuario->__get("usu_cod"));
       
        if ($update->execute())
          return 1;
        
        return 0;
      } catch(Exception $e) {
        //die("Unable to connect: " . $e->getMessage());
        return 0;
      }
      
    }
    
  }
?>
