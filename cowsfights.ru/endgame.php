<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	include ("db.php");
	$id = $_SESSION['id'];
	$gid = $_POST['id'];
	
	$result0 = mysql_query("SELECT cow1, cow2, max FROM game WHERE id = '$gid'",$db);
    $myrow0 = mysql_fetch_array($result0);
	$cow1 = $myrow0['cow1'];
	$cow2 = $myrow0['cow2'];
	$max = $myrow0['max'];
	
	$result = mysql_query("SELECT id FROM game WHERE game.id='$gid' AND cow1 = '$id'",$db);
					$myrow = mysql_fetch_array($result);
					if (!empty($myrow['id']))
					{
						$me = $cow1;
						$notme = $cow2;
					}
					else
					{
						$me = $cow2;
						$notme = $cow1;
					}
	
	$result1 = mysql_query("SELECT * FROM user WHERE id = '$me'",$db);
    $myrow1 = mysql_fetch_array($result1);
	
	if ($myrow1['health'] < 1)
		$kill = 1;
	else $kill = 0;
		
	$result2 = mysql_query("SELECT * FROM user WHERE id = '$notme'",$db);
    $myrow2 = mysql_fetch_array($result2);
	
	if ($myrow2['health'] < 1)
		$kill1 = 1;
	else $kill1 = 0;
	
	if ($myrow1['grass'] >= $max)
		$vin = 1;
	else $vin = 0;
	
	if ($myrow2['grass'] >= $max)
		$vin2 = 1;
	else $vin2 = 0;
	
	if (($kill == 1)||($kill1 == 1)||($vin == 1)||($vin2 == 1)) mysql_query("UPDATE game SET status = 'off' WHERE id = '$gid'",$db);
	
	$cart = array(
		"id" => $gid,
		"kill" => $kill,
		"kill1" => $kill1,
		"vin" => $vin,
		"vin1" => $vin2,
		);
	echo json_encode( $cart );
	?>