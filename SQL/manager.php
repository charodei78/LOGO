<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ADM panel</title>
	<style type="text/css">
		table {border: 3px solid black}
		td {border: 1px solid gray; padding: 5px;border-bottom: 1px solid black;border-top: 1px solid black;}
		th {border: 1px solid black;}
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>
	<table cellspacing="0">
	<tr><th>select<th>id заказа<th>имя<th>телефон<th>адрес<th>статус заказа<th>дата заказа<th>чек заказа</tr>
	<?php
		
		$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
		$stmt = $connection->query("SELECT `order`.id as id, client.name as name, phone, address, status.name as status, `date`, sum(price) as summ FROM `order`
			LEFT JOIN client ON client.id = client_id 
			LEFT JOIN status ON status.id = status_id
			LEFT JOIN order_products ON `order`.id = order_id
            LEFT JOIN film ON film.id = order_products.product_id
			GROUP BY `order`.id, client.name, address, phone, date, status.name
			ORDER BY `date`;");
		$data = $stmt->fetchAll();
		foreach ($data as $i => $row) {
			echo '<tr><td><input name="id[]" type="checkbox" value="'.$row['id'].'" >';
			foreach ($row as $j => $value) {
				echo '<td >'.$value;
			}
			echo "</tr>";
		}
		$connection = null;
	?>
	</table>
	<br>
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
</body>
</html>