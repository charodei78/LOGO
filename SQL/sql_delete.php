<?php 
$ids = $_GET['id'];

function recursiveRemoveDir($dir) {
	$includes = glob($dir.'/*');

	foreach ($includes as $include) {
		if (is_dir($include))
			recursiveRemoveDir($include);
		else
			unlink($include);
	}
	rmdir($dir);
}

$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'DELETE FROM film WHERE id in (:id)';
$query = $connection->prepare($sql);
$query->execute(array(':id'=> implode(',', $ids)));
$connection = null;
foreach ($ids as $dir) {
	recursiveRemoveDir("../srcs/images/".$dir);
}
header("Location: adm_panel.php")
?>