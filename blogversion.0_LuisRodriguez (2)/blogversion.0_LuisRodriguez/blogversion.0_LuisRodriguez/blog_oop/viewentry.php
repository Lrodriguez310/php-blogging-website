<?php
require_once('includes/bootstrap.php');
require_once("header.php");
//require_once("config.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: index1.php");
}
$validId = $_GET['id'];

if(isset($_POST['submit'])) {
	$_POST['name'] = addslashes($_POST['name']);
	$_POST['comment'] = addslashes($_POST['comment']);

$comment = new Comment(0, $validId, 0,
               $_POST['name'], $_POST['comment']);
$comment->create();




	//$sql = "INSERT INTO comments (blog_id,date,name,comment) VALUES(" . $validId . ",NOW(),'" . $_POST['name'] . "','" . $_POST['comment'] . "');";
	//mysqli_query($db, $sql);

	header("Location: {$_SERVER['SCRIPT_NAME']}?id=$validId");
} else {
	$sql = "SELECT entries.*, categories.cat FROM entries, categories WHERE entries.cat_id = categories.id AND entries.id = " . $validId . " ORDER BY date DESC LIMIT 1;";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<h2 id='title'>" . $row['subject'] . "</h2><br>";
	echo "<p id='byline'>In <a href='viewcat.php?id=" . $row['cat_id'] . "'>" . $row    ['cat'] . "</a> - Posted on <span class='datetime'>" . date("D jS F Y g.iA", strtotime($row    ['date'])) . "</span>";

	if($session->isLoggedIn() == true) {
		echo "<span id='edit'><a href='updateentry.php?id=" . $row['id'] . "'>edit</a></span>";
	}

	echo "</p>";

	echo "<p id='entrybody'>";
	echo nl2br($row['body']);
	echo "</p>";


echo "<div id='comments'>";
$comments = Comment::find("SELECT * FROM comments WHERE blog_id =
                            :validId ORDER BY date DESC", ['validId' => $validId]);
   if(count($comments) == 0){
       echo "<p>No comments.</p>";
   }else{
       foreach($comments as $comment){
           echo "<a name='comment" . $comment->getId()."'></a>\n";
           echo "<p class='commenthead'>Comment by".
               $comment->getName()."on".
               date("D js F Y g.iA", strtotime($comment->getDate())).
               "</p>\n";
               echo "<p class='commentbody'>". $comment->getComment().
                   "</p>\n";
       }
   }
echo "</div>\n";

	/* echo "<div id='comments'>";
	$commsql = "SELECT * FROM comments WHERE blog_id = " . $validId . " ORDER BY date DESC;";
	$commresult = mysqli_query($db, $commsql);
	$numrows_comm = mysqli_num_rows($commresult);

	if($numrows_comm == 0) {
		echo "<p>No comments.</p>";
	} else {
		$i = 1;

		while($commrow = mysqli_fetch_array($commresult, MYSQLI_ASSOC)) {
			echo "<a name='comment" . $i . "'></a>\n";
			echo "<p class='commenthead'>Comment by " . $commrow['name'] . " on " . date("D jS F Y g.iA", strtotime($commrow['date'])) . "</p>\n";
			echo "<p class='commentbody'>" . $commrow['comment'] . "</p>\n";
			$i++;
		}
	}
	echo "</div>\n"; */

	?>
	<div id='addcomment'>
		<h3>Leave a comment</h3>

		<form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $validId; ?>" method="post">
			<table>
				<tr>
					<td>Your name</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr>
					<td>Comments</td>
					<td><textarea name="comment" rows="10" cols="50"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Add comment"></td>
				</tr>
			</table>
		</form>
	</div>


	<?php
}

require_once('footer.php');

?>
