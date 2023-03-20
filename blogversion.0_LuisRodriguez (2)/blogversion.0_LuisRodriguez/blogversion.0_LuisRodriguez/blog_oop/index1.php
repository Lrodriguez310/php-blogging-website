<?php
require_once('includes/bootstrap.php');
require_once('header.php');

$sql = "SELECT entries.*, categories.cat FROM entries,categories WHERE entries.cat_id=categories.id ORDER BY date DESC LIMIT 6;";
$result = mysqli_query($db, $sql);
$numEntries = mysqli_num_rows($result);
if($numEntries > 0) {
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<h2 id='title'><a href='viewentry.php?id=" . $row['id'] . "'>" . $row['subject'] . "</a></h2><br />";
	echo "<p id='byline'>In <a href='viewcat.php?id=" . $row['cat_id'] . "'>" . $row['cat'] . "</a> - Posted on <span class='datetime'>" . date("D jS F Y g:iA", strtotime($row['date'])) . "</span>";

	if($session->isLoggedIn() == true) {
		echo "<span id='edit'><a href='updateentry.php?id=" . $row['id'] . "'>edit</a></span>";
	}
	?>
	</p>

	<p id='entrybody'>
		<?php echo nl2br($row['body']); ?>
	</p>

	<p id='comments'>
		<?php
		$commsql = "SELECT name FROM comments WHERE blog_id=" . $row['id'] . " ORDER BY date;";
		$commresult = mysqli_query($db, $commsql);
		$numrows_comm = mysqli_num_rows($commresult);
		if($numrows_comm == 0) {
			echo "No comments.";
		} else {
			echo "(<strong>" . $numrows_comm . "</strong>)comments: ";
			$i = 1;
			while($commrow = mysqli_fetch_array($commresult, MYSQLI_ASSOC)) {
				echo "<a href='viewentry.php?id=" . $row['id'] . "#comment" . $i . "'>" . $commrow['name'] . " </a>";
				$i++;
			}
		}
		?>
	</p>

	<div id='prev'>
		<ul>
			<?php
			while($prevrow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				echo "<li><a href='viewentry.php?id=" . $prevrow['id'] . "'>" . $prevrow['subject'] . "</a></li>";
			}
			?>
		</ul>
	</div>
	<?php
} else {
	echo "<p>No entries</p>";
}

require_once('footer.php');
?>