<?php

class LayoutView {

  public function render($isLoggedIn, $v, DateTimeView $dtv, $sessionBefore, $setCookies, $place) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->isLoggedOutOrRegistration($place, $isLoggedIn) . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $v->response($sessionBefore, $setCookies) . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function isLoggedOutOrRegistration($place, $isLoggedIn) {
    if ($place) {
      return '<a href="?">Back to login</a>';
    } else {
      if (!$isLoggedIn) {
        return '<a href="?register">Register a new user</a>';
      }
    }
  }

}
