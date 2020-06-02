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
		$category_tmp = "";
		$line_tmp = 0;

		for ($i=0; $i < count($data); $i++) { 
			if ($category_tmp != $data[$i]["category"])
			{
				$line_tmp++;
				$category_tmp = $data[$i]["category"];
				echo "<div class='content' id='line_".$line_tmp."'>
				<h1>".$category_tmp."</h1>";
			}
			echo '<div class="preview" style="background-image: url(srcs/images/'.$data[$i]['id'].'/preview)" onclick="location.href = `/page?id='.$data[$i]['id'].'`">
					<div class="poster_info"><h2>'.$data[$i]['title'].'</h2>
						<div class="poster_info_params">'.$data[$i]['country'].' '.$data[$i]['year'].'<span>'.$data[$i]['price'].'р</span></div>
					</div>
				</div>';
			if ($category_tmp != $data[$i + 1]["category"])
			{
				echo '<button onclick="scrollSide('.$line_tmp - 1.', 0)" style="left: -1%"><</button> <button onclick="scrollSide('.$line_tmp - 1.', 	true)" style="right: -2%">></button>
					</div>';
			}
		}
		?>
		<!-- <h1>Фильмы</h1>

		<div class="preview" style="background-image: url(srcs/images/2/preview)" onclick="location.href = 'page.html'">
			<div class="poster_info"><h2>Аватар</h2>
				<div class="poster_info_params">США 2016<span>1000р</span></div>
			</div>
		</div>
		<div class="preview" style="background-image: url(srcs/images/1/preview)" onclick="location.href = 'page.html'">
			<div class="poster_info"><h2>Аватар</h2>
				<div class="poster_info_params">США 2016<span>1000р</span></div>
			</div>
		</div> -->
<!-- 

			<div class="preview" style="background-image: url(srcs/images/2/preview)" onclick="location.href = 'page.html'">
				<div class="poster_info"><h2>Аватар</h2>
					<div class="poster_info_params">США 2016<span>1000р</span></div>
				</div>
			</div>
			<button onclick="scrollSide(0, 0)" style="left: -1%"><</button> <button onclick="scrollSide(0, true)" style="right: -2%">></button>
		</div>
 -->
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