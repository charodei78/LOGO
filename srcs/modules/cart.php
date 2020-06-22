<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="cart.css">
</head>
<body>
<?php 
$id = explode(",",$_COOKIE['cart']);
$id = array_map(intval, $id); 
if ($id)
{
	$options = array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
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
	$stmt = $connection->query("SELECT film.id, `title`, price FROM film WHERE id in (".implode(',' , $id).") ORDER BY title");
	$product_list = $stmt->fetchAll();
	$connection = null;
}
else
	$product_list = null;
?>
<div id="wrapper">
	<button id="close_button" onclick="window.parent.closeCart()">x</button>
	<h1 style="margin: -5px 15px 3px">Библиотека</h1>
	<form id="table_form">
		<table cellspacing="0">
			<tr><th>✓<th>id<th style="padding: 0 15px;">Имя<th width='100px;'>Цена<th width='30px;'>
		</table>
		<div id="product_list">
			<?php  
			if ($product_list && $product_list != array())
			{
				echo "<table cellspacing='0'>";
				foreach ($product_list as $row) {
					echo '<tr><td  width="56px" style="padding: 0;"><input style="width: 22px;" onchange="isChecked()" class="checkboxes" name="id[]" type="checkbox" value="'.$row['id'].'" >';
					foreach ($row as $col => $value) {		
						if ($col == 'id')
						{
							$tmp_id = $value;
							echo "<td width='43px'>".$value;
						}
						elseif ($col == 'price')
						{
							echo "<td>".$value.' ₽';
						}
						else
							echo "<td width='134px'>".$value;

					}
					echo "<td width='30px;'><button type='button' onclick='rmCartProduct($tmp_id)' style='color: red; background-color: rgba(0,0,0,0); border: 0; outline: none; font-size:130%;'> X </button>";
				}
				echo "</table>";
			}
			else
				echo "<p style='font-size: 150%; margin:0; margin-left: 15px;'>Товары отсутствуют</p>";
			?>
		</div>
		<div id="client_info">
			<input type="text" placeholder="Имя" name="client_name"><br>
			<input type="text" placeholder="Номер (начиная с 8)" name="phone"><br>
			<textarea placeholder="Адрес доставки" name="address"></textarea>
		</div>
		<button id="buy_button" formmethod="post" formaction="checkout.php">Купить</button>
	</form>
</div>
<script type="text/javascript">
	isChecked();
	var wrapper = document.getElementById("wrapper");
	var height = window.getComputedStyle(wrapper, null).height;
	function getCookie(name) 
	{
	  var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
	  return matches ? decodeURIComponent(matches[1]) : '';
	}

	function isChecked()
	{
		var checkboxes = document.getElementsByClassName('checkboxes');
		for (var i = checkboxes.length - 1; i >= 0; i--)
		{
			if (checkboxes[i].checked)
			{
				buy_button.removeAttribute('disabled');
				return;
			}
		}
		buy_button.disabled = true;
	}

	function rmCartProduct (id)
	{
		if (confirm("Удалить товар из библиотеки?"))
		{
			var res = (getCookie("cart").split(',').map(Number));
			var index = res.indexOf(parseInt(id));
			if (index < 0)
				return false;
			res.splice(index, 1);
			document.cookie = "cart = " + res.join(',') + ";path=/";
			window.parent.recount();
			location.href=location.href;
		}
	}
</script>
</body>
</html>

