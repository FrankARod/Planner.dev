<!DOCTYPE html>
<html>
	<head>
		<title>TODO List</title>
	</head>
	<body>
		<h2>GET</h2>
		<?php var_dump($_GET); ?>

		<h2>POST</h2>
		<?php var_dump($_POST); ?>

		<h1>TODO List</h1>
		<ul>
			<li>Take out trash</li>
			<li>Give dogs bath</li>
			<li>Do laundry</li>
		</ul>	
			<form method="POST">
				<label for="newItem">Add a New Item:<input type="text" name="newItem" id="newItem"></label>
				<input type="submit" value="Add">
			</form>
	</body>
</html>