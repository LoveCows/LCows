<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
    ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="/images/cow_(2).ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" media="screen" />
	<script type="text/javascript" src="fancybox/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.2.1.pack.js"></script>
	<script type="text/javascript">
	function hz()
	{
		var a = document.getElementById("lol");
		a.click();
	}
	$(document).ready(function() {
    $("a.gallery").fancybox();
	$("a.gallery2").fancybox(
			{						
          "padding" : 20,
          "imageScale" : false, 
			"zoomOpacity" : false,
			"zoomSpeedIn" : 1000,	
			"zoomSpeedOut" : 1000,	
			"zoomSpeedChange" : 1000, 
			"frameWidth" : 700,	 
			"frameHeight" : 600, 
			"overlayShow" : true, 
			"overlayOpacity" : 0.8,	
			"hideOnContentClick" :false,
			"centerOnScroll" : false
				
			});
			$("a.iframe").fancybox(

  { 

"frameWidth" : 450,	 // ширина окна, px (425px - по умолчанию)

"frameHeight" : 200 // высота окна, px(355px - по умолчанию)

});
	});
	
	</script>
	
	<title>test</title>
</head>
<body>
<div id="wrap">

  <h1>FancyBox - Фотогалерея</h1>

<h3>Одиночная картинка</h3>
 <span style="visibility: hidden"><a class="iframe" id = "lol" title="Бонус!" href='bonus.php?id=1'></a></span>
   

 <h3>Группа картинок (галерея изображений)</h3>
 <a class="gallery" rel="group" title="это фото 1" href="/images/cow_.png"><img src="/images/wolf_.png" /></a>
 <a class="gallery" rel="group" title="это фото 2" href="/images/cow1_.png"><img src="/images/wolf_.png" /></a>
 <a class="gallery" rel="group" href="/images/wolf_.png"><img src="/images/wolf_.png" /></a>
<a class="gallery" title="Простая HTML" href="fight.html">Клик</a>
<a class="iframe" href="http://www.google.ru">Погуглим?</a>
<p><input type="button" onclick="hz()" value=" lol! "></p>
</body>
</html>