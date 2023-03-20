<?php
require_once("../includes/bootstrap.php");


/**
 * Class UserTest
 */
class UserTest {
	private $user;
	private $dbc;

	/**
	 * UserTest constructor.
	 * @param Database $dbc
	 */
	public function __construct(Database $dbc) {
		$this->dbc = $dbc;
		$enc_pass = password_hash('TestPass', PASSWORD_BCRYPT, ['cost' => 10]);
		$dbc->sqlQuery("INSERT INTO `logins` (`username`, `password`) VALUES ('TestUser', '$enc_pass')");
	}

	/**
	 * @return bool
	 */
	public function tearDown() {
		$result = $this->dbc->sqlQuery("DELETE FROM `logins` WHERE `username` = 'TestUser'");
		return ($result->rowCount() >= 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testAuth() {
		$this->user = User::auth('TestUser', 'TestPass');
		if($this->user instanceof User)
			if($this->user->getUsername() == 'TestUser') return true;

		return false;
	}

}

$userTest = new UserTest($dbc);

echo "Test #1 TestAuth ...";
echo $userTest->testAuth() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Clean up ...";
echo $userTest->tearDown() ? "done" : "failed";
echo "<br>";
