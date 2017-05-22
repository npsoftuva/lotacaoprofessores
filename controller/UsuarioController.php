<?php
// @arquivo = /controller/UsuarioController.php
// MVC = controller
// objeto = Usuario

require_once('../dao/UsuarioDAO.php');

class UsuarioController {

  public function register(Usuario $usuario) {
    $usuarioDAO = new UsuarioDAO();
    return $usuarioDAO->register($usuario);
  }

  public function update(Usuario $usuario) {
    $usuarioDAO = new UsuarioDAO();
    return $usuarioDAO->update($usuario);
  }

  public function remove($usu_cod) {
    $usuarioDAO = new UsuarioDAO();
    return $usuarioDAO->remove($usu_cod);
  }

  public function search($usu_log, $usu_sen) {
    $usuarioDAO = new UsuarioDAO();
    $user = $usuarioDAO->search($usu_log);
    if (isset($user) and password_verify($usu_sen, $user->__get("usu_sen")))
      return $user;
    return null;
  }

  public function searchAll() {
    $usuarioDAO = new UsuarioDAO();
    return $usuarioDAO->searchAll();
  }
  
  public function newPassword(Usuario $usuario) {
    $usuarioDAO = new UsuarioDAO();
    return $usuarioDAO->newPassword($usuario);
  }
}
?>