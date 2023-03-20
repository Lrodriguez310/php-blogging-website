<?php
require_once("../includes/bootstrap.php");


/**
 * Class DatabaseTest
 */
class DatabaseTest {

	private $conn;

	/**
	 * DatabaseTest constructor.
	 * @param Database $dbc
	 */
	public function __construct(Database $dbc) {
		$this->conn = $dbc;
	}

	public function tearDown() {
	}

	/**
	 * @return bool
	 */
	public function testInsert() {
		$result = $this->conn->sqlQuery("INSERT INTO `logins` VALUES(0, 'testuser', 'testpass')", "");
		return ($result->rowCount() == 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testDelete() {
		$result = $this->conn->sqlQuery("DELETE FROM `logins` WHERE `username` = :username", ['username' => 'testuser']);
		return ($result->rowCount() == 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testFetch() {
		$result = $this->conn->fetchArray("SELECT * FROM `logins`;");
		return ($result) ? true : false;
	}
}

$databaseTest = new DatabaseTest($dbc);

echo "Test #1 TestInsert ...";
echo $databaseTest->testInsert() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #2 TestFetch ...";
echo $databaseTest->testFetch() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #3 TestDelete ...";
echo $databaseTest->testDelete() ? "Test passed" : "Test Failed";
echo "<br>";