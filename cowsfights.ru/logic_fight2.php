<?php
session_start();
include ("db.php");

			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				
				$result00 = mysql_query("SELECT x,y FROM user,cell WHERE user.id='$cowid' AND cell.id = user.id_cell",$db);
				$myrow00 = mysql_fetch_array($result00);
				$x1 = $myrow00['x'];
				$y1 = $myrow00['y'];
				
				$result = mysql_query("SELECT last_winner as win, fight FROM game WHERE game.id='$gameid'",$db);
				$myrow = mysql_fetch_array($result);
				$winner = $myrow['win'];
				$fight = $myrow['fight'];
				
				$result8 = mysql_query("SELECT health, grass FROM user WHERE user.id='$cowid'",$db);
				$myrow8 = mysql_fetch_array($result8);
				$health = $myrow8['health'];
				$grass = $myrow8['grass'];
				
					$cart = array(
					"winner" => $winner,
					"health" => $health,
					"x" => $x1,
					"y" => $y1,
					"fight" => $fight,
					"grass" => $grass,
					);
				echo json_encode( $cart );
				
    ?>