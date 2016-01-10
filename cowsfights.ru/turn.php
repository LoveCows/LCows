<?php
session_start();
include ("db.php");

			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				$x = $_POST['x'];
				$y = $_POST['y'];
				//$myrow1 = mysql_fetch_array($result1);
				
				$result = mysql_query("SELECT turn FROM game WHERE game.id='$gameid'",$db);
				$myrow = mysql_fetch_array($result);
				
				if ($myrow['turn']==$cowid) 
				{
					
					$result0 = mysql_query("SELECT id FROM game WHERE game.id='$gameid' AND cow1 = '$cowid'",$db);
					$myrow0 = mysql_fetch_array($result0);
					if (!empty($myrow0['id']))
					mysql_query("UPDATE game SET turn=game.cow2 WHERE id='$gameid'",$db);
					else
					mysql_query("UPDATE game SET turn=game.cow1 WHERE id='$gameid'",$db);
					
					$result1 = mysql_query("SELECT id, grass, bg, id_bonus as idb FROM cell WHERE cell.x='$x' AND cell.y='$y' AND cell.id_game = '$gameid' ",$db);
					$myrow1 = mysql_fetch_array($result1);
					$cellid = $myrow1['id'];
					$bg = $myrow1['bg'];
					$idbonus = $myrow1['idb'];
					
					$result2 = mysql_query("SELECT grass,health,power FROM user WHERE id = '$cowid'",$db);
					$myrow2 = mysql_fetch_array($result2);
					$grass = $myrow2['grass'] + $myrow1['grass'];
					$health = $myrow2['health'];
					$power = $myrow2['power'];
					
					
					
					$turn = 1;
						$result3 = mysql_query("SELECT x,y FROM cell,user WHERE user.id='$cowid' AND cell.id = user.id_cell",$db);
						$myrow3 = mysql_fetch_array($result3);
						$x1 = $myrow3['x'];
						$y1 = $myrow3['y'];
						
						mysql_query("UPDATE user SET id_cell='$cellid', grass = '$grass' WHERE id='$cowid'",$db);
					//mysql_query("UPDATE cell SET grass = 0, bg = 'grass' WHERE id='$cellid'",$db);
						
					if ($bg == 'grass')
					{
						
						mysql_query("UPDATE cell SET grass = 0, bg = 'grass' WHERE id='$cellid'",$db);
						$text = 0;
						$picture = 0;
					}
					else
					{
						$result4 = mysql_query("SELECT * FROM bonus WHERE id = '$idbonus'",$db);
						$myrow4 = mysql_fetch_array($result4);
						$text = $myrow4['text'];
						$column = $myrow4['column'];
						$picture = $myrow4['picture'];
						$value = $myrow4['value'];
						
						if ($column == 1)
						{
							$power = $power + $value;
							mysql_query("UPDATE user SET power = '$power' WHERE id='$cowid'",$db);
						}
						else
						{
							$health = $health + $value;
							mysql_query("UPDATE user SET health = '$health' WHERE id='$cowid'",$db);
						}
					}
				}
				else $turn = 0;
				$cart = array(
					"turn" => $turn,
					"cell"=>$cellid,
					"cow"=>$cowid,
					"grass"=>$grass,
					"x"=>$x1,
					"y"=>$y1,
					"bg"=>$bg,
					"text"=>$text,
					"picture"=>$picrure,
					"idb"=>$idbonus,
					"health"=>$health,
					"power"=>$power,
					);
				echo json_encode( $cart );
				
    ?>