<?php
require_once('includes/bootstrap.php');
require_once('header.php');
//require_once('config.php');

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$validId = 0;
} else {
	$validId = $_GET['id'];
}

$sql = "SELECT * FROM categories";
$result = mysqli_query($db, $sql);
$numcats = mysqli_num_rows($result);

if($numcats == 0) {
	echo "No Categories!";
} else {
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if($validId == $row['id']) {
			echo "<span style='font-weight: bold'>" . $row['cat'] . "</span><br/>";
			echo "<ul>";

			$entriessql = "SELECT * FROM entries WHERE cat_id=" . $validId . " 
						 ORDER BY date DESC;";
			$entriesres = mysqli_query($db, $entriessql);
			$numrows_entries = mysqli_num_rows($entriesres);


			if($numrows_entries == 0) {
				echo "<li>No entries found in this category.</li>";
			} else {
				while($entriesrow = mysqli_fetch_array($entriesres, MYSQLI_ASSOC)) {
					echo "<li>" . date("D jS F Y g.iA", strtotime($entriesrow['date'])) . " - <a href='viewentry.php?id=" . $entriesrow['id'] . "'>" . $entriesrow['subject'] . "</a></li>";
				}
			}
			echo "</ul>";
		} else {
			echo "<a href='viewcat.php?id=" . $row['id'] . "'>" . $row['cat'] . "</a><br/>";
		}
	}
}
require_once("footer.php");
?>