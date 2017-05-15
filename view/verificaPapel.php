<?php

  if (isset($_SESSION) and $_SESSION['usuarioTpo'] == 1) {
		header('Location: index.php');
	}
	
?>