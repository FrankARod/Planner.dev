<?php
	define("FILENAME", "txt/address_book.csv");

	$address_book = read_file();
	
	function save_file($address_book, $filename = FILENAME) {	
		$handle = fopen($filename, 'w');
		foreach ($address_book as $key => $value) {
			fputcsv($handle, $value);
		}
		fclose($handle);
	}

	function read_file($filename = FILENAME) {
		if (filesize($filename) == 0) {
			$address_book = [];
		} else {
			$handle = fopen($filename, 'r');
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
			save_file($address_book);
		}
	} 
	
	if (isset($_GET['remove'])) {
		$removeKey = $_GET['remove'];
		unset($address_book[$removeKey]);
		save_file($address_book);
	} 
?>

<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h1>$_POST</h1>
	
	<? var_dump($_POST); ?>
		
	<table>
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
					<td><a href="?remove=<?=$entry_index;?>">Forget?</a></td>
			</tr>
		<? endforeach ?>
	</table>

	<form method="POST" action="address_book.php">
		<input type="text" name="name" id="name" placeholder="Name">
		<input type="text" name="address" id="address" placeholder="Address">
		<input type="text" name="city" id="city" placeholder="City">
		<input type="text" name="state" id="state" placeholder="State">
		<input type="text" name="zip" id="zip" placeholder="Zipcode">
		<input type="submit">
	</form>

	<? if (isset($valid) && !$valid) : ?>
		<p>Please fill in all fields and try again.</p>
	<? endif ?>
</body>
</html>