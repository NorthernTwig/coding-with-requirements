<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $hasAlreadyLoggedIn = true;
	private static $hasCookies = "LoginView::Cookies";
	private static $message = '';


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($sessionBefore, $setCookies) {
		self::$hasAlreadyLoggedIn = $sessionBefore;

		$this->credentialChecker();

		$response = $this->generateLoginFormHTML(self::$message);
		if (isset($_SESSION["loggedIn"])) {
			if ($_SESSION["loggedIn"]) {
				$response = $this->generateLogoutButtonHTML(self::$message);
			}
		}

		return $response;

	}


	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function superRealDatabase() {
		$credentials = array("username" => "Admin", "password" => "Password");
		return $credentials;
	}

	private function getRequestUserName() {
		$username = "";

		if (isset($_POST[self::$name])) {
			$username = $_POST[self::$name];
		}

		return $username;

	}

	public function getThings() {
		$loggedBefore = false;
		if (isset($_SESSION["loggedIn"])) {
			$loggedBefore = $_SESSION["loggedIn"];
		}
		return $loggedBefore;
	}

	public function checkCookies() {

		$hasTheRightCookies = false;

		if (isset($_COOKIE["Username"]) && isset($_COOKIE["Password"])) {
			$hasTheRightCookies = true;
		}

		return $hasTheRightCookies;

	}

	private function checkUsername() {
		$hasUsername = false;

		if (isset($_POST[self::$name])) {
			if (strlen($_POST[self::$name])) {
				$hasUsername = true;
			}
		}

		return $hasUsername;
	}

	private function checkPassword() {
		$hasPassword = false;

		if (isset($_POST[self::$password])) {
			if (strlen($_POST[self::$password]) > 0) {
				$hasPassword = true;
			}
		}

		return $hasPassword;

	}

	public function isLoggedIn($rightCookies) {
		$status = false;

		if ($rightCookies) {
			$this->compareDatabase();
		} else if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
			$this->compareDatabase();
		}

		if (isset($_SESSION["loggedIn"])) {
			$status = $_SESSION["loggedIn"];
		}

		if (isset($_POST[self::$logout])) {
			$status = false;
		}

		return $status;

	}

	private function setCookie($username, $password) {
		setcookie("Username", $username, time()+36000, NULL, NULL, NULL, true);
		setcookie("Password", $password, time()+36000, NULL, NULL, NULL, true);
	}

	private function unsetCookie() {
		setcookie("Username", NULL, time()-1);
		setcookie("Password", NULL, time()-1);
	}

	private function waitForSetting() {
		return self::$hasAlreadyLoggedIn;
	}

	public function compareDatabase() {

		if (isset($_COOKIE["Username"])) {
			$username = $_COOKIE["Username"];
			$password = $_COOKIE["Password"];
		} else {
			$username = $_POST[self::$name];
			$password = $_POST[self::$password];
		}

			if ($this->superRealDatabase()["username"] == $username && $this->superRealDatabase()["password"] == $password) {

				if (!self::$hasAlreadyLoggedIn) {

					if (isset($_POST[self::$keep]) && $_POST[self::$keep] == "on") {
						$this->setCookie($username, $password);
					}

					if (isset($_POST[self::$keep])) {
						self::$message = "Welcome and you will be remembered";
					} else if ($this->checkCookies()) {
						self::$message = "Welcome back with cookie";
					} else {
						self::$message = "Welcome";
					}

				}

				$_SESSION["loggedIn"] = true;
				} else {
					self::$message = "Wrong name or password";
				}

	}

	private function credentialChecker() {

  		if (isset($_POST[self::$logout]) || isset($_POST[self::$cookieName])) {
          	$_SESSION["loggedIn"] = false;
						if (self::$hasAlreadyLoggedIn) {
							$this->unsetCookie();
							self::$message = "Bye bye!";
						}
						return;
  		}

  		if (isset($_POST[self::$login]) || isset($_COOKIE["Username"])) {
          	if ($this->checkUsername() && $this->checkPassword() || $this->checkCookies()) {
            	$this->compareDatabase();
          	} else if (!$this->checkUsername()) {
            	self::$message = "Username is missing";
          	} else if (!$this->checkPassword()) {
            	self::$message = "Password is missing";
          	}
  			}

  		return;

	}

}
