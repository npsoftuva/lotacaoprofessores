<?php

  if (!isset($_SESSION))
    session_start();

  if (!isset($_SESSION['usuarioLog'])) {
    session_destroy();
    header('Location: login.php');
  }

?>