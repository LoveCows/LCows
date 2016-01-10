<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	$id = $_GET['id'];
	$cowid = $_SESSION['id'];
	//echo "$id";
    ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="/images/cow_(2).ico" type="image/x-icon">
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" media="screen" />
	<script type="text/javascript" src="fancybox/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.2.1.pack.js"></script>
	<title>Cows Fights</title>
</head>
<body onload="init()">
<?php
include ("db.php");
//echo "<span style=\"visibility: hidden\"><a class=\"iframe\" id = \"lol\" title=\"Бонус!\" href='bonus.php?id=1'></a></span>";
?>
<span style="visibility: hidden"><a class="iframe" id = "lol" title="Бонус!" href='bonus.php'>click</a></span>
<div id = "turn" class="txt"></div>
<div id = "power" class="txt">Сила:
<?php $result4 = mysql_query("SELECT * FROM user WHERE user.id = '$cowid'",$db);
$myrow4 = mysql_fetch_array($result4);
$grass = $myrow4['power'];
echo $grass;
?>
</div>
<div id = "health" class="txt">Здоровье:
<?php $result5 = mysql_query("SELECT * FROM user WHERE user.id = '$cowid'",$db);
$myrow5 = mysql_fetch_array($result5);
$grass = $myrow5['health'];
echo $grass;
?>
</div>
<div id = "grass" class="txt">Количество травы:
<?php $result3 = mysql_query("SELECT * FROM user WHERE user.id = '$cowid'",$db);
$myrow3 = mysql_fetch_array($result3);
$grass = $myrow3['grass'];
echo $grass;
?></div>

<table class="square" id="table" > 
<?php 
$result1 = mysql_query("SELECT id_cell as id, picture as pic, game.cow1 as c FROM user, game, cow_picture WHERE game.id = '$id' AND game.cow1 = user.id AND user.id_picture = cow_picture.id",$db);
$myrow1 = mysql_fetch_array($result1);
$i1 = $myrow1['id'];
$c = $myrow1['c'];
if ($c == $cowid ) {$mypicture = $myrow1['pic']; $mi = $i1;}
else {$youpicture = $myrow1['pic']; $yi = $i1;}
$result2 = mysql_query("SELECT id_cell as id, picture as pic FROM user, game, cow_picture WHERE game.id = '$id' AND game.cow2 = user.id AND user.id_picture = cow_picture.id",$db);
$myrow2 = mysql_fetch_array($result2);
$i2 = $myrow2['id'];
if ($c != $cowid ) {$mypicture = $myrow2['pic']; $mi = $i2;}
else {$youpicture = $myrow2['pic']; $yi = $i2;}

for ($k=1;$k<=5;$k++) { 
	print "<tr>"; 
	for ($j=1;$j<=5;$j++)
	{
		$result = mysql_query("SELECT cell.id as id, grass, bg FROM cell,game WHERE game.id = '$id' AND x='$k' AND y='$j' AND cell.id_game = game.id",$db);
		$myrow = mysql_fetch_array($result);
		$g = $myrow['grass'];
		$b = $myrow['bg'];
		$i = $myrow['id'];
		
	if ($i == $mi) echo "<td><div data-x='$k' data-y='$j' id='gr'><img src='/images/" , $mypicture ,"' alt='Это вы' id = 'p1'/></div></td>";
		else if ($i == $yi) echo "<td><div data-x='$k' data-y='$j' id='gr'><img src='/images/" , $youpicture ,"' alt=\"Это коровка-противник\" id = 'p'/></div></td>";
	else
	{
		switch ($g) {
    case 0:
	if ($b == 'bonus')
		echo "<td><div data-x='$k' data-y='$j' id=\"mysquare0\"></div></td>";
	else
		echo "<td><div data-x='$k' data-y='$j' id=\"gr\"></div></td>";
        break;
    case 1:
		echo "<td><div data-x='$k' data-y='$j' id=\"mysquare1\"></div></td>";
        break;
    case 2:
		echo "<td><div data-x='$k' data-y='$j' id=\"mysquare2\" ></div></td>";
        break;
	case 3:
		echo "<td><div data-x='$k' data-y='$j' id=\"mysquare3\"></div></td>";
        break;
    }
		}
	}
		
	print "</tr>"; 
}
?> 
</table> 

