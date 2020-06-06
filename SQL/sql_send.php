<?php
$title = $_POST['title'];
$release = $_POST['release'];
$country = $_POST['country'];
$new_country = $_POST['new_country'];
$rate = $_POST['rate'];
$discription = $_POST['discription'];
$role = $_POST['role'];
$director = $_POST['director'];
$category = $_POST['category'];
$trailer = $_POST['trailer'];
$img1 = array();
$img2 = array();
$img3 = array();
foreach ($_FILES['img'] as $key => $value) {
	$img1[$key] = $value[0];
	$img2[$key] = $value[1];
	$img3[$key] = $value[2];
}
$poster = $_FILES['poster'];
$preview = $_FILES['preview'];
$price = $_POST['price'];
include "check_img.php";
check_img($img1);
check_img($img2);
check_img($img3);
check_img($poster);
check_img($preview);

if (strstr($trailer, "https://www.youtube.com/watch?v"))
	$trailer = substr(strrchr($trailer, '='), 1);
$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root');
if ($new_country)
{
	$add_new_country = $connection->prepare("INSERT INTO country (name) values (:name)");
	$add_new_country->execute([':name' => $new_country]);
	$country = $connection->lastInsertId();
}
$sql = "INSERT INTO film(title, `release`, country_id, rate, discription, trailer, price,role ,director) VALUES (:title, :release, :country, :rate, :discription, :trailer, :price,:role ,:director)";
$query = $connection->prepare($sql);
$query->execute([':title'=>$title, 'release'=>$release, 'country'=>$country, 'rate'=>$rate, 'discription'=>$discription, 'trailer'=>$trailer, 'price'=>$price,'role'=>$role ,'director'=>$director]);
$last_id = $connection->lastInsertId();
if (!is_dir('../srcs/images/'.$last_id))
{
  mkdir('../srcs/images/'.$last_id);
}

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

insert_list($genre, $last_id, $connection, "genre_list", "film_id", "genre_id");
insert_list($category, $last_id, $connection, "category_list", "film_id", "category_id");


move_uploaded_file($img1['tmp_name'], "../srcs/images/$last_id/img1");
move_uploaded_file($img2['tmp_name'], "../srcs/images/$last_id/img2");
move_uploaded_file($img3['tmp_name'], "../srcs/images/$last_id/img3");
move_uploaded_file($poster['tmp_name'], "../srcs/images/$last_id/poster");
move_uploaded_file($preview['tmp_name'], "../srcs/images/$last_id/preview");
$connection = null;
header("location: adm_panel.php");
?>