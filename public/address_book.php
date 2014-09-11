<?php
	define('FILENAME', 'txt/address_book.csv');
	class AddressDataStore {
		public $filename = '';
		public function save_file($address_book) {	
			$handle = fopen($this->filename, 'w');
			foreach ($address_book as $key => $value) {
				fputcsv($handle, $value);
			}
			fclose($handle);
		}
		public function read_file() {
			if (filesize($this->filename) == 0) {
				$address_book = [];
			} else {
				$handle = fopen($this->filename, 'r');
				while(!feof($handle)) {
					$row = fgetcsv($handle);
					if (!empty($row)) {
						$address_book[] = $row;
					}
				}
				fclose($handle);
			}
			return $address_book;
		}
	}
	$book = new AddressDataStore;
	$book->filename = FILENAME;
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
?>

<html>
<head>
	<title>Address Book</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/address_book.css">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid" id="nav-form">
			<p class="navbar-text">Address Book</p>
			<form method="POST" action="address_book.php" class="navbar-form">		
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
		</div><!-- /.container-fluid -->
	</nav>

	<div class="container">		
		<table class="table">
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

		<? if (isset($valid) && !$valid) : ?>
		<p>Please fill in all fields and try again.</p>
		<? endif ?>
	</div>
	
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>