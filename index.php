<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<div id="sidebar_background">
		<div id="sidebar_wrapper">
		<div class="sidebar"><a href="#"><img src="srcs/ico/films.png"></a></div>
		<div class="sidebar"><a href="#"><img src="srcs/ico/serials.png"></a></div>
		<div class="sidebar"><a href="#"><img src="srcs/ico/new.png"></a></div>
		<div class="sidebar"><a href="#"><img src="srcs/ico/categories.png"></a></div>
		</div>
	</div>
	<div id="content_wrapper">
		<?php
		$options = array(
			PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC
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
		$stmt = $connection->query('SELECT film.id as id, title, category.name as category, country.name as country, `release`, price  FROM category_list
												LEFT JOIN category ON category.id = category_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												ORDER BY category.id
												');
		if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о данном фильме, попробуйте перезагрузить страницу: ");
			location.href=location.href;</script>');
		$data = $stmt->fetchAll();
		$category_tmp = "";
		$line_tmp = 0;

		for ($i=0; $i < count($data); $i++) { 
			if ($category_tmp != $data[$i]["category"])
			{
				$category_tmp = $data[$i]["category"];
				echo "<div class='content' id='line_".$line_tmp."'>
				<h1>".$category_tmp."</h1>";
			}
			echo '<div class="preview" style="background-image: url(srcs/images/'.$data[$i]['id'].'/preview)" onclick="location.href = `/page?id='.$data[$i]['id'].'`">
					<div class="poster_info"><h2';
			$strlen_tmp = mb_strlen($data[$i]['title']);
			if ($strlen_tmp > 25 && $strlen_tmp < 35)
				echo ' class="marquee_1"';
			else if ($strlen_tmp >= 35)
				echo ' class="marquee_2"';
			echo '>'.$data[$i]['title'].'</h2><div class="poster_info_params">'.$data[$i]['country'].' '.$data[$i]['release'].'<span>'.$data[$i]['price'].'р</span></div>
					</div>
				</div>';
			if ($category_tmp != $data[$i + 1]["category"])
			{
				echo '<button onclick="scrollSide('.$line_tmp.', 0)" style="left: -1%"><</button> <button onclick="scrollSide('.$line_tmp.', true)" style="right: -2%">></button>
					</div>';
				$line_tmp++;

			}
		}
		?>
	</div>
	<div id="search_wrapper">
		<?php include "srcs/modules/search.html"; ?>
	</div>
		<iframe scrolling="no"  id="cart" src="/srcs/modules/cart.php" width="448" height="10" align="center">
		Ваш браузер не поддерживает плавающие фреймы! Используйте актуальную версию браузера!
	</iframe>

	<button id="cart_button"  onclick="showCart()">Корзина</button>


	<script type="text/javascript">
		
		contentList = document.getElementsByClassName('content');
		function scrollSide (contentId, side)
		{
			if (side)
				contentList[contentId].scrollLeft += 350;
			else
				contentList[contentId].scrollLeft -= 350;
		}

		function showCart()
		{

			cart.src = cart.src;
			cart.style.visibility = 'visible';
			setTimeout('cart.height = parseInt(window.frames[0].height) + 45;cart.style.opacity = 1; cart.style.margin = "calc((100vh - " + window.frames[0].height + ") / 2) 36vw";', 500); 				
		}

		function closeCart()
		{
			cart.style.opacity = 0;
			cart.style.visibility = 'hidden';
			cart.style.marginTop = 0;
			setTimeout('cart.height = 10 ', 500); 
		}
	</script>
</body>
</html>