<? 
	require('classes/Ad_Manager.php');
	$ad_list = new AdManager(FILENAME);
	$ads_array = $ad_list->load_ad();
	require('classes/ad.php');
	if (isset($_GET)) {
		$adToView = $printable_ads[$_GET['id']];
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
			<p><em id="postDate"><?= htmlspecialchars($adToView->date); ?></em></p>
			<h4 id="contactName">Posted By: <?= htmlspecialchars($adToView->username); ?></h4>
			<p id="contactEmail">Contact Email: <?= htmlspecialchars($adToView->date); ?></p>
		</div>
	</div>
</div>
<? include('footer.php'); ?>