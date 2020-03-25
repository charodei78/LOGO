<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create</title>
	<style type="text/css">
		table {border: 3px solid black}
		td {border: 1px solid gray; padding: 5px;border-bottom: 1px solid black;border-top: 1px solid black;}
		th {border: 1px solid black;}
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>
	</form>
	<form id="table_form" >
	<table cellspacing="0">
	<tr><th>select<th>id<th>name<th>year<th>country<th>rate<th>price</tr>
	<?php
		
		$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '', $options);
		$stmt = $connection->query('SELECT id, name, year, country, rate, price FROM films');
		$data = $stmt->fetchAll();
		foreach ($data as $i => $row) {
			echo '<tr><td><input name="row[]" type="checkbox" value="'.$row['id'].'" >';
			foreach ($row as $j => $value) {
				echo '<td >'.$value;
				if ($j == "year") {
					echo "г";
				}
				if ($j == "rate") {
					echo "+";
				}
				if ($j == "price") {
					echo " руб.";
				}
			}
			echo "</tr>";
		}
		$connection = null;
	?>
	</table>
	<br>
	<input type="submit" name="create" value="Создать" formaction="create_elem.php" formmethod="post" formnovalidate="false">
	<input type="submit" id="change_button" name="view" value="Просмотр" formaction="page.php" formmethod="get">
	<input type="submit" id="change_button" name="change" value="Изменить" formaction="change.php" formmethod="post">
	<input type="submit" id="delete_button" name="delete" value="Удалить" formaction="sql_delete.php" formmethod="post">
	<script type="text/javascript">
		$("#table_form input").on("click", function() {
		if($("#table_form input:checked").length != 1) { 
			
			$("#change_button ").attr("disabled", true);
		
		} else {
			
			$("#change_button ").attr("disabled", false);
		}
		if($("#table_form input:checked").length == 0)
		{
			$("#delete_button ").attr("disabled", true);
		} else {	
			$("#delete_button ").attr("disabled", false);
		}

	});
	</script>
	</form>
</body>
</html>