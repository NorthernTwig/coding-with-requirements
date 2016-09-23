<?php

namespace controller;

require_once("view/LoginView.php");
require_once("model/UserDatabase.php");

class LoginController {

  public function __construct() {

    $lv = new \view\LoginView();

    if ($lv->isLoggingIn()) {
      $this->username = $lv->getUsername();
      $this->password = $lv->getPassword();
      $this->compareEnteredCredentials();
      header('Location: /');
    }

    $lv->toLayoutView();
  }

  private function getExistingUsers() {
    $udb = new \model\UserDatabase();
    return $udb->superRealDatabase();
  }

  private function compareEnteredCredentials() {

    $existingUsers = $this->getExistingUsers();

    if ($existingUsers['username'] == $this->username && $existingUsers['password'] == $this->password) {
      $_SESSION["loggedIn"] = true;
    }

  }

}
