<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	include ("db.php");
    ?>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="shortcut icon" href="/images/cow_(2).ico" type="image/x-icon">
    <title>Cows Fights</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	
    </head>
    <body>
	
	<div id="maket">
	
    <div id="header">Добро пожаловать в игру!</div>
	
	<div id="pic">
	<?php
	$result0 = mysql_query("SELECT picture FROM cow_picture WHERE id=2",$db);
	$myrow0 = mysql_fetch_array($result0);
				$picture = $myrow0['picture'];
				echo "<td><div data-x='$k' data-y='$j' id='gr'><img src='/images/" , $picture ,"' alt=\"Это коровка-противник\" id = 'p'/></div></td>";
	
	?>
</div>
	<p>Пол <select onchange = "selsex()" size="1" id="s1">
	<option value = 'm' > бычок </option>
	<option value = 'w' > коровка </option>
   </select></p>
	
	<p>Цвет пятен <select onchange = "selsex()" size="1" id="s2">
	<?php 
				$result = mysql_query("SELECT spots_color as s FROM cow_picture GROUP BY spots_color",$db);
				while($object = mysql_fetch_object($result))
				{
				
				echo "<option value = '$object->s' > $object->s </option>";
				}
?>
   </select></p>
   
	<p>Цвет ошейника <select onchange = "selsex()" size="1" id="s3">
	<?php 
				$result1 = mysql_query("SELECT collar_color as s FROM cow_picture GROUP BY collar_color",$db);
				while($object = mysql_fetch_object($result1))
				{
				echo "<option value = '$object->s' > $object->s </option>";
				}
?>
   </select></p>
	<div id="reg">
    <form>
<script type="text/javascript">

var picid = 2;	
function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function selsex()
{
	var s01 = document.getElementById("s1")
	var s1 = s01.options[s01.selectedIndex].value;
	var s02 = document.getElementById("s2")
	var s2 = s02.options[s02.selectedIndex].value;
	var s03 = document.getElementById("s3")
	var s3 = s03.options[s03.selectedIndex].value;
	var req2 = getXmlHttp();
	req2.onreadystatechange = function() {  
        // onreadystatechange активируется при получении ответа сервера

		if (req2.readyState == 4) { 
			if(req2.status == 200) {
				var n = JSON.parse(req2.responseText);
				$picture = n.pic;
				var img = document.getElementById('pic');
			    img.innerHTML = '<img src="/images/' + $picture + '" title="Ваш портрет" id = "p"/>';
				picid = n.id;
											
			}
		}
	}
	var params = 'sex=' + encodeURIComponent(s1) + '&spot=' + encodeURIComponent(s2) + '&collar=' + encodeURIComponent(s3);
										req2.open('POST', 'choose_cow.php', true);
										req2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req2.send(params);
} 

function vote() 
{
	selsex();
	// (1) создать объект для запроса к серверу
	var req = getXmlHttp()  
	var statusElem = document.getElementById('vote_status') 
	req.onreadystatechange = function() {  
        // onreadystatechange активируется при получении ответа сервера

		if (req.readyState == 4) { 
            // если запрос закончил выполняться
			statusElem.innerHTML = req.statusText // показать статус (Not Found, ОК..)
			if(req.status == 200) {
				var a = JSON.parse(req.responseText);
				 if ((a.status) == 5)
				//if (decodeURIComponent(req.responseText) == 5)//'Подходящий противник пока не пришел, пожалуйста, подождите')
				{
					var id = a.id;
					alert("Ответ сервера: Подходящий противник пока не пришел, пожалуйста, подождите");
	function interval()
	{
		//alert("dd");
		var req1 = getXmlHttp(); 
		req1.onreadystatechange = function()
		{
					if (req1.readyState == 4)
					{ 
						if(req1.status == 200)
						{ 
			
						if(decodeURIComponent(req1.responseText) == 1)
							{
							clearInterval(intervalID);
							window.location.href = "game.php?id=" + a.id;
							}
						}
					}
		}
		
					req1.open('POST', 'wait_cow.php', true);
					req1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					req1.send("id="+a.id);  
	}
	
					var intervalID=setInterval(interval,1000);
				}
				else 
				window.location.href = "game.php?id=" + a.id;
			}
		}

}
	var params = 'id=' + encodeURIComponent(picid) ;
										req.open('POST', 'new.php', true);
										req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req.send(params);
	//req.send(null);  // отослать запрос
  
        // (5)
	statusElem.innerHTML = 'Ожидаю ответа сервера...' 
}
         </script>
    <p><input class="btn" type="button" onclick="vote()" value=" Найти корову-соперника! "></p>
	<div id="vote_status">Здесь будет ответ сервера</div>
</p></form>

</div>

</div>
<div id="exit"><p><input class="btn" type="button" value=" Выйти "></p></div>
    </body>
    </html>