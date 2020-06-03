<?php
	$id = intval($_POST['id']);
	$title = $_POST['title'];
	$release = $_POST['release'];
	$country = $_POST['country'];
	$rate = $_POST['rate'];
	$discription = $_POST['discription'];
	$trailer = $_POST['trailer'];
	$new_country = $_POST['new_country'];
	$price = $_POST['price'];
	$role = $_POST['role'];
	$category = $_POST['category'];
	$director = $_POST['director'];
	$genre = $_POST['genre'];
	$img1 = $_FILES['img1'];
	$img2 = $_FILES['img2'];
	$img3 = $_FILES['img3'];
	$poster = $_FILES['poster'];
	$preview = $_FILES['preview'];
	include "check_img.php";

	if (strstr($trailer, "https://www.youtube.com/watch?v"))
		$trailer = substr(strrchr($trailer, '='), 1);
	function insert_list ($list, $id, $connect, $table_name, $fld_name_id, $fld_name_value)
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

	try {
		$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
	} catch (Exception $e) {
		exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
			location.href=location.href;</script>');
	}
	if ($new_country)
	{
		$add_new_country = $connection->prepare("INSERT INTO country (name) values (:name)");
		$add_new_country->execute([':name' => $new_country]);
		$country = $connection->lastInsertId();
	}
	$connection->query("DELETE FROM genre_list WHERE film_id = $id");
	insert_list($genre, $id, $connection, "genre_list", "film_id", "genre_id");
	$connection->query("DELETE FROM category_list WHERE film_id = $id");
	insert_list($category, $id, $connection, "category_list", "film_id", "category_id");
	$sql = "UPDATE film SET title = :title, `release` = :release, country_id = :country_id, rate = :rate, discription = :discription, role = :role, director = :director, trailer = :trailer, price = :price WHERE id = :id";
	$query = $connection->prepare($sql);
	$query->execute([':title' => $title, ':release' => $release, ':country_id' => $country, ':rate' => $rate, ':discription' => $discription, ':role' => $role, ':director' => $director, ':trailer' => $trailer, ':price' => $price, ':id' => $id]);
	function replase_img($img, $name)
	{
		if($img['name'])
		{
			check_img($img);
			unlink("../srcs/images/$last_id/$name");
			move_uploaded_file($img['tmp_name'], "../srcs/images/$last_id/$name");
		}
	}
	replase_img($img1, 'img1');
	replase_img($img2, 'img2');
	replase_img($img3, 'img3');
	replase_img($poster, 'poster');
	replase_img($preview, 'preview');
	$connection = null;    
	header("Location: adm_panel.php");
?>