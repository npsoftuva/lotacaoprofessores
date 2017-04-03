<?php
// @arquivo = /lib/Connection.php
// MVC = controller
// objeto = Connection
class Connection {
  public static function connect () {
    $dbh = new PDO("pgsql:host=localhost;port=5432;dbname=lotacao", 'postgres', '123456', 
          array(PDO::ATTR_PERSISTENT => true));
    return $dbh;
  }
}
/*
header('Content-Type: text/html; charset=utf-8');
  class Conexao {
    public static $instance;
    public static function getInstance() {
      if (!isset(self::$instance)) {
        $dbname = "lotacao";
        $host = "localhost";
        $dbuser = "postgres";
        $dbpass = "";
        self::$instance = new PDO("pgsql:host=localhost;port=5432;dbname=lotacao", 'postgres', '123');
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
      }
      return self::$instance;
    }
  }
*/
?>
