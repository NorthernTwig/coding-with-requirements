<?php

namespace controller;

require_once("LoginController.php");
require_once("RegisterController.php");

class RoutingController {

  public function __construct() {

    $isRegisterView = isset($_GET['register']);

    switch ($isRegisterView) {
      case false:
        new LoginController();
        break;
      case true:
        new RegisterController();
        break;
    }
  }

}
