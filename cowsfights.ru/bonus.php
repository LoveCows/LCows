<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	include ("db.php");
	//$idbonus = $_GET['id'];
	$id = $_SESSION['id'];
	
	?>
	<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<?php
$result = mysql_query("SELECT cell.id_bonus as idb, cell.id as idc FROM user, cell WHERE user.id = '$id' AND user.id_cell = cell.id",$db);
						$myrow = mysql_fetch_array($result);
						$cellid = $myrow['idc'];
						$idbonus = $myrow['idb'];
$result4 = mysql_query("SELECT * FROM bonus WHERE id = '$idbonus'",$db);
						$myrow4 = mysql_fetch_array($result4);
						$text = $myrow4['text'];
						$column = $myrow4['column'];
						$picture = $myrow4['picture'];
						$value = $myrow4['value'];
mysql_query("UPDATE cell SET grass = 0, bg = 'grass' WHERE id='$cellid'",$db);

echo "<img src='/images/" , $picture ,"' alt='trava'  />";
echo "<div id = 'tex'>",$text,"</div>";
echo $grass;
//echo "hey";
?>
</body>
</html>