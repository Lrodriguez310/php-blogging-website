<?php
require_once("../includes/bootstrap.php");


/**
 * Class CommentTest
 */
class CommentTest {
	private $comment;
	private $dbc;

	/**
	 * CommentTest constructor.
	 * @param Database $dbc
	 */
	public function __construct(Database $dbc) {
		$this->dbc = $dbc;
	}

	/**
	 * @return bool
	 */
	public function tearDown() {
		$result = $this->dbc->sqlQuery("DELETE FROM `comments` WHERE `comment` = 'TestComment'");
		return ($result->rowCount() >= 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testCreate() {
		$this->comment = new Comment(0, 1, 0, "Testing", "TestComment");
		$result = $this->comment->create();
		return ($result->rowCount() == 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testFind() {
		$comment = Comment::find("SELECT * from `comments` WHERE `comment` = :comment", ["comment" => "TestComment"]);

		if(count($comment) >= 1) {
			$this->comment = array_shift($comment);

			return true;
		} else {
			return false;
		}
	}

}

$commentTest = new CommentTest($dbc);

echo "Test #1 TestCreate ...";
echo $commentTest->testCreate() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #2 TestFind ...";
echo $commentTest->testFind() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Clean up ...";
echo $commentTest->tearDown() ? "done" : "failed";
echo "<br>";
