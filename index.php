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
	$stmt = $connection->query('SELECT id, name FROM category');
	if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о категориях, попробуйте перезагрузить страницу: ");
			</script>');
	$category_list = $stmt->fetchAll();
	$stmt = $connection->query('SELECT id, name FROM genre INNER JOIN genre_list ON genre_id = id GROUP BY id');
	if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о жанрах, попробуйте перезагрузить страницу: ");
			</script>');
	$genre_list = $stmt->fetchAll();
	?>
	<div id="sidebar_background">
		<div id="logo"><a href="/">Logo</a></div>
		<div id="sidebar_wrapper">
			<div class="sidebar"><img onclick="location.href = '/?category=2'" src="srcs/ico/films.png"></a></div>
			<div class="sidebar"><img onclick="location.href = '/?category=3'" src="srcs/ico/serials.png"></a></div>
			<div class="sidebar"><img onclick="location.href = '/?category=1'" src="srcs/ico/new.png"></a></div>
			<div class="sidebar" onclick="filter_menu.style.visibility = 'hidden'; result.style.visibility = 'hidden'; category_menu.style.visibility == 'hidden' ? category_menu.style.visibility = 'visible' : category_menu.style.visibility = 'hidden'"><img src="srcs/ico/categories.png"></div>
			<div class="sidebar" onclick="category_menu.style.visibility = 'hidden';result.style.visibility = 'hidden';filter_menu.style.visibility == 'hidden' ? filter_menu.style.visibility = 'visible' : filter_menu.style.visibility = 'hidden'"><img src="srcs/ico/filter.png"></div>
		</div>
	</div>
	<div id="content_wrapper">
		<?php
		$category = intval($_GET['category']);
		$genre = intval($_GET['genre']);
		$price_min = intval($_GET['price_min']);
		$price_max = intval($_GET['price_max']);
		$release_min = intval($_GET['release_min']);
		$release_max = intval($_GET['release_max']);
		$country = intval($_GET['country']);
		$rate = intval($_GET['rate']);
		if ($category && $genre)
		{
			$prequery = 'SELECT film.id as id, title, genre.name as category, country.name as country, `release`, price  FROM genre_list
												LEFT JOIN genre ON genre.id = genre_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												LEFT JOIN category_list ON category_list.film_id = film.id
												WHERE category_list.category_id = '.$category.'
												AND `genre_list`.genre_id = '.$genre.'' ;
		}
		elseif ($category)
		{
			$prequery = 'SELECT film.id as id, title, genre.name as category, country.name as country, `release`, price  FROM genre_list
												LEFT JOIN genre ON genre.id = genre_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												LEFT JOIN category_list ON category_list.film_id = film.id
												WHERE category_list.category_id = '.$category.'
												';
		}
		elseif ($genre)
		{
			$prequery = 'SELECT film.id as id, title, country.name as country, `release`, price  FROM genre_list
												LEFT JOIN genre ON genre.id = genre_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												WHERE `genre_list`.genre_id = '.$genre.'
												';
		}
		else
		{
			$prequery = 'SELECT film.id as id, title, category.name as category, country.name as country, `release`, price  FROM category_list
												LEFT JOIN category ON category.id = category_id 
												LEFT JOIN film ON film.id = film_id
												LEFT JOIN country ON film.country_id = country.id
												WHERE film.id > 0';
		}
		
		if ($price_min)
			$prequery = $prequery." AND `price` >=".$price_min;
		if ($price_max)
		{
			if ($price_max >= $price_min)
				$prequery = $prequery." AND `price` <=".$price_max;
			else
				$prequery = $prequery." OR `price` <=".$price_max;
		}
		if ($release_min)
			$prequery = $prequery." AND `release` >=".$release_min;
		if ($release_max)
		{
			if ($release_max >= $release_min)
				$prequery = $prequery." AND `release` <=".$release_max;
			else
				$prequery = $prequery." OR `release` <=".$release_max;
		}
		if ($country)
			$prequery = $prequery." AND country_id = ".$country;
		if ($rate)
			$prequery = $prequery." AND rate >= ".$rate;
		if ($category && !$genre)
			$prequery = $prequery." ORDER BY genre.id, rand()";
		elseif (!$genre) 
			$prequery = $prequery." ORDER BY category.id, rand()";
		$stmt = $connection->query($prequery);
		if (!$stmt)
			exit('<script type="text/javascript">alert("Не удалось загрузить информацию о товарах, попробуйте перезагрузить страницу: ");
			location.href=location.href;</script>');
		$data = $stmt->fetchAll();
		
		$category_tmp = "";
		$line_tmp = 0;
		if ($data == array())
		{
			echo "<div class='content' style='flex-wrap: wrap; height: auto;justify-content: space-around;'>
				<h1 style='text-transform: none; margin-top: -20px'>Ничего не найдено</h1>";
		}
		elseif (!$genre)
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
					echo '<button onclick="scrollSide('.$line_tmp.', 0)" style="left: -1%"><center style="padding-left: 5px;"><div style="transform: rotate(-135deg);padding-: 5px;"></div></center></button> <button onclick="scrollSide('.$line_tmp.', true)" style="right: -2%"><center style="padding-right: 5px;"><div></div></center></button>
						</div>';
					$line_tmp++;

				}
			}
		}
		else
		{
			echo "<div class='content' style='flex-wrap: wrap; height: auto;justify-content: space-around;'>
				<h1 id='conten_title'></h1>";
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
	<div id="header_shadow"></div>
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
		<form action="/" onreset="clearElemValue('#filter_menu input')">
		<br><h1 style="margin-top: 0">Фильтры</h1>
		<div class="filter_menu">
			Цена
			<div>
				<div>
					<h4 class="from_to_title">от</h4>
					<input type="number" value="<?php echo $price_min ? $price_min : '' ?>" min="0" max="9999" name="price_min">
				</div>
				<div>
					<h4 class="from_to_title">до</h4>
					<input type="number" value="<?php echo $price_max ? $price_max : '' ?>" min="0" max="9999" name="price_max">
				</div>
			</div>
		</div>
		<div class="filter_menu">
			Год
			<div>
				<div>
					<h4 class="from_to_title">от</h4>
					<input type="number" value="<?php echo $release_min ? $release_min : '' ?>" min="1950" max="2020" name="release_min">
				</div>
				<div>
					<h4 class="from_to_title">до</h4>
					<input type="number" value="<?php echo $release_max ? $release_max : '' ?>" min="1950" max="2020" name="release_max">
				</div>
			</div>
		</div>
		<div class="filter_menu">
			Страна
			<div>
				<select name="country" size="1" id="country_selector">
					<option value="none" selected style="background-color: black">Страна</option>
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
				<h4 class="from_to_title">от</h4>
				<select name="rate" size="1">
					<option value="" style="background-color: black" selected>
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
		<div class="filter_menu">
			Жанр
			<div>
				<select name="genre" size="1" id="genre_selector">
					<option value="none" selected style="background-color: black">Жанр</option>
					<?php foreach ($genre_list as $value) 
					{
						echo "<option value='".$value['id']."'>".$value['name']."</option>";
					} 
					 ?>
				</select>
			</div>
		</div>
		<div class="filter_menu">
			Категория
			<div>
				<select name="category" size="1">
					<option value="none" selected style="background-color: black">Категория </option>
					<?php foreach ($category_list as $value) 
					{
						echo "<option value='".$value['id']."'>".$value['name']."</option>";
					} 
					 ?>
				</select>
			</div>
		</div>
		<button type="reset" style="left: 25px">Сбросить</button>
		<button onclick="disableEmptyField()">Применить</button>
		</form>
	</div>
	<script type="text/javascript">
		recount();

		filter_menu.style.visibility = 'hidden';
		category_menu.style.visibility = 'hidden';
		var country = <?php echo $country; ?>;
		var rate = <?php echo $rate; ?>;
		var genre = <?php echo $genre; ?>;
		var category = <?php echo $category; ?>;
		var selectors = document.getElementsByTagName("select");
		var search_field = document.getElementById('search_field');

		search_field.onclick = function()
		{
			category_menu.style.visibility = 'hidden';
			filter_menu.style.visibility = 'hidden';
		}

		for (var i = 0; i < selectors.length; i++)
		{
			for (var j = 0; j < selectors[i].children.length; j++)
			{
				if (selectors[i].name == "country" && selectors[i].children[j].value == country)
				{
					selectors[i].children[j].selected = true;
					break ;
				}
				if (selectors[i].name == "rate" && selectors[i].children[j].value == rate)
				{
					selectors[i].children[j].selected = true;
					break ;
				}
				if (selectors[i].name == "genre" && selectors[i].children[j].value == genre)
				{
					selectors[i].children[j].selected = true;
						if (document.getElementById('conten_title'))
							conten_title.innerHTML = selectors[i].children[j].innerHTML;
					break ;
				}
				if (selectors[i].name == "category" && selectors[i].children[j].value == category)
				{
					selectors[i].children[j].selected = true;
					break ;
				}
			}
		}

		function clearElemValue(selectorName)
		{
			var elements = document.querySelectorAll(selectorName);
			for (var i = elements.length - 1; i >= 0; i--)
			{
				elements[i].removeAttribute("value");
			}
		}

		function disableEmptyField()
		{
			var fields = document.querySelectorAll("#filter_menu input");
			for (var i = fields.length - 1; i >= 0; i--)
			{
				if (!fields[i].value)
					fields[i].removeAttribute("name");
			}
			for (var i = selectors.length - 1; i >= 0; i--)
			{
				if (!selectors[i].value || selectors[i].value == 'none')
					selectors[i].removeAttribute("name");
			}
		}

		contentList = document.getElementsByClassName('content');
		function scrollSide (contentId, side)
		{
			if (side)
				contentList[contentId].scrollLeft += contentList[contentId].offsetWidth - (contentList[contentId].offsetWidth % 355) + 20;
			else
				contentList[contentId].scrollLeft -= contentList[contentId].offsetWidth - (contentList[contentId].offsetWidth % 355) + 20;
		}
	</script>
</body>
</html>