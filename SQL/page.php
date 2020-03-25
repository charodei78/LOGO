<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="page_style.css">
    <link rel="stylesheet" type="text/css" href="search.css">
    <meta charset="utf-8">
    <title>Preview</title>
    <?php 
      $id = $_GET['row'];
      $connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '', $options);
      $stmt = $connection->query('SELECT * FROM films WHERE id ='.$id[0]);
      $data = $stmt->fetchAll()[0];
    	$name = $data['name'];
    	$year = $data['year'];
    	$country = $data['country'];
    	$rate = $data['rate'];
    	$discription = $data['discription'];
    	$trailer = $data['trailer'];
    	$img1 = $data['img1'];
    	$img2 = $data['img2'];
    	$img3 = $data['img3'];
    	$poster = $data['poster'];
    	$price = $data['price'];
      $genre = explode(',',$data['genre']);
      $role = explode(',', $data['role']);
      $director = explode(',',$data['director']);
    ?>
  </head>
  <body>
    <img id="poster" src="../srcs/images/<?php echo $name; ?>/<?php echo $poster; ?>">
    <img id="shadow" src="../srcs/ico/shadow.png">
    <div id="wrapper">
    	<div id="header">
        <div id="logo"><a href="file:../html.html">Logo</a></div>
        <div id="menu">
          <ul>
            <li><a href="#">новинки</a></li>
            <li><a href="#">жанры</a></li>
            <li><a href="#">рекомендуем</a></li>
          </ul>
        </div>
        <div id="space"></div>
        <?php include "search.html" ?>
      </div>
      </div>
      <div id="name"> <?php echo $name; ?><p><?php echo $year; ?>г <?php echo $country; ?> <?php echo $rate ?>+</p></div>
    </div>
    <div id="navibar">
      
      <div><a class="navibar" href="#discription"><img src="../srcs/ico/discription.png"></a></div>
      <div><a class="navibar" href="#gallery"><img src="../srcs/ico/gallery.png"></a></div>
      <div><a class="navibar" href="#info"><img src="../srcs/ico/info.png"></a></div>
      <div id="price"><a href="#"><button><?php echo $price; ?> ₽</button> </a></div> 
    </div>
    <br>
    <span  id="discription"></span>
    <div class="space"></div>
    <div class="content">
      <?php  echo $discription; ?></div>
      <br>
      <span  id="gallery"></span>
      <div class="content" >

        <iframe width="560" height="315" src="<?php echo $trailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><div class="galleryImg"><img src="../srcs/images/<?php echo $name; ?>/<?php echo $img1; ?>" ><img src="../srcs/images/<?php echo $name; ?>/<?php echo $img2; ?>"><img src="../srcs/images/<?php echo $name; ?>/<?php echo $img3; ?>"></div>
      </div>
      <span  id="info"></span>
      <br>
      <div class="content" id="info_block">
        <div><p>В ролях </p><br>
          <?php 
          foreach ($role as $value) {
            echo trim($value)."<br>";
          }
          ?>
          
        </div>
        <div id='right_info_block'>
          <div>
          <p>Режисеры</p> <br>
          <?php 
          foreach ($director as $value) {
            echo trim($value)."<br>";
          }
          ?>
        </div>
        <br>
        <div>
          <p>Жарны</p> <br>
          <?php 
          foreach ($genre as $value) {
            echo trim($value)."<br>";
          }
          ?>
        </div>
        </div>
      </div>

 
    <script type="text/javascript">
      $("body").on('click', '[href*="#"]', function(e){
        var fixed_offset = 100;
        $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 1000);
        e.preventDefault();
      });
    </script>
  </body>
</html>
