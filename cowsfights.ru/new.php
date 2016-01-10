<?php
session_start();
include ("db.php");
class cell
{
	var $x;
	var $y;
	var $grass;
	var $bg;
	var $bonus;
     function cell($x,$y)
     {
         $this->x = $x;
		 $this->y = $y;
		 $this->grass = rand(0,3);
		 if ($this->grass == 0)
		 {
			 $this->bg = 'bonus';
			 $this->bonus = rand(1,8);
		 }
		 else 
		 {
			 $this->bg = 'grass';
			 $this->bonus = NULL;
		 }
     }
}

			    $cowid = $_SESSION['id'];
				$picid = $_POST['id'];
				mysql_query("UPDATE game SET status='off' WHERE cow1='$cowid'",$db);
				mysql_query("UPDATE game SET status='off' WHERE cow2='$cowid'",$db);
				mysql_query("UPDATE user SET state = 'game', id_cell = NULL, id_picture= '$picid', grass = 0, power = 50, health = 100 WHERE id='$cowid'",$db);
				$result = mysql_query("SELECT id FROM game WHERE cow2 IS NULL AND status IS NULL",$db);
				$myrow = mysql_fetch_array($result);
				if (!empty($myrow['id'])) 
				{
					$gameid = $myrow['id'];
				mysql_query("UPDATE game SET cow2='$cowid', status='on' WHERE id='$gameid'",$db);
		
				$cart = array(
					"status" => 1,
					"id" => $gameid
					);

					echo json_encode( $cart );
				}
				else
				{	mysql_query("INSERT INTO game (cow1) VALUES ('$cowid')",$db);
					$result = mysql_query("SELECT LAST_INSERT_ID()",$db);
					$myrow = mysql_fetch_array($result);
					$idg = $myrow['LAST_INSERT_ID()'];
					for($k=1;$k<=5;$k++)
						for ($j=1;$j<=5;$j++) 
						{
							$multable[$k][$j]= new cell($k,$j);
							$bg = $multable[$k][$j]->bg;
							$g = $multable[$k][$j]->grass;
							$b = $multable[$k][$j]->bonus;
							mysql_query("INSERT INTO cell (x,y,bg,grass,id_game,id_bonus) VALUES ('$k','$j','$bg','$g','$idg','$b')",$db);
						}
						
						$result3 = mysql_query("SELECT * FROM cell WHERE id_game = $idg",$db);
						$sum = 0;
						while ($row = mysql_fetch_array($result3))
						{
							$s = $sum;
							$sum = $s +  $row['grass'];
						}
						$max = intval($sum*0.4);
						mysql_query("UPDATE game SET max='$max' WHERE id = '$idg'",$db);
						
						
					$cart = array(
					"status" => 5,
					"id" => $idg
					);

					echo json_encode( $cart );//'Подходящий противник пока не пришел, пожалуйста, подождите';
					//echo 5;
				}
    ?>