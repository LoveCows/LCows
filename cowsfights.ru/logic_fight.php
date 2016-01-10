<?php
session_start();
include ("db.php");

			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				
				
				$result = mysql_query("SELECT cow1 FROM game WHERE game.id='$gameid' AND cow1 = '$cowid'",$db);
					$myrow = mysql_fetch_array($result);
					
					if (!empty($myrow['cow1']))
					{
					$result1 = mysql_query("SELECT cow2 FROM game WHERE cow1 = '$cowid' AND id = '$gameid'",$db);
					$myrow1 = mysql_fetch_array($result1);
					$cow = $myrow1['cow2'];
					$attaker_number  = 2;
					$defender_number = 1;
					}
					else 
					{
					$result1 = mysql_query("SELECT cow1 FROM game WHERE cow2 = '$cowid' AND id = '$gameid'",$db);
					$myrow1 = mysql_fetch_array($result1);
					$cow = $myrow1['cow1'];
					$attaker_number  = 1;
					$defender_number = 2;
					}
					
				$result2 = mysql_query("SELECT health, power, grass FROM user WHERE user.id='$cowid'",$db);
				$myrow2 = mysql_fetch_array($result2);
				$defender_power = $myrow2['power'];
				$defender_health = $myrow2['health'];
				$defender_grass = $myrow2['grass'];
				
				$result3 = mysql_query("SELECT health, power, grass FROM user WHERE user.id='$cow'",$db);
				$myrow3 = mysql_fetch_array($result3);
				$attaker_power = $myrow3['power'];
				$attaker_health = $myrow3['health'];
				$attaker_grass = $myrow3['grass'];
				
				$defender_damage = intval($attaker_power*$attaker_health/300) + mt_rand( -3 , 3 );
				$attaker_damage = intval($defender_power*$defender_health/300) + mt_rand( -3 , 3 );
				$defender_health_new = $defender_health - $defender_damage;
				$attaker_health_new = $attaker_health - $attaker_damage;
				
				mysql_query("UPDATE user SET health = '$attaker_health_new' WHERE user.id='$cow'",$db);
				mysql_query("UPDATE user SET health = '$defender_health_new' WHERE user.id='$cowid'",$db);
				
				if ($defender_damage > $attaker_damage)
				{					$winner = 1;//если победил атакующий
									$grass = intval(0.3 * $defender_grass);
									$attaker_grass_new = $attaker_grass + $grass;
									$defender_grass_new = $defender_grass - $grass;
									mysql_query("UPDATE user SET grass = '$attaker_grass_new' WHERE user.id='$cow'",$db);
									mysql_query("UPDATE user SET grass = '$defender_grass_new' WHERE user.id='$cowid'",$db);
									
				}
				if ($defender_damage < $attaker_damage)
				{
									$winner = 2;
									$grass = intval(0.3 * $attaker_grass);
									$attaker_grass_new = $attaker_grass - $grass;
									$defender_grass_new = $defender_grass + $grass;
									mysql_query("UPDATE user SET grass = '$attaker_grass_new' WHERE user.id='$cow'",$db);
									mysql_query("UPDATE user SET grass = '$defender_grass_new' WHERE user.id='$cowid'",$db);
				}					
				if ($defender_damage == $attaker_damage) $winner = 0;
				
				mysql_query("UPDATE game SET last_winner = '$winner' WHERE game.id='$gameid'",$db);
				mysql_query("UPDATE game SET fight = 0, turn = '$cowid' WHERE game.id='$gameid'",$db);
				
				$result8 = mysql_query("SELECT health FROM user WHERE user.id='$cowid'",$db);
				$myrow8 = mysql_fetch_array($result8);
				$health = $myrow8['health'];
				
					$cart = array(
					"winner" => $winner,
					"health" => $health,
					"grass" => $defender_grass_new,
					);
				echo json_encode( $cart );
				
    ?>