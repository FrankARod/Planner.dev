<?php
	require_once('../todo_connect.php');
	require_once('classes/todo_list.php');
	require('../inc/filestore.php');
	$todo_db = new TodoList($dbc);
	class InvalidInputException extends Exception {}

	// Determines page count for pagination
	$pages = $todo_db->get_page_count();
	
	try {
		if (isset($_GET['page'])) {
			$this_page = $_GET['page'];
			if (isset($_GET['page']) && ($this_page > $pages || !is_numeric($_GET['page'])) || $this_page < 1) {
				throw new InvalidInputException('Invalid Page Number');
			}
		} else {
			$this_page = 1;
		}
	} catch (Exception $e) {
		echo "<div class='container'><div class='alert alert-danger'>{$e->getMessage()}</div></div>";
		$this_page = 1;
	}

	$offset = ($this_page - 1) * 4;

	// User Input
	if (!empty($_POST['newItem'])) {
		try {
			if (strlen($_POST['newItem'] > 240)) {
				throw new InvalidInputException('Todo Items must be 240 characters or less');
			} else {
				$new_item = $_POST['newItem'];
				$todo_db->insert_db($new_item);
			}
		} catch (InvalidInputException $e) {
			echo $e->getMessage();
		}	
	} 

	if (isset($_GET['remove'])) {
		$remove_index = $_GET['remove'];
		$todo_db->delete_db($remove_index);
	}

	if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] == 'text/plain') {
		$upload_dir = '/vagrant/sites/planner.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$external_file = new Filestore($filename);
		$external_list = $external_file->read($filename);
		
		foreach ($external_list as $key => $item) {
			$todo_db->insert_db($item);
		}
	} 
	
	$list = $todo_db->read_db(10, $offset);
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
					<? foreach ($list as $item): ?>
					<li>
						<div class="row">
							<p class="col-md-6"><?= htmlspecialchars(strip_tags($item['todo_item'])); ?></p>
							<a class='btn btn-danger pull-right' role="button" href='todo_list.php?remove=<?= $item['id']; ?>'>Completed?</a>
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
							<input type="text" name="newItem" id="newItem" class="form-control" placeholder="Add Item to List" autofocus>
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
			<ul class="pagination">
				<? for ($i = 1; $i <= $pages; $i++): ?>
					<li><a href="?page=<?= $i; ?>"><?= $i; ?></a></li>
				<? endfor; ?>
			</ul>
		</div>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>