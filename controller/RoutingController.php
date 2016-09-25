<?php

namespace controller;

require_once("LoginController.php");
require_once("RegisterController.php");
require_once("model/FlashModel.php");
require_once("model/SessionModel.php");

class RoutingController {

  public function __construct() {
    $this->fm = new \model\FlashModel();
    $this->sm = new \model\SessionModel();

    $isRegisterView = isset($_GET['register']);

    switch ($isRegisterView) {
      case false:
        new LoginController($this->fm);
        break;
      case true:
        new RegisterController();
        break;
    }
  }

}
