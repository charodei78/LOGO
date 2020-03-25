<?php

		$name = $_POST['name'];
    	$year = $_POST['year'];
    	$country = $_POST['country'];
    	$rate = $_POST['rate'];
    	$discription = $_POST['discription'];
    	$trailer = $_POST['trailer'];
    	$img1 = $_FILES['img1'];
    	$img2 = $_FILES['img2'];
    	$img3 = $_FILES['img3'];
    	$poster = $_FILES['poster'];
    	$price = $_POST['price'];
      $role = $_POST['role'];
      $director = $_POST['director'];
      $genre = $_POST['genre'];
      $kp_link = $_POST['kp_link'];
      include "check_img.php";
      check_img($img1, $name);
      check_img($img2, $name);
      check_img($img3, $name);
      check_img($poster, $name);

      $connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '');
      $sql = 'INSERT INTO films(name, year, country, rate, discription, trailer, img1, img2, img3, poster, price,role ,director, genre, kp_link) VALUES(:name, :year, :country, :rate, :discription, :trailer, :img1, :img2, :img3, :poster, :price,:role ,:director, :genre, :kp_link)';
      $query = $connection->prepare($sql);
      $query->execute([':name'=>$name, 'year'=>$year, 'country'=>$country, 'rate'=>$rate, 'discription'=>$discription, 'trailer'=>$trailer, 'img1'=>$img1['name'], 'img2'=>$img2['name'], 'img3'=>$img3['name'], 'poster'=>$poster['name'], 'price'=>$price,'role'=>$role ,'director'=>$director, 'genre'=>$genre, 'kp_link'=>$kp_link]);
      header("Location: adm_panel.php");
?>