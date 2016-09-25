<?php

namespace controller;

require_once("view/LoginView.php");
require_once("model/UserDatabase.php");
require_once("model/FlashModel.php");
require_once("model/SessionModel.php");

class LoginController {

  public function __construct($flashModel) {
    $this->flashModel = $flashModel;
    $this->lw = new \view\LoginView();

      try {
        if ($this->lw->isLoggingIn()) {
          $this->username = $this->lw->getUsername();
          $this->password = $this->lw->getPassword();
          $this->compareEnteredCredentials();
        } else if ($this->lw->isLoggingOut() && $_SESSION['isLoggedIn']) {
          $_SESSION['isLoggedIn'] = false;
        }
      } catch (\Exception $e) {
        $this->flashModel->setFlashMessage($e->getMessage());
      } finally {
        $this->lw->toLayoutView($this->flashModel);
        if ($_SESSION['isLoggedIn'] && $this->lw->isLoggingIn()) {
          header('Location: /');
          exit();
        }
      }



  }

  private function login() {

  }

  private function getExistingUsers() {
    $udb = new \model\UserDatabase();
    return $udb->superRealDatabase();
  }

  private function compareEnteredCredentials() {

    $existingUsers = $this->getExistingUsers();

    if ($existingUsers['username'] == $this->username && $existingUsers['password'] == $this->password) {
      $_SESSION['isLoggedIn'] = true;
      $this->flashModel->setFlashMessage('Welcome');
    }

  }

}
