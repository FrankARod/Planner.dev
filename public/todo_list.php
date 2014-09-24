<?php
	define('FILENAME', 'txt/todolist.txt');
	require_once('../inc/filestore.php');
	$filestore = new Filestore(FILENAME);
	$list = $filestore->read();

	class InvalidInputException extends Exception {}

	if (!empty($_POST['newItem'])) {
		try {
			if (strlen($_POST['newItem'] > 240)) {
			throw new InvalidInputException('Todo Items must be 240 characters or less');
			} else {
				$new_item = $_POST['newItem'];
				$list[] = $new_item;
				$filestore->write($list);
			}
		} catch (InvalidInputException $e) {
			echo $e->getMessage();
		}	
	} 

	if (isset($_GET['remove'])) {
		$remove_index = $_GET['remove'];
		unset($list[$remove_index]);
		$filestore->write($list);
	}

	if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
		$upload_dir = '/vagrant/sites/planner.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$external_file = new Filestore($filename);
		$external_list = $external_file->read();
		$list = array_merge($list, $external_list);
		$filestore->write($list);
	} 
?>

<!DOCTYPE html>

<html>
	<head>
		<title>TODO List</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"> -->
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="container">
			<div class="col-md-12">	
				<h1>Todo List</h1>
				<ul>	
					<? 
						foreach ($list as $index => $item):
							if (empty($item)) {
								continue;
							}
					?>
					<li>
						<div class="row">
							<p class="col-md-6"><?= htmlspecialchars(strip_tags($item)); ?></p>
							<a class='btn btn-danger pull-right' role="button" href='todo_list.php?remove=<?= $index; ?>'>Completed?</a>
						</div>
						<hr>
					</li>
					<?	endforeach; ?>
					<div class="clearfix"></div>
				</ul>
				<div class="pull-left">
					<form method="POST" action="todo_list.php" role="form" class="form-inline">
						<div class="form-group">
							<label for="newItem" class="sr-only">Add a New Item:</label>
							<input type="text" name="newItem" id="newItem" class="form-control" placeholder="Add Item to List">
						</div>
							<input type="submit" value="Add" class="btn btn-default">
					</form>
				</div>
				<div class="pull-left" id="upload-form">	
					<form method="POST" enctype="multipart/form-data" action="todo_list.php" role="form" class="form-inline">
						<div class="form-group">
							<!-- <p class="help-block">Upload external todo list (.txt)</p> -->
							<label for="file1" class="sr-only">Upload File</label>
							<span class="btn btn-default btn-file">
								Upload Todo List<input type="file" id="file1" name="file1">
							</span>
							<!-- <input type="file" name="file1" id="file1"> -->
						</div>
							<input type="submit" value="Upload" class="btn btn-default">
					</form>
				</div>
			</div>	
		</div>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>