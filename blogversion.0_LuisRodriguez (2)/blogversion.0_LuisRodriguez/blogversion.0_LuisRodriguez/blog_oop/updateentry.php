<?php
require_once('includes/bootstrap.php');
require_once("header.php");
//require_once("config.php");

if($session->isLoggedIn()) {
	header("Location: index1.php");
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: index1.php");
}

$validId = $_GET['id'];
$fillsql = "SELECT * FROM entries WHERE id=" . $validId . ";";
$fillres = mysqli_query($db, $fillsql);
$fillrow = mysqli_fetch_array($fillres, MYSQLI_ASSOC);

if(isset($_POST['submit'])) {
	$sql = "UPDATE entries SET cat_id=" . $_POST['cat'] . ", subject='" . $_POST['subject'] . "', body='" . $_POST['body'] . "' WHERE id=" . $validId . ";";
	mysqli_query($db, $sql);

	header("Location: viewentry.php?id=$validId");

} else {
	?>

	<h1>Update Entry</h1>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $validId; ?>" method="post">
		<table>
			<tr>
				<td>Category</td>
				<td>
					<select name="cat">
						<?php
						$catsql = "SELECT * FROM categories;";
						$catres = mysqli_query($db, $catsql);
						while($catrow = mysqli_fetch_array($catres, MYSQLI_ASSOC)) {
							echo "<option value='" . $catrow['id'] . "'";
							if($catrow['id'] == $fillrow['cat_id']) {
								echo "selected ";
							}
							echo ">" . $catrow['cat'] . "</option>";
						}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Subject</td>
				<td><input type="text" name="subject" value="<?php echo $fillrow['subject']; ?>"/></td>
			</tr>

			<tr>
				<td>Body</td>
				<td><textarea name="body" rows="10" cols="50"><?php echo $fillrow['body']; ?></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Update Entry"/></td>
			</tr>
		</table>
	</form>
	<?php
}
require_once('footer.php');
?>