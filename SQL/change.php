<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create</title>
	<style type="text/css">input, textarea, select{margin-bottom: 10px;}</style>
</head>
<body>
	<?php
		$id = intval($_GET['id'][0]);
		$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		try {
			$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
		} catch (Exception $e) {
			exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
				location.href=location.href;</script>');
		}
		$stmt = $connection->query("SELECT id, name as genre, genre_id FROM genre LEFT JOIN genre_list ON film_id = $id and genre.id = genre_list.genre_id ORDER BY genre;");
		$genre_list = $stmt->fetchAll();
		if ($genre_list == Array())
			echo('<script type="text/javascript">alert("Список жанров пуст! Тут что-то не так!");
				</script>');
		$stmt = $connection->query("SELECT id, name as country FROM country ORDER BY country;");
		$country_list = $stmt->fetchAll();
		if ($country_list == Array())
		echo('<script type="text/javascript">alert("Список стран пуст! Тут что-то не так!");
			</script>');
		$stmt = $connection->query("SELECT * FROM film WHERE id =".$id);
		$pre_params = $stmt->fetchAll()[0];
		if ($pre_params == Array())
			echo('<script type="text/javascript">alert("Список параметров пуст! Тут что-то не так!");
			</script>');
		$stmt = $connection->query("SELECT id, name as category, category_id FROM category LEFT JOIN category_list ON film_id = $id and category.id = category_list.category_id ORDER BY category;");
		$category_list = $stmt->fetchAll();
		if ($category_list == Array())
		echo('<script type="text/javascript">alert("Список категорий пуст! Тут что-то не так!");
			</script>');
		$connection = null;
	?>
	<button onclick="location.href='adm_panel.php'">Отмена</button>
		<pre>
		<form enctype = 'multipart/form-data'>
		id				<input type="text" readonly="true" name="id" value="<?php echo $id; ?>">
		Название 			<input type="text" name="title" value="<?php echo $pre_params['title']; ?>" required>
		Год 				<input type="date" name="release" value="<?php echo $pre_params['release']; ?>" required>
		Страна 				<select name="country" size="1" id="country_selector" required>
							<option value="none" selected disabled hidden>Страна</option>
							<?php 
								for ($i=0; $i < count($country_list); $i++) { 
									echo "<option value='".$country_list[$i]['id']."'>".$country_list[$i]['country']."</option>";
								}
							?>
							</select> <input type="text" name="new_country" id="new_country" onkeyup="disableCategory()" placeholder="Создать">
		Возрастной рейтинг 		<select required name="rate" id="rate_select" size="1">
			<option value="" selected disabled hidden>Выберите </option> 
			<option value="0">0+</option>
			<option value="3">3+</option>
			<option value="7">7+</option>
			<option value="12">12+</option>
			<option value="16">16+</option>
			<option value="18">18+</option>
		</select>
		Описание 			<textarea name="discription" size="256" required ><?php echo $pre_params['discription']; ?></textarea>
		В главных ролях			<textarea name="role" required><?php echo $pre_params['role']; ?></textarea>
		Режисеры			<textarea name="director" required><?php echo $pre_params['director']; ?></textarea>
		Жанры				<select name="genre[]" size="10" multiple required>
							<?php 
								for ($i=0; $i < count($genre_list); $i++) { 
									echo "<option value='".$genre_list[$i]['id']."'".($genre_list[$i]['genre_id']?"selected":"").">".$genre_list[$i]['genre']."</option>";
								}
							 ?>
							</select>
		Категории			<select name="category[]" size="10" multiple required>
								<option value="none" selected disabled hidden>Категории</option>
								<?php 
									for ($i=0; $i < count($category_list); $i++) { 
										echo "<option value='".$category_list[$i]['id']."'".($category_list[$i]['category_id']?"selected":"").">".$category_list[$i]['category']."</option>";
									}
								?>
							</select><br>
		Ссылка на трейлер 		<input name="trailer" value="<?php echo $pre_params['trailer']; ?>" required>
		Первое изображение 		<input type="file" name="img1" >
		Второе изображение 		<input type="file" name="img2" >
		Третье изображение 		<input type="file" name="img3" >
		Постер 				<input type="file" name="poster" >
		Превью 				<input type="file" name="preview" >
		Цена 				<input type="number" name="price" 
		value="<?php echo $pre_params['price']; ?>" required>
		<input type="submit" value="Посмотреть" 
    formaction="page/preview.php" formmethod="post">
		<input type="submit" value="Отправить" 
    formaction="sql_change.php" formmethod="post">
	</form>
	</pre>
	<?php
		$connection = null;
	?>
	
	


	<script type="text/javascript">
		
		select_child('rate_select', <?php echo $pre_params['rate'] ?>)
		select_child('country_selector', <?php echo $pre_params['country_id'] ?>)
		var country_selector = document.getElementById('country_selector');
		var new_country = document.getElementById('new_country');
		function select_child(parent_id, found) {
			var parent_options = document.getElementById(parent_id).childNodes;
			for (var i = 0; i < parent_options.length; i++)
			{
				if (found == parent_options[i].value)
					parent_options[i].selected = true;
			}
		}
		
		function disableCategory()
		{
			if (new_country.value.length > 0)
			{
				country_selector.required = false;
				country_selector.disabled = true;
			}
			else
			{
				country_selector.required = true;
				country_selector.disabled = false;
			}
		}
	</script>
</body>
</html>