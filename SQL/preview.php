<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="../page/page_style.css">
	<meta charset="utf-8">
	<?php
		$options = array(
						PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		  );
		try 
		{
			$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
		}
		catch (Exception $e) 
		{
		   exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
			location.href=location.href;</script>');
		}
		$stmt = $connection->query("SELECT * FROM genre WHERE id in (".implode(',', $_POST['genre']).")");
		if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить список жанров, попробуйте перезагрузить страницу: ");
			location.href=location.href;</script>');
		$genre = $stmt->fetchAll();
		if ($_POST['new_country'])
			$country = $_POST['new_country'];
		else
		{
			$stmt = $connection->query("SELECT name FROM country WHERE id =".intval($_POST['country']));
			if (!$stmt)
				exit('<script type="text/javascript">alert("Не удалось загрузить список стран, попробуйте перезагрузить страницу: ");
				location.href=location.href;</script>');
			$country = ($stmt->fetchAll())[0]['name'];
		}
		$name = $_POST['title'];
		$year = explode('-', ($_POST['release']))[0];
		$rate = $_POST['rate'];
		$discription = $_POST['discription'];
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
		$role = explode(',', $_POST['role']);
		$director = explode(',',$_POST['director']);
		include "check_img.php";
		check_img($img1);
		check_img($img2);
		check_img($img3);
		check_img($poster);
		check_img($preview);
		move_uploaded_file($img1['tmp_name'], "../srcs/images/tmp/img1");
		move_uploaded_file($img2['tmp_name'], "../srcs/images/tmp/img2");
		move_uploaded_file($img3['tmp_name'], "../srcs/images/tmp/img3");
		move_uploaded_file($poster['tmp_name'], "../srcs/images/tmp/poster");
		move_uploaded_file($preview['tmp_name'], "../srcs/images/tmp/preview");
		if (strstr($trailer, "https://www.youtube.com/watch?v"))
			$trailer = 'https://www.youtube.com/embed/'.substr(strrchr($trailer, '='), 1);
	?>
	<title><?php echo $name; ?></title>
</head>
<body>
	<img id="poster" src="../srcs/images/tmp/poster">
	<img id="shadow" src="../srcs/ico/shadow.png">
	<div id="header_wrapper">
		<div id="header">
			<div id="logo"><a href="/">Logo</a></div>
			<div id="menu">
			  	<ul>
					<li><a href="#">новинки</a></li>
					<li><a href="#">жанры</a></li>
					<li><a href="#">рекомендуем</a></li>
				</ul>
			</div>
			<sdiv id="search_wrapper">
			  <?php include "../srcs/modules/search.html" ?>
			</div>
		</div>a
	</div>
	<div id="name">
		<div id="title"><?php echo $name; ?></div>
		<!-- <a href="http://www.kinopoisk.ru/film/<?php echo $kp_link; ?>.gif"><img style="height: 35px;" src="http://www.kinopoisk.ru/rating/<?php echo $kp_link; ?>.gif"> </a> -->
		<p><?php echo $year."г ".$country." ".$rate."+"?></p>
	</div>
	</div>
	<div id="navibar">
		<div><a class="navibar" href="#discription"><img src="../srcs/ico/discription.png"></a></div>
		<div><a class="navibar" href="#gallery"><img src="../srcs/ico/gallery.png"></a></div>
		<div><a class="navibar" href="#info"><img src="../srcs/ico/info.png"></a></div>
		<div id="price"><a href="#"><button><?php echo $price; ?> ₽</button> </a></div> 
	</div>
	<br>
<div class="anchor" id="discription"></div>
	<div class="space"></div>
	<div class="content" style="margin-top: 250px">
		<?php  echo $discription; ?>
	</div>
<div class="anchor"  id="gallery"></div>
	<br>
	<br>
	<div class="content" >
		<iframe width="100%" height="50%" src="<?php echo $trailer ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
		<div id="galleryImg">
			<div class="galleryImg" style="background-image: url(../srcs/images/tmp/img1)"></div>
			<div class="galleryImg" style="background-image: url(../srcs/images/tmp/img2)"></div>
			<div class="galleryImg" style="background-image: url(../srcs/images/tmp/img3)"></div>
		</div>
	</div>
<div class="anchor"  id="info"></div>
	<br>
	<br>
	<div class="content" id="info_block">
		<div>
			<p>В ролях </p><br>
			<?php foreach ($role as $value) { echo trim($value)."<br>";}?>
		</div>
		<div id='right_info_block'>
			<div>
				<p>Режисеры</p> <br>
				<?php foreach ($director as $value) { echo trim($value)."<br>";}?>
			</div>
			<br>
			<div>
				<p>Жарны</p> <br>
				<?php foreach ($genre as $value) { echo trim($value['name'])."<br>";}?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("body").on('click', '[href*="#"]', function(e){
			var fixed_offset = 110;
			$('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 1000);
			e.preventDefault();
		}); // TODO: пеерписать скрипт
	</script>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="../page/page_style.css">
	<meta charset="utf-8">
	<?php
		$options = array(
						PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		  );
		try 
		{
			$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
		}
		catch (Exception $e) 
		{
		   exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
			location.href=location.href;</script>');
		}
		$stmt = $connection->query("SELECT * FROM genre WHERE id in (".implode(',', $_POST['genre']).")");
		if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить список жанров, попробуйте перезагрузить страницу: ");
			location.href=location.href;</script>');
		$genre = $stmt->fetchAll();
		if ($_POST['new_country'])
			$country = $_POST['new_country'];
		else
		{
			$stmt = $connection->query("SELECT name FROM country WHERE id =".intval($_POST['country']));
			if (!$stmt)
				exit('<script type="text/javascript">alert("Не удалось загрузить список стран, попробуйте перезагрузить страницу: ");
				location.href=location.href;</script>');
			$country = ($stmt->fetchAll())[0]['name'];
		}
		$name = $_POST['title'];
		$year = explode('-', ($_POST['release']))[0];
		$rate = $_POST['rate'];
		$discription = $_POST['discription'];
		$trailer = $_POST['trailer'];
		$img1 = $_FILES['img1'];
		$img2 = $_FILES['img2'];
		$img3 = $_FILES['img3'];
		$poster = $_FILES['poster'];
		$preview = $_FILES['preview'];
		$price = $_POST['price'];
		$role = explode(',', $_POST['role']);
		$director = explode(',',$_POST['director']);
		include "check_img.php";
		check_img($img1);
		check_img($img2);
		check_img($img3);
		check_img($poster);
		check_img($preview);
		move_uploaded_file($img1['tmp_name'], "../srcs/images/tmp/img1");
		move_uploaded_file($img2['tmp_name'], "../srcs/images/tmp/img2");
		move_uploaded_file($img3['tmp_name'], "../srcs/images/tmp/img3");
		move_uploaded_file($poster['tmp_name'], "../srcs/images/tmp/poster");
		move_uploaded_file($preview['tmp_name'], "../srcs/images/tmp/preview");
		if (strstr($trailer, "https://www.youtube.com/watch?v"))
			$trailer = 'https://www.youtube.com/embed/'.substr(strrchr($trailer, '='), 1);
	?>
	<title><?php echo $name; ?></title>
</head>
	<body>
	<img id="poster" src="../srcs/images/tmp/poster">
	<img id="shadow" src="../srcs/ico/shadow.png">
	<div id="header_wrapper">
		<div id="header">
			<div id="logo"><a href="file:../html.html">Logo</a></div>
			<div id="menu">
			  	<ul>
					<li><a href="#">новинки</a></li>
					<li><a href="#">жанры</a></li>
					<li><a href="#">рекомендуем</a></li>
				</ul>
			</div>
			<sdiv id="search_wrapper">
			  <?php include "../srcs/modules/search.html" ?>
			</div>
		</div>a
	</div>
	<div id="name">
		<div id="title"><?php echo $name; ?></div>
		<!-- <a href="http://www.kinopoisk.ru/film/<?php echo $kp_link; ?>.gif"><img style="height: 35px;" src="http://www.kinopoisk.ru/rating/<?php echo $kp_link; ?>.gif"> </a> -->
		<p><?php echo $year."г ".$country." ".$rate."+"?></p>
	</div>
	</div>
	<div id="navibar">
		<div><a class="navibar" href="#discription"><img src="../srcs/ico/discription.png"></a></div>
		<div><a class="navibar" href="#gallery"><img src="../srcs/ico/gallery.png"></a></div>
		<div><a class="navibar" href="#info"><img src="../srcs/ico/info.png"></a></div>
		<div id="price"><a href="#"><button><?php echo $price; ?> ₽</button> </a></div> 
	</div>
	<br>
<div class="anchor" id="discription"></div>
	<div class="content" style="margin-top: 250px">
		<?php  echo $discription; ?>
	</div>
<div class="anchor"  id="gallery"></div>
	<div class="content" style="margin-top: 400px">
		<iframe width="100%" height="50%" src="<?php echo $trailer ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><div class="galleryImg"><img src="../srcs/images/tmp/img1" ><img src="../srcs/images/tmp/img2"><img src="../srcs/images/tmp/img3"></div>
	</div>
<div class="anchor"  id="info"></div>
	<br>
	<div class="content" id="info_block" style="margin-top: 100px">
		<div>
			<p>В ролях </p><br>
			<?php foreach ($role as $value) { echo trim($value)."<br>";}?>
		</div>
		<div id='right_info_block'>
			<div>
				<p>Режисеры</p> <br>
				<?php foreach ($director as $value) { echo trim($value)."<br>";}?>
			</div>
			<br>
			<div>
				<p>Жарны</p> <br>
				<?php foreach ($genre as $value) { echo trim($value['name'])."<br>";}?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		// $("body").on('click', '[href*="#"]', function(e){
		// 	var fixed_offset = 110;
		// 	$('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 1000);
		// 	e.preventDefault();
		// }); // TODO: пеерписать скрипт
	</script>
</body>
</html>
 -->