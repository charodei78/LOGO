<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
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
	$stmt = $connection->query("SELECT id, name as country FROM country ORDER BY country;");
	if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о странах, попробуйте перезагрузить страницу: ");
			</script>');
	$country_list = $stmt->fetchAll();
	$stmt = $connection->query('SELECT * FROM category');
	if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о категориях, попробуйте перезагрузить страницу: ");
			</script>');
	$category_list = $stmt->fetchAll();
	$stmt = $connection->query('SELECT * FROM genre');
	if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о жанрах, попробуйте перезагрузить страницу: ");
			</script>');
	$genre_list = $stmt->fetchAll();
	?>
	<div id="sidebar_background">
		<div id="sidebar_wrapper">
			<div class="sidebar"><img onclick="location.href = '/?category=2'" src="srcs/ico/films.png"></a></div>
			<div class="sidebar"><img onclick="location.href = '/?category=3'" src="srcs/ico/serials.png"></a></div>
			<div class="sidebar"><img onclick="location.href = '/?category=1'" src="srcs/ico/new.png"></a></div>
			<div class="sidebar" onclick="filter_menu.style.visibility = 'hidden'; category_menu.style.visibility == 'hidden' ? category_menu.style.visibility = 'visible' : category_menu.style.visibility = 'hidden'"><img src="srcs/ico/categories.png"></div>
			<div class="sidebar" onclick="category_menu.style.visibility = 'hidden';filter_menu.style.visibility == 'hidden' ? filter_menu.style.visibility = 'visible' : filter_menu.style.visibility = 'hidden'"><img src="srcs/ico/filter.png"></div>
		</div>
	</div>
	<div id="content_wrapper">
		<?php
		$category = intval($_GET['category']);
		$genre = intval($_GET['genre']);
		if ($category)
		{
			$stmt = $connection->query('SELECT film.id as id, title, genre.name as category, country.name as country, `release`, price  FROM genre_list
												LEFT JOIN genre ON genre.id = genre_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												LEFT JOIN category_list ON category_list.film_id = film.id
												WHERE category_list.category_id = '.$category.'
												ORDER BY genre.id
												');
		}
		elseif ($genre)
		{
			$stmt = $connection->query('SELECT film.id as id, title, country.name as country, `release`, price  FROM genre_list
												LEFT JOIN genre ON genre.id = genre_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												WHERE `genre_list`.genre_id = '.$genre.'
												ORDER BY genre.id
												');
		}
		else
		{
			$stmt = $connection->query('SELECT film.id as id, title, category.name as category, country.name as country, `release`, price  FROM category_list
												LEFT JOIN category ON category.id = category_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												ORDER BY category.id
												');
		}
		if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о товарах, попробуйте перезагрузить страницу: ");
			location.href=location.href;</script>');
		$data = $stmt->fetchAll();
		$category_tmp = "";
		$line_tmp = 0;
		if (!$genre)
		{
			for ($i=0; $i < count($data); $i++) 
			{ 
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
		}
		else
		{
			echo "<div class='content' style='flex-wrap: wrap; height: auto;justify-content: space-around;'>
				<h1>".$genre_list[$genre - 1]['name']."</h1>";
			for ($i=0; $i < count($data); $i++) 
			{
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
			}
			echo "</div>";
		}
		$connection = null;
		?>
	</div>
	<div id="search_wrapper">
		<?php include "srcs/modules/search.html"; ?>
	</div>
	<?php include "srcs/modules/cart_button.php" ?>
	<div id="category_menu" class="side_menu">
		<ul>
			<p>Жанры</p>
			<?php foreach ($genre_list as $value) 
			{
				echo "<a href='?genre=".$value['id']."'><li>".$value['name']."</a>";
			} 
			 ?>
		</ul>
		<ul>
			<p>Категории</p>
			<?php foreach ($category_list as $value) 
			{
				echo "<a href='?category=".$value['id']."'><li>".$value['name']."</a>";
			} 
			 ?>
		</ul>
	</div>
	<div id="filter_menu" class="side_menu">
		<form action="/">
		<br><h1>Фильтры</h1>
		<div class="filter_menu">
			Цена
			<div>
				<div>
					<h4 class="from_to_title">от</h4>
					<input type="number" min="0" max="999" name="price_min">
				</div>
				<div>
					<h4 class="from_to_title">до</h4>
					<input type="number" min="0" max="999" name="price_max">
				</div>
			</div>
		</div>
		<div class="filter_menu">
			Год
			<div>
				<div>
					<h4 class="from_to_title">от</h4>
					<input type="number" min="0" max="999" name="price_min">
				</div>
				<div>
					<h4 class="from_to_title">до</h4>
					<input type="number" min="0" max="999" name="price_max">
				</div>
			</div>
		</div>
		<div class="filter_menu">
			Страна
			<div>
				<select name="country" size="1" id="country_selector" required>
					<option value="none" selected disabled hidden>Страна</option>
						<?php 
							for ($i=0; $i < count($country_list); $i++) { 
								echo "<option value='".$country_list[$i]['id']."'>".$country_list[$i]['country']."</option>";
							}
						 ?>
					</select>
			</div>
		</div>
		<div class="filter_menu">
			Возрастной рейтинг
			<div>
				<select name="rate" size="1" required>
					<option value="none" selected disabled hidden>
					Выберите </option> 
					<option value="0">0+</option>
					<option value="3">3+</option>
					<option value="7">7+</option>
					<option value="12">12+</option>
					<option value="16">16+</option>
					<option value="18">18+</option>
				</select>
			</div>
		</div>
		</form>
	</div>
	<script type="text/javascript">
		filter_menu.style.visibility = 'hidden';
		category_menu.style.visibility = 'hidden';
		recount();
		contentList = document.getElementsByClassName('content');
		function scrollSide (contentId, side)
		{
			if (side)
				contentList[contentId].scrollLeft += 350;
			else
				contentList[contentId].scrollLeft -= 350;
		}
	</script>
</body>
</html>