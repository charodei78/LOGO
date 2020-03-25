<?php 
$ids = $_POST['row'];


$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'DELETE FROM films WHERE id = :id';
$query = $connection->prepare($sql);
foreach($ids as $id)
{
	$query->execute(array(':id'=> $id));
}
$connection = null;
header("Location: adm_panel.php")
?>