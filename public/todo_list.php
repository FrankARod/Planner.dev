<?php
	define('FILENAME', 'txt/todolist.txt');
	require_once('../inc/filestore.php');
	$filestore = new Filestore(FILENAME);
	$list = $filestore->read_lines();

	if (!empty($_POST['newItem'])) {
		$new_item = $_POST['newItem'];
		$list[] = $new_item;
		$filestore->write_lines($list);
	} 

	if (isset($_GET['remove'])) {
		$remove_index = $_GET['remove'];
		unset($list[$remove_index]);
		$filestore->write_lines($list);
	}

	if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
		$upload_dir = '/vagrant/sites/planner.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$external_file = new Filestore($filename);
		$external_list = $external_file->read_lines();
		$list = array_merge($list, $external_list);
		$filestore->write_lines($list);
	} 
?>

<!DOCTYPE html>

<html>
	<head>
		<title>TODO List</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/boostrap.min.css">
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h2 id="GET">GET</h2>
			<?php var_dump($_GET); ?>
		<h2 id="POST">POST</h2>
			<?php var_dump($_POST); ?>
		<h2 id="FILES">
			<?php var_dump($_FILES); ?>
		</h2>

		<div class="container">
			<div class="col-md-8">	
				<h1>TODO List</h1>
			
				<ul>
					<? 
						foreach ($list as $index => $item):
							if (empty($item)) {
								continue;
							}
					?>
					
					<div class='row'><li class='entry col-md-4'> <?= htmlspecialchars(strip_tags($item)); ?> </li><a class='col-md-4' href='todo_list.php?remove=<?= $index; ?> '>Mark Complete</a></div> <?= PHP_EOL; ?>
					<?	endforeach; ?>
				</ul>	
				
				<form method="POST" action="todo_list.php">
					<label for="newItem">Add a New Item:</label>
					<input type="text" name="newItem" id="newItem">
					<input type="submit" value="Add">
				</form>
				<form method="POST" enctype="multipart/form-data" action="todo_list.php">
					<label for="file1">Upload File</label>
					<input type="file" name="file1" id="file1">
					<input type="submit" value="Upload">
				</form>
			</div>	
		</div>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>