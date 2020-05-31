<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<div id="sidebar_background">
		<div id="sidebar_wrapper">
		<div class="sidebar"><a href="#"><img src="../srcs/ico/films.png"></a></div>
		<div class="sidebar"><a href="#"><img src="../srcs/ico/serials.png"></a></div>
		<div class="sidebar"><a href="#"><img src="../srcs/ico/new.png"></a></div>
		<div class="sidebar"><a href="#"><img src="../srcs/ico/categories.png"></a></div>
		</div>
	</div>
	<div id="content_wrapper">
		<div class="content" id="line_1">
			<h1>Фильмы</h1>
			<button onclick="scrollSide(0, 0)"><</button> <button onclick="scrollSide(0, true)" style="right: -1%">></button>
			<img  onclick="location.href = 'page.html'" src="../srcs/images/1/preview">
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img  onclick="location.href = 'page.html'" src="../srcs/images/1/preview">
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			<img src="../srcs/images/1/preview"></a>
			
			
			
			
		</div>
		<div class="content" id="line_2"><a href="#"></a>
			<h1>Сериалы</h1>
		</div>
		<div class="content" id="line_3"><a href="#"></a>
			<h1>Новинки</h1>
		</div>
		<div class="content" id="line_4"><a href="#"></a>
			<h1>Все</h1>
		</div>
	</div>
	<div id="search_wrapper">
		<?php include "search.html"; ?>
	</div>
	<script type="text/javascript">
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