<script type="text/javascript">
$(document).ready(function() {
var start = 1;
$("a.iframe").fancybox(
{ 
	"frameWidth" : 450,	 // ширина окна, px (425px - по умолчанию)
	"frameHeight" : 200 // высота окна, px(355px - по умолчанию)
});
	});
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

function init() 
{
	$sesya = '<?php echo $cowid;?>';
	//alert($sesya);
	endgame();
	var r = 1;
	function turn1()
	{
		var req1 = getXmlHttp(); 
		req1.onreadystatechange = function()
		{
					if (req1.readyState == 4)
					{ 
						if(req1.status == 200)
						{ 
						var n = JSON.parse(req1.responseText);
							if (n.turn != 0)
							{ 
								var turnTxt = document.getElementById('turn') 
								turnTxt.innerHTML = "Ваш ход!";
								$turn = "me";
								$myx = n.x1;
								$myy = n.y1;
								try
								{
								var table = document.getElementById("table");
								var str = table.getElementsByTagName("tr")[$youx-1]; //string (0...)
								var sq = str.getElementsByTagName("td")[$youy-1]; //cell 
								var ds = sq.firstChild; //div
								ds.innerHTML = "";
								ds.id = "gr";
								}
								catch(e) {}
								$youx = n.x;
								$youy = n.y;
								var table = document.getElementById("table");
								var str = table.getElementsByTagName("tr")[$youx-1]; //string (0...)
								var sq = str.getElementsByTagName("td")[$youy-1]; //cell 
								var ds = sq.firstChild; //div
								//ds.innerHTML = '<img src="/images/' + $youpicture +'" title="Это коровка-противник"/>';
								
								$youpicture = '<?php echo $youpicture;?>';	
								ds.id = 'gr';
								ds.innerHTML = '<img src="/images/' + $youpicture + '" title="Это коровка-противник" alt="Это коровка-противник" id = "p"/>';
								$start = "";
								clearInterval(intervalID);
							
							}
							else
							{
								
								if (r != 0)
								{
								//alert("else");
									$youx = n.x;
									$youy = n.y;
									$myx = n.x1;
									$myy = n.y1;
									var turnTxt1 = document.getElementById('turn') 
									turnTxt1.innerHTML = "Ход коровки-противника!";
									r = 0;
								}
									if ((n.fight == 1))
									{
													var audio = new Audio(); // Создаём новый элемент Audio
													audio.src = '/images/fight.mp3'; // Указываем путь к звуку "клика"
													audio.autoplay = true;
										alert("На нас напали варги!!!");
										var table = document.getElementById("table");
													var str = table.getElementsByTagName("tr")[$myx-1]; //string (0...)
													var sq = str.getElementsByTagName("td")[$myy-1]; //cell 
													var ds = sq.firstChild; //div
													ds.innerHTML = '<img src="/images/cf.gif" alt="Битва" title = "Битва" />';
													var table0 = document.getElementById("table");
													var str0 = table0.getElementsByTagName("tr")[$youx-1]; //string (0...)
													var sq0= str0.getElementsByTagName("td")[$youy-1]; //cell 
													var ds0 = sq0.firstChild; //div
													ds0.innerHTML = '';
										var req = getXmlHttp(); 
										req.onreadystatechange = function()
										{
										if (req.readyState == 4)
											{ 
												if(req.status == 200)
												{
													var n1 = JSON.parse(req.responseText);
													//alert(n1);
													if (n1.winner == 2){alert("Победа!!");}
													if (n1.winner == 1){alert("Поражение!!");}
													if (n1.winner == 0){alert("Ничья!!");}
													$mypicture = '<?php echo $mypicture;?>';
													$youpicture = '<?php echo $youpicture;?>';	
													var turnTxt = document.getElementById('health') 
													turnTxt.innerHTML = "Здоровье: " + n1.health;
													$turn = "you";
													var turnTxt = document.getElementById('turn');
													turnTxt.innerHTML = "Ваш ход!";
													var turnTxt = document.getElementById('grass');
													turnTxt.innerHTML = "Количество травы : " + n1.grass;
													var table1 = document.getElementById("table");
													var str1 = table1.getElementsByTagName("tr")[$myx-1]; //string (0...)
													var sq1 = str1.getElementsByTagName("td")[$myy-1]; //cell 
													var ds1 = sq1.firstChild; //div
													var table2 = document.getElementById("table");
													var str2 = table2.getElementsByTagName("tr")[$youx-1]; //string (0...)
													var sq2 = str2.getElementsByTagName("td")[$youy-1]; //cell 
													var ds2 = sq2.firstChild; //div
													ds1.innerHTML = '<img src="/images/' + $mypicture +'" title="Это вы" alt = "Это вы" id = "p1"/>';
													ds2.innerHTML = '<img src="/images/' + $youpicture + '" title="Это коровка-противник" alt = "Это коровка-противник" id = "p"/>';
													ds2.id = 'gr';
													endgame();
												}
											}
										}
										$gid = '<?php echo $id;?>';
										var params = 'id=' + encodeURIComponent($gid);
										req.open('POST', 'logic_fight.php', true);
										req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req.send(params);
										clearInterval(intervalID);
									}
							}
						}
					}
		}
		$gid = '<?php echo $id;?>';
		req1.open('POST', 'turn1.php', true);
					req1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					req1.send("id="+$gid);  
	}
	  
	  var intervalID=setInterval(turn1,1000);
}
document.onclick = function(evt)
{
  evt = evt || window.event;
  var el = evt.target || evt.srcElement;
  if ((el.id != "")) 
  {
	  function turn()
	{
		var req1 = getXmlHttp(); 
		req1.onreadystatechange = function()
		{
					if (req1.readyState == 4)
					{ 
						if(req1.status == 200)
						{
							var n = JSON.parse(req1.responseText);
							if (n.turn != 0)
								
							{
								try
								{
								var table = document.getElementById("table");
								var str = table.getElementsByTagName("tr")[n.x-1]; //string (0...)
								var sq = str.getElementsByTagName("td")[n.y-1]; //cell 
								var ds = sq.firstChild; //div
								ds.innerHTML = "";
								ds.id = 'gr';
								
								}
								catch(e) {}
								
							$mypicture = '<?php echo $mypicture;?>';	
							$turn = "you";
							el.id = 'gr';
							el.innerHTML = '<img src="/images/' + $mypicture +'" title="Это вы" alt="Это вы" id = "p1"/>';
								var turnTxt = document.getElementById('grass') ;
								turnTxt.innerHTML = "Количество травы:" + n.grass;
								var turnTxt = document.getElementById('turn') ;
								turnTxt.innerHTML = "Ход коровки-противника!";
								if (n.bg == "bonus")
								{
									var turnTxt = document.getElementById('health') ;
									turnTxt.innerHTML = "Здоровье:" + n.health;
									var turnTxt = document.getElementById('power') ;
									turnTxt.innerHTML = "Сила:" + n.power;
									var a11 = document.getElementById("lol");
									a11.click();
								}
							init();
							}
						}
					}
		}
		$gid = '<?php echo $id;?>';
		var params = 'id=' + encodeURIComponent($gid) + '&x=' + encodeURIComponent($x) + '&y=' + encodeURIComponent($y);
		req1.open('POST', 'turn.php', true);
					req1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					req1.send(params);  
	}
	if (el.id != "p")
	{
		$x = el.getAttribute("data-x");
		$y = el.getAttribute("data-y");
	if (($turn == 'me')&&(true||((($myx == $x)&&($myy == $y+1))||(($myx == $x)&&($myy == $y-1)))||((($myy == $y)&&($myx == $x-1))||(($myy == $y)&&($myx == $x+1)))))
	{turn();}
	}
	else
									{
										
										var ds;
										var req2 = getXmlHttp();
										req2.onreadystatechange = function()
										{
											if (req2.readyState == 4)
											{ 
												if(req2.status == 200)
												{
													var n1 = JSON.parse(req2.responseText);
													try
													{
														$x = n1.x;
														$y = n1.y;
													var table1 = document.getElementById("table");
													var str1 = table1.getElementsByTagName("tr")[n1.x-1]; //string (0...)
													var sq1 = str1.getElementsByTagName("td")[n1.y-1]; //cell 
													var ds1 = sq1.firstChild; //div
													ds = ds1;
													ds1.innerHTML = '';
													}
													catch(e) {}
												}
												
											}
										}
										$gid = '<?php echo $id;?>';
										var params = 'id=' + encodeURIComponent($gid) + '&f=' + encodeURIComponent(1);
										req2.open('POST', 'lite_turn.php', true);
										req2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req2.send(params);  
										alert("Now! Fight!");
										var el1 = el.parentNode;
										el1.innerHTML = '<img src="/images/cf.gif" alt="Битва" title="Битва" />';
										
										//el.id = "fight1";
										function f()
										{
										var req3 = getXmlHttp();
										req3.onreadystatechange = function()
										{
											if (req3.readyState == 4)
											{ 
												if(req3.status == 200)
												{
													
													var n = JSON.parse(req3.responseText);
													if (n.fight == 0)
													{
													if (n.winner == 1){alert("Победа!");
													}
													if (n.winner == 2){alert("Поражение!");}
													if (n.winner == 0){alert("Ничья!");}
													$mypicture = '<?php echo $mypicture;?>';
													var turnTxt = document.getElementById('health') 
													turnTxt.innerHTML = "Здоровье: " + n.health;
													var turnTxt = document.getElementById('grass') 
													turnTxt.innerHTML = "Количество травы: " + n.grass;
													$turn = "you";
													var turnTxt = document.getElementById('turn');
													turnTxt.innerHTML = "Ход коровки-противника!";
													var table1 = document.getElementById("table");
													var str1 = table1.getElementsByTagName("tr")[n.x-1]; //string (0...)
													var sq1 = str1.getElementsByTagName("td")[n.y-1]; //cell 
													var ds1 = sq1.firstChild; //div
													ds = ds1;
													ds1.innerHTML = '';
													ds1.innerHTML = '<img src="/images/' + $mypicture +'" title="Это вы" alt="Это вы" id = "p1"/>';
													el1.innerHTML = '<img src="/images/' + $youpicture + '" title="Это коровка-противник" alt="Это коровка-противник" id = "p"/>';
											el1.id = 'gr';
											
											init();
											clearInterval(interv);
												}
												}
											}
										}
										$gid = '<?php echo $id;?>';
										var params = 'id=' + encodeURIComponent($gid) + '&f=' + encodeURIComponent(1);
										req3.open('POST', 'logic_fight2.php', true);
										req3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req3.send(params);
										
										}
										var interv = setInterval(f, 1000);	
								
									}
  }
}
function endgame()
{
	var req33 = getXmlHttp(); 
		req33.onreadystatechange = function()
		{
					if (req33.readyState == 4)
					{ 
						if(req33.status == 200)
						{
							//alert(req33.responseText);
							var n = JSON.parse(req33.responseText);
							if (n.kill == 1)
								{
									alert("Игра окончена! Вы отбросили копытца!") ;
									window.location.href = "pregame.php";
								}
							else
								if ((n.kill1 == 1)||(n.vin == 1))
								{
							        var audio1 = new Audio(); // Создаём новый элемент Audio
									audio1.src = '/images/heey.mp3'; // Указываем путь к звуку "клика"
									audio1.autoplay = true;
									alert("Игра окончена! Вы победили!") ;
									window.location.href = "pregame.php";
								}
							else
								if ((n.vin1 == 1)) 
								{
									alert("Игра окончена! Вы проиграли!") ;
									window.location.href = "pregame.php";
							
								}
							//alert(n.id);
						}
					}
		}
		$gid = '<?php echo $id;?>';
		req33.open('POST', 'endgame.php', true);
		var params = 'id=' + encodeURIComponent($gid);
										req33.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
										req33.send(params);
}
</script>
</body>
</html>