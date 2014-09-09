<?php
	define('FILENAME', 'txt/todolist.txt');
	
	$list = file(FILENAME, FILE_IGNORE_NEW_LINES);

	function add_to_file($filename, $items) {
	    $items = implode("\n", $items);
	    $handle = fopen($filename, 'w');
	    fwrite($handle, $items);
	    fclose($handle);
	    return "Save Successful";
	}
	
	function remove_entry($index, $list) {
		unset($list[$index]);
		add_to_file(FILENAME, $list);
		$_GET['remove'] = null;

	};


	if (!empty($_POST['newItem'])) {
		$newItem = $_POST['newItem'];
		$handle = fopen(FILENAME, 'a');
    	fwrite($handle, PHP_EOL . $newItem);
    	fclose($handle);
    	$list = file(FILENAME, FILE_IGNORE_NEW_LINES);
	}

	if (!empty($_GET['remove'])) {
		remove_entry($_GET['remove'], $list);
		$list = file(FILENAME, FILE_IGNORE_NEW_LINES);
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<title>TODO List</title>
		
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h2 id="GET">GET</h2>
		
		<?php var_dump($_GET); ?>

		<h2 id="POST">POST</h2>
		
		<?php var_dump($_POST); ?>

		<div>
			<h1>TODO List</h1>
			
			<ul>
				<?php 
					foreach ($list as $index => $item) {
						if (empty($item)) {
							continue;
						}
						echo "<li class='entry'>" . $item . "</li><a href='todo_list.php?remove=" . $index . "'>Mark Complete</a>" . PHP_EOL;
					} 
				?>
			</ul>	
			
			<form method="POST" action="todo_list.php">
				<label for="newItem">Add a New Item:</label>
				
				<input type="text" name="newItem" id="newItem">

				<input type="submit" value="Add">
			</form>
		</div>
	</body>
</html>