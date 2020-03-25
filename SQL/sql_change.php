<?php
		$id = $_POST['id'];
		$name = $_POST['name'];
    	$year = $_POST['year'];
    	$country = $_POST['country'];
    	$rate = $_POST['rate'];
    	$discription = $_POST['discription'];
    	$trailer = $_POST['trailer'];
    	$price = $_POST['price'];
      $role = $_POST['role'];
      $director = $_POST['director'];
      $genre = $_POST['genre'];
      $kp_link = $_POST['kp_link'];
      $connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '');
      $sql = 'UPDATE films SET name = :name, year = :year, country = :country, rate = :rate, discription = :discription, role = :role, director = :director, trailer = :trailer, price = :price, genre = :genre, kp_link = :kp_link WHERE id = :id';
      $query = $connection->prepare($sql);
      $query->execute([':name'=>$name, 'year'=>$year, 'country'=>$country, 'rate'=>$rate, 'discription'=>$discription, 'role'=>$role, 'director'=>$director, 'trailer'=>$trailer, 'price'=>$price, 'genre'=>$genre, 'kp_link'=>$kp_link, 'id'=>$id]);
      header("Location: adm_panel.php");
?>