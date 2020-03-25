<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create</title>
</head>
<body>
	<?php
		$id = $_POST['row'];
		$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', '', $options);
		$stmt = $connection->query('SELECT * FROM films WHERE id ='.$id[0]);
		$pre_params = $stmt->fetchAll()[0];
	?>
		<pre>
		<form>
		id				<input type="text" readonly="true" name="id" value="<?php echo $id[0]; ?>">
		Название 			<input type="text" name="name" value="<?php echo $pre_params['name']; ?>" required><br>
		Год 				<input type="number" name="year"
		value="<?php echo $pre_params['year']; ?>" required><br>
		Страна 				<input type="text" name="country" 
		value="<?php echo $pre_params['country']; ?>" required><br>
		Было				<input type="text" readonly="true" value="<?php echo $pre_params['rate'].'+'; ?>">
		Возрастной рейтинг 		<select required name="rate" size="1">
			<option value="" selected disabled hidden>
			Выберите </option> 
			<option value="0">0+</option>
			<option value="3">3+</option>
			<option value="7">7+</option>
			<option value="12">12+</option>
			<option value="16">16+</option>
			<option value="18">18+</option>
		</select><br>
		Описание 			<textarea name="discription" size="256" required ><?php echo $pre_params['discription']; ?></textarea><br>
		В главных ролях			<textarea name="role" required><?php echo $pre_params['role']; ?></textarea><br>
		Режисеры			<textarea name="director" required><?php echo $pre_params['director']; ?></textarea><br>
		Жанры				<input type="text" value="<?php echo $pre_params['genre']; ?>" name="genre" required><br>
		Кинопоиск id 			<input type="number" value="<?php echo $pre_params['kp_link']; ?>" name="kp_link" required>
		Ссылка на трейлер 		<input type="url" name="trailer" value="<?php echo $pre_params['trailer']; ?>" required>
		Цена 				<input type="number" name="price" 
		value="<?php echo $pre_params['price']; ?>" required><br>
		<input type="submit" value="Посмотреть" 
    formaction="page/preview.php" formmethod="post">
		<input type="submit" value="Отправить" 
    formaction="sql_change.php" formmethod="post">
	</form>
	</pre>
	<?php
		$connection = null;
	?>
	
	<br>
	<form>
		<input type="submit" formaction="adm_panel.php" name="Отмена">
	</form>
</body>
</html>