<?
	require_once('classes/Ad.php');
	require_once('classes/Ad_Manager.php');
	include('header.php');
	$ad_manager = new AdManager($dbc);
	$ads_array = $ad_manager->load_ad();
	if (isset($_GET['id'])) {
		$adToEdit = new Ad($dbc, $_GET['id']);
	}
	if (!empty($_POST)) {
		$adToEdit->title = $_POST['title'];
		$adToEdit->body = $_POST['body'];
		// $adToEdit->date = $_POST['date'];
		$adToEdit->email = $_POST['email'];
		$adToEdit->username = $_POST['username'];
		// $adToEdit->filename = $_POST['filename'];
		$adToEdit->save();
		header("location: adview.php?id=" . $adToEdit->id);
		exit;
	}
?>
<form method="POST" action="editad.php?id=<?= $_GET['id']; ?>">
	<label></label>
	<input type="text" name="title" id="title" value="<?= $adToEdit->title ?>" required>
	<textarea name="body" id="body" required><?= $adToEdit->body ?></textarea>
	<input type="email" name="email" id="email" value="<?= $adToEdit->email ?>" required>
	<input type="text" name="username" id="username" value="<?= $adToEdit->username ?>" required>
	<!-- <input type="file" id="image" placeholder="Image"> -->
	<input type="submit">
</form>