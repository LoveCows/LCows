<?php
session_start();
include ("db.php");

				$cowid = $_SESSION['id'];
				$gameid = $_POST['id'];

				$result00 = mysql_query("SELECT x,y FROM user,cell WHERE user.id='$cowid' AND cell.id = user.id_cell",$db);
				$myrow00 = mysql_fetch_array($result00);
				$x1 = $myrow00['x'];
				$y1 = $myrow00['y'];
				
			    $cowid = $_SESSION['id'];
				$gameid = $_POST['id'];
				
				$result = mysql_query("UPDATE game SET fight=1 WHERE id='$gameid'",$db);
				
				$cart = array(
					"x"=>$x1,
					"y"=>$y1,
					);
				echo json_encode( $cart );
    ?>