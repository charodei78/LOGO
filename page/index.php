<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/page/page_style.css">
	<meta charset="utf-8">
	<?php
	$id = $_GET['id'];
	if (is_array($id))
		$id = intval($id[0]);
	else
		$id = intval($id);
	if (!$id)
		exit('<script type="text/javascript">location.href="/404";</script>');
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
	$stmt = $connection->query("SELECT film.id, title, `release`, rate, discription, trailer, director, `role`, price, 
		country.name as country FROM film LEFT JOIN country ON country_id = country.id WHERE film.id =".$id);
	if (!$stmt)
		exit('<script type="text/javascript">alert("Не удалось загрузить информацию о данном фильме, попробуйте перезагрузить страницу: ");
		location.href=location.href;</script>');
	$data = $stmt->fetchAll()[0];
	if ($data == array())
		exit('<script type="text/javascript">location.href="/404";</script>');
	$stmt = $connection->query("SELECT name FROM genre_list LEFT JOIN genre ON genre_id = genre.id WHERE film_id =".$id);
	if (!$stmt)
		exit('<script type="text/javascript">alert("Не удалось загрузить базу жанров, попробуйте перезагрузить страницу: ");
		location.href=location.href;</script>');
	$name = $data['title'];
	$year = explode('-', ($data['release']))[0];
	$country = $data['country'];
	$rate = $data['rate'];
	$discription = $data['discription'];
	$trailer = $data['trailer'];
	$price = $data['price'];
	$genre = $stmt->fetchAll();
	$role = explode(',', $data['role']);
	$director = explode(',',$data['director']);
	$connection = null;
	if (!strstr($trailer, "https://"))
		$trailer = 'https://www.youtube.com/embed/'.$trailer;
	?>
	<title><?php echo $name; ?></title>
</head>
<body>
	<img id="poster" src="../srcs/images/<?php echo $id; ?>/poster">
	<!-- <img id="shadow" src="../srcs/ico/shadow.png"> -->
	<div id="shadow"></div>
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
		<div id="price"><button id="price_button" onclick="addToCart(<?php echo $id; ?>)"><?php echo $price; ?> ₽</button></div> 
	</div>
	<br>
<div class="anchor" id="discription"></div>
	<div class="space"></div>
	<div class="content" style="margin-top: 250px">
		<?php  echo $discription; ?>
	</div>
<div class="anchor"  id="gallery"></div>
	<div class="content" >
		<iframe width="100%" height="50%" src="<?php echo $trailer ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
		<div id="galleryImg">
			<div class="galleryImg" style="background-image: url(../srcs/images/<?php echo $id; ?>/img1)"></div>
			<div class="galleryImg" style="background-image: url(../srcs/images/<?php echo $id; ?>/img2)"></div>
			<div class="galleryImg" style="background-image: url(../srcs/images/<?php echo $id; ?>/img3)"></div>
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

		var price_tmp = price_button.innerHTML;
		checkCart(<?php echo $id; ?>);

		$("body").on('click', '[href*="#"]', function(e){
			var fixed_offset = 110;
			$('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 800);
			e.preventDefault();
		}); // TODO: пеерписать скрипт

		function getCookie(name) 
		{
		  var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
		  return matches ? decodeURIComponent(matches[1]) : '';
		}

		function checkCart(id)
		{
			var cartList = getCookie("cart").split(',').map(Number);
			if (cartList.indexOf(Number(id)) != -1)
			{
				price_button.onclick = function () {rmCartProduct(id)}
				price_button.style.backgroundColor = '#ff4d00';
				price_button.innerHTML = "Убрать";
				return true;
			}
			else
			{
				price_button.onclick = function () {addToCart(id)}
				price_button.style.backgroundColor = '#ffb65e';
				price_button.innerHTML = price_tmp;
				return false;
			}
		}

		function addToCart(id)
		{
			var cartList = getCookie("cart").split(',').map(Number);
			if (checkCart(id))
					return;
			if (cartList[0] == 0)
				cartList[0] = id;
			else
				cartList[cartList.length] = id;
			document.cookie = "cart = " + cartList + ";path=/";
			checkCart(id);
		}

		function rmCartProduct(id)
		{
			var res = (getCookie("cart").split(',').map(Number));
			var index = res.indexOf(parseInt(id));
			if (index < 0)
				return false;
			res.splice(index, 1);
			document.cookie = "cart = " + res.join(',') + ";path=/";
			checkCart(id);
		}

	</script>
</body>
</html>
