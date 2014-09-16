<?php
	require('classes/Ad_Manager.php');
	$ad_list = new AdManager(FILENAME);
	$ad_list->filename = FILENAME;
	$ads_array = $ad_list->load_ad();
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
			$new_ad[] = $entryToAdd;
			$ads_array = array_merge($ads_array, $new_ad);
			$ad_list->save_file($ads_array);
		}
	}
	require('classes/Ad.php');
	include('header.php');
?>
<div class="container">  
	<?php foreach ($printable_ads as $key => $advert): ?>
	<div class="col-md-4 mini-advert">
		<h1><a href="adview.php?id=<?= $key; ?>"><?= htmlspecialchars($advert->title); ?></a></h1>
		<p><?= htmlspecialchars($advert->body); ?></p>
		<p>Posted <?= htmlspecialchars($advert->date);; ?></p>
		<p>By: <?= htmlspecialchars($advert->username); ?></p>
		<p><?= htmlspecialchars($advert->email); ?></p>
	</div>
	<? endforeach; ?>
</div>
<? include('footer.php'); ?>