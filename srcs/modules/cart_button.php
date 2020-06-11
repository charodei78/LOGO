<style type="text/css">
	#cart_button img
	{
		cursor: pointer;
		height: 100%;
	}
	#cart_count
	{
		color: black;
		position: absolute;
		text-align: center;
		font-weight: bold;
		height: 45%;
		width: 18%;
		right: 0;
	}
	#cart_button
	{
		display: flex;
		justify-content: space-between;
	}
	#cart
	{
		position: absolute;
		transition: 0.4s;
		/*margin-left: 36vw;*/ /*не убирать!*/
		right: 70px;
		position: fixed;
		visibility:hidden;
		opacity: 0;
		z-index: 1;
		border-radius: 20px;
		border: none;
		outline: none;
	}
	#cart_count
	{
		position: absolute;
		top: 4px;
		left: 132.5px;
	}
</style>
<!-- Чтобы работало укажи высоту и позицию #cart_button -->
<iframe scrolling="no"  id="cart" src="/srcs/modules/cart.php" width="448" height="10" align="center">
		Ваш браузер не поддерживает плавающие фреймы! Используйте актуальную версию браузера!
</iframe>
<div id="cart_button" onclick="showCart()"><div style="position: relative;"><div id="cart_count">0</div></div><img src="/srcs/ico/library.png"></div>

<script type="text/javascript">

	function reloadCart()
	{
		cart.src = cart.src;
	}

	function getCookie(name) 
	{
	  var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
	  return matches ? decodeURIComponent(matches[1]) : '';
	}

	function recount()
	{
		var cartList = getCookie('cart');
		if (cartList == ' ' || !cartList)
			cart_count.innerHTML = 0;
		else
			cart_count.innerHTML = cartList.split(',').length;
	}

	function showCart()
	{
		if (cart.style.visibility == "visible")
		{
			closeCart();
			return ;
		}
		cart.src = cart.src;
		cart.style.visibility = 'visible';
		setTimeout('cart.height = parseInt(window.frames[0].height) + 45;cart.style.opacity = 1; cart.style.margin = "calc((100vh - " + window.frames[0].height + ") / 2) calc(50vw - 300px)";', 500); 				
	}

	function closeCart()
	{
		cart.style.opacity = 0;
		cart.style.visibility = 'hidden';
		cart.style.margin = 0;
		setTimeout('cart.height = 10 ', 500); 
	}
</script>