<? 
	require('classes/Ad_Manager.php');
	$ad_list = new AdManager(FILENAME);
	$ads_array = $ad_list->load_ad();
	require('classes/ad.php');
	include('header.php'); 	
?>
<form method="POST" action="chrislist.php">
	<label></label>
	<input type="text" name="title" id="title" placeholder="Title">
	<textarea name="body" id="body" placeholder="Body"></textarea>
	<input type="text" name="date" id="date" placeholder="Date">
	<input type="text" name="contact" id="contact" placeholder="Userame">
	<input type="text" name="email" id="email" placeholder="Email">
	<!-- <input type="file" id="image" placeholder="Image"> -->
	<input type="submit">
</form>
<? include('footer.php'); ?>