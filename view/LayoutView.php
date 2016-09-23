<?php

namespace view;

require_once('DateTimeView.php');

class LayoutView {

  public function __construct(string $form) {
    $this->toOutputBuffer($form, $this->getloginMessage());
  }

  private function toOutputBuffer($form, $loginMessage) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
            <a href="?register">Register a new User</a>
            <h2>' . $loginMessage . '</h2>
          <div class="container">
              ' . $form . '
              ' . $this->getDate() . '
          </div>
         </body>
      </html>
    ';
  }

  private function getDate() {
    $date = new DateTimeView();
    return $date->show();
  }

  private function getLoginMessage() {

    if (isset($_SESSION['loggedIn'])) {
      if ($_SESSION['loggedIn']) {
        return 'Logged in';
      } else {
        return 'Not logged in';
      }
    }

  }

  // private function ()
  //
  //
  // //
  // // private function renderIsLoggedIn($isLoggedIn) {
  //   if ($isLoggedIn) {
  //     return '<h2>Logged in</h2>';
  //   }
  //   else {
  //     return '<h2>Not logged in</h2>';
  //   }
  // }
  //
  // private function isLoggedOutOrRegistration($place, $isLoggedIn) {
  //   if ($place) {
  //     return '<a href="?">Back to login</a>';
  //   } else {
  //     if (!$isLoggedIn) {
  //       return '<a href="?register">Register a new user</a>';
  //     }
  //   }
  // }

}
