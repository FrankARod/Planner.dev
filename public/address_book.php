<?php
	define('FILENAME', 'txt/address_book.csv');

	// Grab AddressDataStore class
	include('classes/address_data_store.php');
	$book = new AddressDataStore();
	$address_book = $book->read_file();
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
			$address_book[] = $entryToAdd;
			$book->save_file($address_book);
		}
	} 
	if (isset($_GET['remove'])) {
		$removeKey = $_GET['remove'];
		unset($address_book[$removeKey]);
		$address_book = array_values($address_book);
		$book->save_file($address_book);
	} 
	if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
		$upload_dir = '/vagrant/sites/planner.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$external = new AddressDataStore($filename);
		$external_list = $external->read_file();
		$address_book = array_merge($address_book, $external_list);
		$book->save_file($address_book);
	}
?>
<html>
<head>
	<title>Address Book</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css"> -->
	<link rel="stylesheet" type="text/css" href="css/address_book.css">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid" class="nav-form">
			<form method="POST" action="address_book.php" class="navbar-form navbar-left">		
				<div class="form-group">
					<input type="text" name="name" id="name" placeholder="Name">
				</div>
				<div class="form-group">
					<input type="text" name="address" id="address" placeholder="Address">
				</div>
				<div class="form-group">
					<input type="text" name="city" id="city" placeholder="City">
				</div>
				<div class="form-group">
					<input type="text" name="state" id="state" placeholder="State">
				</div>
				<div class="form-group">
					<input type="number" name="zip" id="zip" placeholder="Zipcode">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
			<form method="POST" action="address_book.php" enctype="multipart/form-data" class="navbar-form">
				<div class="form-group">
					<span class="btn btn-default btn-file">
						Upload Address Book<input type="file" id="file1" name="file1">
					</span>
				</div>
				<div class="form-group">	
					<input type="submit" value="Upload" class="btn btn-primary">
				</div>
			</form>
		</div>
	</nav>
	<div class="container">		
		<? if (isset($valid) && !$valid) : ?>
		<div class="alert alert-danger">
			<p>Please fill in all fields and try again.</p>
		</div>
		<? endif ?>
		<table class="table table-striped table-hover">
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>Remove Link</th>
			</tr>
			<? foreach ($address_book as $entry_index => $entry) : ?>
			<tr>
					<? foreach($entry as $data) : ?>
					<td><?= htmlspecialchars(strip_tags($data)); ?></td>
					<? endforeach ?>
					<td><a href="?remove=<?=$entry_index;?>" class="btn btn-danger">Remove</a></td>
			</tr>
			<? endforeach ?>
		</table>
	</div>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>