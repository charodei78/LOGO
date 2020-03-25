<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="page_style.css">
    <meta charset="utf-8">
    <title>Preview</title>
    <?php 

    	$film_name = $_POST['film_name'];
    	$year = $_POST['year'];
    	$country = $_POST['country'];
    	$rate = $_POST['rate'];
    	$discription = $_POST['discription'];
    	$trailer = $_POST['trailer'];
    	$img1 = $_FILES['img1'];
    	$img2 = $_FILES['img2'];
    	$img3 = $_FILES['img3'];
    	$poster = $_FILES['poster'];
    	$price = $_POST['price'];
      $genre = $_POST['genre'];
      $role = explode(',', $_POST['role']);
      $director = explode(',',$_POST['director']);
    ?>
  </head>
  <body>
    <img id="poster" src="../srcs/images/tmp/<?php echo $poster['name']; ?>">
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
        <div id="search"><img src="../srcs/ico/search.png"></div>
      </div>
      <div id="name"> <?php echo $film_name; ?><p><?php echo $year; ?>г <?php echo $country; ?> <?php echo $rate ?>+</p></div>
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

      <iframe width="560" height="315" src="<?php echo $trailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><div class="galleryImg"><img src="../srcs/images/tmp/<?php echo $img1['name']; ?>" ><img src="../srcs/images/tmp/<?php echo $img2['name']; ?>"><img src="../srcs/images/tmp/<?php echo $img3['name']; ?>"></div>
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
