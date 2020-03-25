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
	<form method="post" enctype = 'multipart/form-data'>
	<pre>
		Название 			<input type="text" name="name" required><br>
		Год 				<input type="number" name="year" required><br>
		Страна 				<input type="text" name="country" required><br>
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
		Жанры				<input type="text" name="genre" required><br>
		Кинопоиск id 	<input type="number" name="kp_link" required>
		Ссылка на трейлер 		<input type="url" name="trailer" required>
		Первое изображение 		<input type="file" name="img1" ><br>
		Второе изображение 		<input type="file" name="img2" ><br>
		Третье изображение 		<input type="file" name="img3" ><br>
		Постер 				<input type="file" name="poster" ><br>
		Цена 				<input type="number" name="price" required><br>
		<input type="submit" value="Посмотреть" 
    formaction="preview.php" formmethod="post">
		<input type="submit" value="Отправить" 
    formaction="sql_send.php" formmethod="post">
	</pre>


</body>
</html>