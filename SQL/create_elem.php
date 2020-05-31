<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create</title>
	<style type="text/css">
		table {border: 3px solid black}
		td {border: 1px solid gray; padding: 5px;border-bottom: 1px solid black;border-top: 1px solid black;}
		th {border: 1px solid black;}
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>
<?php  
	$options = array(
		PDO::ATTR_ERRMODE 				=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC
		);
	try {
	$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '', $options);
	} catch (Exception $e) {
		exit('<script type="text/javascript">alert("Подключение к базе данных не удалось, попробуйте перезагрузить страницу: ' . $e->getMessage().'");
			location.href=location.href;</script>');
	}
	$stmt_genre = $connection->query("SELECT id, name as genre FROM genre ORDER BY genre;");
	$genre_list = $stmt_genre->fetchAll();
	if ($genre_list == Array())
		echo('<script type="text/javascript">alert("Список жанров пуст! Тут что-то не так!");
			</script>');
	$stmt_country = $connection->query("SELECT id, name as country FROM country ORDER BY country;");
	$country_list = $stmt_country->fetchAll();
	if ($country_list == Array())
		echo('<script type="text/javascript">alert("Список стран пуст! Тут что-то не так!");
			</script>');
	$stmt_category = $connection->query("SELECT id, name as category FROM category ORDER BY category;");
	$category_list = $stmt_category->fetchAll();
	if ($category_list == Array())
		echo('<script type="text/javascript">alert("Список категорий пуст! Тут что-то не так!");
			</script>');
	$connection = null;
?>
<form method="post" enctype = 'multipart/form-data'>
<pre>
	Название 			<input type="text" name="title" required><br>
	Дата выхода 			<input type="date" name="release" required><br>
	Страна 				<select name="country" size="1" id="country_selector" required>
						<option value="none" selected disabled hidden>Страна</option>
							<?php 
								for ($i=0; $i < count($country_list); $i++) { 
									echo "<option value='".$country_list[$i]['id']."'>".$country_list[$i]['country']."</option>";
								}
							 ?>
						</select> <input type="text" name="new_country" id="new_country" onkeyup="disableCategory()" placeholder="Создать"><br>
	Возрастной рейтинг 		<select name="rate" size="1" required>
		<option value="none" selected disabled hidden>
		Выберите </option> 
		<option value="0">0+</option>
		<option value="3">3+</option>
		<option value="7">7+</option>
		<option value="12">12+</option>
		<option value="16">16+</option>
		<option value="18">18+</option>
	</select><br>
	Описание 			<textarea name="discription" size="256" required></textarea><br>
	В главных ролях			<textarea name="role" required></textarea><br>
	Режисеры			<textarea name="director" required></textarea><br>
	Жанры				<select name="genre[]" size="10" multiple required>
						<option value="none" selected disabled hidden>Жанры</option>
						<?php 
							for ($i=0; $i < count($genre_list); $i++) { 
								echo "<option value='".$genre_list[$i]['id']."'>".$genre_list[$i]['genre']."</option>";
							}
						 ?>
						</select><br>
	Категории			<select name="category[]" size="10" multiple required>
						<option value="none" selected disabled hidden>Категории</option>
						<?php 
							for ($i=0; $i < count($category_list); $i++) { 
								echo "<option value='".$category_list[$i]['id']."'>".$category_list[$i]['category']."</option>";
							}
						 ?>
						</select><br>
	Кинопоиск id 			<input type="number" name="kp_link" required><br>
	Ссылка на трейлер 		<input type="url" name="trailer" required><br>
	Первое изображение 		<input type="file" name="img1" ><br>
	Второе изображение 		<input type="file" name="img2" ><br>
	Третье изображение 		<input type="file" name="img3" ><br>
	Постер 				<input type="file" name="poster" ><br>
	Превью 				<input type="file" name="preview" ><br>
	Цена 				<input type="number" min="0" name="price" required><br>
	<input type="submit" value="Посмотреть" 
formaction="preview.php" formmethod="post">
	<input type="submit" value="Отправить" 
formaction="sql_send.php" formmethod="post">
</pre>

<script type="text/javascript">
	var country_selector = document.getElementById('country_selector');
	var new_country = document.getElementById('new_country');
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