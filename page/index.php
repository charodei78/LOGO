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
		<div id="price"><button onclick="addToCart(<?php echo $id; ?>)"><?php echo $price; ?> ₽</button></div> 
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
		$("body").on('click', '[href*="#"]', function(e){
			var fixed_offset = 110;
			$('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 800);
			e.preventDefault();
		}); // TODO: пеерписать скрипт
		function addToCart(params)
		{
			var tmpCart = getCookie("cart");
			if (tmpCart)
			{
				var cartList = getCookie("cart").split(',').map(Number);
				for (var i = cartList.length - 1; i >= 0; i--) 
				{
					if (cartList[i] == Number(params))
						return false;
				}
				document.cookie = "cart = " + getCookie("cart") + ", " + Number(params) + ";path=/";
				return;
			}
			document.cookie = "cart = " + getCookie("cart") + Number(params) + ";path=/";
			// recount();
		}

		function getCookie(name) 
		{
		  var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
		  return matches ? decodeURIComponent(matches[1]) : '';
		}

		

		function delete_cookie ( cookie_name )
		{
			if (confirm("Удалить товар из корзины?"))
			{
				var cookie_date = new Date ();
				cookie_date.setTime ( cookie_date.getTime() - 1 );
				document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
			}
		}
	</script>
</body>
</html>
