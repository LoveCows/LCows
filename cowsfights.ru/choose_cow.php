<?php
session_start();
include ("db.php");

				$sex = $_POST['sex'];
				$spot = $_POST['spot'];
				$collar = $_POST['collar'];
				
				$result00 = mysql_query("SELECT picture, id FROM cow_picture WHERE sex='$sex' AND spots_color='$spot' AND collar_color='$collar'",$db);
				$myrow00 = mysql_fetch_array($result00);
				if (empty($myrow00['picture']))
				{	
					$pic = 'cat_.png';
					$id = 1;
				}
				else
				{
					$pic = $myrow00['picture'];
					$id = $myrow00['id'];
				}
				$cart = array(
					"pic"=>$pic,
					"id"=>$id,
					);
				echo json_encode( $cart );
    ?>