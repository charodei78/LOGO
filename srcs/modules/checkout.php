<?php 
	$id = array_map(intval, $_POST['id']);
	$client_name = htmlspecialchars($_POST['client_name']);
	$address = htmlspecialchars($_POST['address']);
	$phone = intval($_POST['phone']);
	if (!$id[0] || !$client_name || !$address || !$phone)
	{
		exit("<script type='text/javascript'>alert('Ошибка данных! Повторите ввод.".$id[0].$client_name.$address.$phone."');
			location.href='cart.php';</script>");
	}
	$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	try {
		$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
	} catch (Exception $e) {
		exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
			location.href=location.href;</script>');
	}
	$query = $connection->prepare('INSERT INTO client (client_name, address, phone) VALUES (:client_name, :address, :phone)');
	$query->execute([
		':client_name' => $client_name, 
		':address' => $address, 
		':phone' => $phone]);
	$client_id = $connection->lastInsertId();
	$query = $connection->prepare('INSERT INTO `order` (client_id) VALUES (:client_id)');
	$query->execute([
		':client_id' => $client_id]);
	$order_id = $connection->lastInsertId();
	insert_list($id, $order_id, $connection, "order_products", "order_id", 'product_id');
	function insert_list($list, $id, $connect, $table_name, $fld_name_id, $fld_name_value)
	{
		$pre_query = "INSERT INTO `".$table_name."` (".$fld_name_id.", ".$fld_name_value.") VALUES ";
		$values_arr = array();
		for ($row=0; $row < count($list); $row++) 
		{ 
		  $pre_query = $pre_query.'('.strval($id).', :field'.strval($row).')';
		  if ($row < count($list) - 1)
		    $pre_query = $pre_query.',';
		  $values_arr += [':field'.strval($row) => $list[$row]];
		}
		$query = $connect->prepare($pre_query);
		$query->execute($values_arr);
	}
	$connection = null;
	header("location: finish.html");
?>