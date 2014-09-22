<? 
	require_once('classes/Ad.php');
	require_once('classes/Ad_Manager.php');
	$ad_list = new AdManager($dbc);
	$ads_array = $ad_list->load_ad();
	if (isset($_GET['remove'])) {
		$ad_list->remove_ad($ads_array);
		header('location: chrislist.php');
		exit;
	}
	if (isset($_GET['id'])) {
		$adToView = new Ad($dbc, $_GET['id']);
	}
	include('header.php');
?>
<div class="container">
	<div id="postTitle" class="row">
		<div class="col-md-10 col-md-offset-1">
			<h2 id=""><?= $adToView->title; ?></h2>
		</div>
	</div>
	<div id="postBody" class="row">
		<div class="col-md-10 col-md-offset-1">
			<p><?= $adToView->body; ?></p>
		</div>
	</div>
	<div id="postInfo">
		<div class="col-md-10 col-md-offset-1">
			<p><em id="postDate"><?= $adToView->date->format('l, F jS, Y'); ?></em></p>
			<h4 id="contactName">Posted By: <?= htmlspecialchars($adToView->username); ?></h4>
			<p id="contactEmail">Contact Email: <?= htmlspecialchars($adToView->email); ?></p>
		</div>
	</div>
	<div>
		<a href="?remove=<?= $_GET['id']; ?>">Remove This Ad</a>
		<a href="editad.php?id=<?= $_GET['id']; ?>">Edit This Ad</a>
	</div>
</div>
<? include('footer.php'); ?>