<?php
	define('FILENAME', 'txt/address_book.csv');

	class InvalidInputException extends Exception {}

	// Grab AddressDataStore class
	require_once('classes/address_data_store.php');
	$book = new AddressDataStore(FILENAME);
	$address_book = $book->read_file();
	if (!empty($_POST)) {
		try {
			foreach ($_POST as $key => $value) {
				if (strlen($value) > 120) {	
					throw new InvalidInputException('All properties must be 120 characters or less');
				}
				if (empty($value)) {
					throw new InvalidInputException('All fields must be filled');
				}
				$entryToAdd[] = $value;
			}
			$address_book[] = $entryToAdd;
			$book->save_file($address_book);
		} catch (InvalidInputException $e) {
				echo "<div class='container'><p class='alert alert-danger'>{$e->getMessage()}</p></div>";
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
					<select name="State" name="location" id="location" class="form-control"> 
						<option value="" selected="selected">Select a State</option> 
						<option value="AL">Alabama</option> 
						<option value="AK">Alaska</option> 
						<option value="AZ">Arizona</option> 
						<option value="AR">Arkansas</option> 
						<option value="CA">California</option> 
						<option value="CO">Colorado</option> 
						<option value="CT">Connecticut</option> 
						<option value="DE">Delaware</option> 
						<option value="DC">District Of Columbia</option> 
						<option value="FL">Florida</option> 
						<option value="GA">Georgia</option> 
						<option value="HI">Hawaii</option> 
						<option value="ID">Idaho</option> 
						<option value="IL">Illinois</option> 
						<option value="IN">Indiana</option> 
						<option value="IA">Iowa</option> 
						<option value="KS">Kansas</option> 
						<option value="KY">Kentucky</option> 
						<option value="LA">Louisiana</option> 
						<option value="ME">Maine</option> 
						<option value="MD">Maryland</option> 
						<option value="MA">Massachusetts</option> 
						<option value="MI">Michigan</option> 
						<option value="MN">Minnesota</option> 
						<option value="MS">Mississippi</option> 
						<option value="MO">Missouri</option> 
						<option value="MT">Montana</option> 
						<option value="NE">Nebraska</option> 
						<option value="NV">Nevada</option> 
						<option value="NH">New Hampshire</option> 
						<option value="NJ">New Jersey</option> 
						<option value="NM">New Mexico</option> 
						<option value="NY">New York</option> 
						<option value="NC">North Carolina</option> 
						<option value="ND">North Dakota</option> 
						<option value="OH">Ohio</option> 
						<option value="OK">Oklahoma</option> 
						<option value="OR">Oregon</option> 
						<option value="PA">Pennsylvania</option> 
						<option value="RI">Rhode Island</option> 
						<option value="SC">South Carolina</option> 
						<option value="SD">South Dakota</option> 
						<option value="TN">Tennessee</option> 
						<option value="TX">Texas</option> 
						<option value="UT">Utah</option> 
						<option value="VT">Vermont</option> 
						<option value="VA">Virginia</option> 
						<option value="WA">Washington</option> 
						<option value="WV">West Virginia</option> 
						<option value="WI">Wisconsin</option> 
						<option value="WY">Wyoming</option>
					</select>
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