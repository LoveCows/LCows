<?php
session_start();
include ("db.php");

			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				$result = mysql_query("SELECT cow2 FROM game WHERE id='$gameid'",$db);
				$myrow = mysql_fetch_array($result);
				
				if (is_null($myrow['cow2'])) 
				{
					mysql_query("UPDATE user SET state = 'waiting', id_cell = NULL, grass = 0, power = 50, health = 100 WHERE id='$cowid'",$db);
					echo 2;//'Подходящий противник пока не пришел, пожалуйста, подождите';
				}
				else
				{
					mysql_query("UPDATE user SET state = 'game', id_cell = NULL, grass = 0, power = 50, health = 100 WHERE id='$cowid'",$db);
					$t = rand(1,2);
					if ($t==1)
						$turn = $cowid;
					else $turn = $myrow['cow2'];
					mysql_query("UPDATE game SET turn='$turn', status='on' WHERE id='$gameid'",$db);
					echo 1;
				}
    ?>