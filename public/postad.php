<? 
	require_once('classes/Ad.php');
	require_once('classes/Ad_Manager.php');
	$ad_list = new AdManager($dbc);
	$ads_array = $ad_list->load_ad();
	include('header.php');
	if (!empty($_POST)) {
		$valid = true;
		foreach ($_POST as $key => $value) {
			if (empty($value)) {
				$valid = false;
				break;
			} else {
				$entryToAdd[] = $value;
			}
		}
		if ($valid) {
			$newAd = new Ad($dbc);
			$newAd->title = $_POST['title'];
			$newAd->body = $_POST['body'];
			//$newAd->date = $_POST['date'];
			$newAd->username = $_POST['contact'];
			$newAd->email = $_POST['email'];
			$ads_array[] = $newAd;
			$newAd->save();
			header('location: chrislist.php');
			exit;
		}
	}
?>
<form method="POST" action="postad.php">
	<label></label>
	<input type="text" name="title" id="title" placeholder="Title" required>
	<textarea name="body" id="body" placeholder="Body" required></textarea>
	<!-- <input type="date" name="date" id="date" placeholder="Date" required> -->
	<input type="text" name="contact" id="contact" placeholder="Userame" required>
	<input type="email" name="email" id="email" placeholder="Email" required>
	<!-- <input type="file" id="image" placeholder="Image"> -->
	<input type="submit">
</form>
<? include('footer.php'); ?>