<?php
	require('classes/Ad.php');
	require('classes/Ad_Manager.php');
	$ad_list = new AdManager($dbc);
	$ads_array = $ad_list->load_ad();
	include('header.php');
?>
<div class="container">  
	<?php foreach ($ads_array as $advert): ?>
	<div class="col-md-4 mini-advert">
		<h1><a href="adview.php?id=<?= $advert->id; ?>"><?= $advert->title; ?></a></h1>
		<p><?= $advert->body; ?></p>
		<p>Posted <?= $advert->date->format('l, F jS, Y'); ?></p>
		<p>By: <?= $advert->username; ?></p>
		<p><?= $advert->email; ?></p>
	</div>
	<? endforeach; ?>
</div>
<? include('footer.php'); ?>