<?php
	require('../address_connect.php');
	require('classes/AddressBook.php');
	class InvalidInputException extends Exception {}
	$book = new AddressBook($dbc);

	
	if (!empty($_POST['name']) && is_numeric(($_POST['existing_address']))) {
		$book->add_to_address($_POST['existing_address'], $book->check_name($_POST['name']));
	} elseif (!empty($_POST['name']) && !empty($_POST['new_address'])) {
		$book->add_to_address($book->check_address($_POST['new_address']), $book->check_name($_POST['name']));
	} 

	if (isset($_GET['remove'])) {
		$removeKey = $_GET['remove'];
		unset($address_book[$removeKey]);
		$address_book = array_values($address_book);
		$book->save_file($address_book);
	} 

	if (isset($_GET['address'])) {
		$names = $book->show_address($_GET['address']);
		$viewing = htmlspecialchars($names[0]['address']);
	} elseif (isset($_GET['name'])) {
		$names = $book->show_name($_GET['name']);
		$viewing = htmlspecialchars($names[0]['name']);
	} else {
		$names = $book->list_names();
		$viewing = "All Names";
	}

	$addresses = $book->list_addresses();
?>
<html>
<head>
	<title>Address Book</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/address_book.css">
</head>
<body style="margin-top: 70px">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid" class="nav-form">
			<form method="POST" action="address_book.php" class="navbar-form navbar-left">		
				<div class="form-group">
					<input type="text" name="name" id="name" placeholder="Name">
				</div>
				<div class="form-group">
					<select id="existing_address" name="existing address" class="form-control">
						<option>Add a New Address</option>
						<? foreach($addresses as $address): ?>
							<option value="<?= $address['id'] ?>"><?= "{$address['address']}, {$address['zip']}, {$address['city']}, {$address['state']}"; ?></option>
						<? endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<input type="text" name="new_address[address]" id="new_address[address]" placeholder="Address">
				</div>
				<div class="form-group">
					<input type="text" name="new_address[city]" id="new_address[city]" placeholder="City">
				</div>
				<div class="form-group">
					<select name="new_address[location]" id="new_address[location]" class="form-control"> 
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
					<input type="number" name="new_address[zip]" id="new_address[zip]" placeholder="Zipcode">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Submit">
				</div>
			</form>
		</div>
	</nav>
	<div class="container">		
		<a href="address_book.php" class="btn btn-primary">Home</a>
		<h1>Viewing <?= $viewing; ?></h1>
		<table class="table table-striped table-hover">
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>Remove Link</th>
			</tr>
				<? foreach ($names as $name) : ?>
					<tr>
						<td><a href="?name=<?= $name['name_id']; ?>"><?= htmlspecialchars($name['name']); ?></a></td>
						<td><a href="?address=<?= $name['address_id']; ?>"><?= htmlspecialchars($name['address']); ?></a></td>
						<td><a href="?remove=<?=$name['name_id'];?>" class="btn btn-danger">Remove</a></td>
					</tr>
				<? endforeach ?>
		</table>
	</div>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>