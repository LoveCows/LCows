<?php
session_start();
include ("db.php");

			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				
				$result00 = mysql_query("SELECT x,y FROM user,cell WHERE user.id='$cowid' AND cell.id = user.id_cell",$db);
				$myrow00 = mysql_fetch_array($result00);
				$x1 = $myrow00['x'];
				$y1 = $myrow00['y'];
				
				$result0 = mysql_query("SELECT turn, fight FROM game WHERE id='$gameid'",$db);
				$myrow0 = mysql_fetch_array($result0);
				$fight = $myrow0['fight'];
				
				$result = mysql_query("SELECT cow1 FROM game WHERE game.id='$gameid' AND cow1 = '$cowid'",$db);
					$myrow = mysql_fetch_array($result);
					
					if (!empty($myrow['cow1']))
					{
					$result1 = mysql_query("SELECT cow2 FROM game WHERE cow1 = '$cowid' AND id = '$gameid'",$db);
					$myrow1 = mysql_fetch_array($result1);
					$cow = $myrow1['cow2'];
					}
					else 
					{
					$result1 = mysql_query("SELECT cow1 FROM game WHERE cow2 = '$cowid' AND id = '$gameid'",$db);
					$myrow1 = mysql_fetch_array($result1);
					$cow = $myrow1['cow1'];
					}
					
					$result2 = mysql_query("SELECT x, y FROM user,cell WHERE user.id = '$cow' AND id_cell = cell.id",$db);
					$myrow2 = mysql_fetch_array($result2);
					{
						$x = $myrow2['x'];
						$y = $myrow2['y'];
					}
				
				if ($myrow0['turn']==$cowid) $turn = 1;
				else $turn = 0;
					$cart = array(
					"turn" => $turn,
					"x" => $x,
					"y" => $y,
					"x1" => $x1,
					"y1" => $y1,
					"z" => $cow,
					"a" => $gameid,
					"b" => $cowid,
					"fight" => $fight
					);
				echo json_encode( $cart );
				
    ?>