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



	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = '';
		$message = $this->credentialChecker();
		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
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

	public function isLoggedIn() {
		$status = $this->compareDatabase()[1];
		return $status;
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
			if (strlen($_POST[self::$password])) {
				$hasPassword = true;
			}
		}

		return $hasPassword;
	}

	private function compareDatabase() {
		$text = array();

		if (isset($_POST[self::$login])) {
			$username = $_POST[self::$name];
			$password = $_POST[self::$password];

			if ($this->superRealDatabase()["username"] == $username && $this->superRealDatabase()["password"] == $password) {
				$text[] = "";
				$text[] = true;
			} else {
				$text[] = "Wrong name or password";
				$text[] = false;
			}

		} else {
			$text[] = "";
			$text[] = false;
		}

		return $text;

	}

	private function credentialChecker() {
		$loginMessage = "";

		if (isset($_POST[self::$login])) {
			if ($this->checkUsername() && $this->checkPassword()) {
				$loginMessage = $this->compareDatabase()[0];
			} else if (!$this->checkUsername()) {
				$loginMessage = "Username is missing";
			} else if (!$this->checkPassword()) {
				$loginMessage = "Password is missing";
			}
		}

		return $loginMessage;
	}

}
