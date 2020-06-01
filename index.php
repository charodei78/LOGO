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
		<div class="content" id="line_1">
			<h1>Фильмы</h1>

			<!-- <img class="preview"  onclick="location.href = 'page?id=1'" src="srcs/images/1/preview"> -->
			<div class="preview" style="background-image: url(srcs/images/2/preview)" onclick="location.href = 'page.html'">
				<div class="poster_info"><h2>Аватар</h2>
					<div class="poster_info_params">США 2016<span>1000р</span></div>
				</div>
			</div>
			<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'">
				<div class="poster_info"><h2>Аватар</h2>
					<div class="poster_info_params">США 2016<span>1000р</span></div>
				</div>
			</div>
			<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'"></div>
			<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'"></div>
			<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'"></div>
			<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'"></div>
<!-- 
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img  onclick="location.href = 'page.html'" src="srcs/images/1/preview">
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a>
			<img src="srcs/images/1/preview"></a> -->
			
			
			
			<button onclick="scrollSide(0, 0)" style="left: -1%"><</button> <button onclick="scrollSide(0, true)" style="right: -2%">></button>
			
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
		<?php include "srcs/modules/search.html"; ?>
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