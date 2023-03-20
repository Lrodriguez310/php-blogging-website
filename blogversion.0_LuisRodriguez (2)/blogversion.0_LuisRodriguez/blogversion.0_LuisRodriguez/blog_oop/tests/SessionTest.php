<?php
require_once("../includes/bootstrap.php");



/**
 * Class SessionTest
 */
class SessionTest {
	private $session;

	/**
	 * SessionTest constructor.
	 * @param Session $session
	 */
	public function __construct(Session $session) {
		$this->session = $session;
	}

	/**
	 * @return bool
	 */
	public function testLogin() {
		$testUser = new User(0, "TestUser", "TestPass");
		$this->session->login($testUser);

		return true;
	}

	/**
	 * @return bool
	 */
	public function testLogout() {
		$this->session->logout();

		return true;
	}

	/**
	 * @return bool
	 */
	public function testGetUser() {
		return ($this->session->getUser() instanceof User) ? true : false;
	}

	/**
	 * @return bool|User
	 */
	public function testIsLoggedIn() {
		return $this->session->isLoggedIn();
	}

}

$sessionTest = new SessionTest($session);

echo "Test #1 TestLogin ...";
echo $sessionTest->testLogin() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #2 TestGetUser ...";
echo $sessionTest->testGetUser() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #3 TestIsLoggedIn ...";
echo $sessionTest->testIsLoggedIn() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #4 TestLogout ...";
echo $sessionTest->testLogout() ? "Test passed" : "Test Failed";
echo "<br>";