<?php
    //  ��� ��������� �������� �� �������. ������ � ��� �������� ������  ������������, ���� �� ��������� �� �����. ����� ����� ��������� �� �  ����� ������ ���������!!!
    session_start();
    ?>
    <html>
    <head>
	<link rel="shortcut icon" href="/images/cow.ico" type="image/x-icon">
    <title>Cows Fights</title>
	<link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
	<div id="maket" >
	<div id="header">Cows Fights </div>
    <div id="left">
    <form action="testreg.php" method="post">
	<!--****  testreg.php - ��� ����� �����������. �� ����, ����� ������� �� ������  "�����", ������ �� ����� ���������� �� ��������� testreg.php �������  "post" ***** -->
 <p>
    <label>��� �����:<br></label>
    <input name="login" type="text" size="15" maxlength="15">
    </p>


    <!--**** � ��������� ���� (name="login" type="text") ������������ ������ ���� ����� ***** -->
 
    <p>

    <label>��� ������:<br></label>
    <input name="password" type="password" size="15" maxlength="15">
    </p>

    <!--**** � ���� ��� ������� (name="password" type="password") ������������ ������ ���� ������ ***** --> 

    <p>
    <input type="submit" name="submit" value="�����">


    <!--**** �������� (type="submit") ���������� ������ �� ��������� testreg.php ***** --> 
<br>
 <!--**** ������ �� �����������, ���� ���-�� �� ������ ����� ���� �������� ***** --> 
<a href="reg.php">������������������</a> 
    </p></form>
    <br>
	</div>
	
    <div id="right"></div>
    
	<div id="footer">
	<?php
    // ���������, ����� �� ���������� ������ � id ������������
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
    // ���� �����, �� �� �� ������� ������
    echo "�� ����� �� ����, ��� �����<br><a href='#'>��� ������  �������� ������ ������������������ �������������</a>";
    }
    else
    {

    // ���� �� �����, �� �� ������� ������
    echo "�� ����� �� ����, ��� ".$_SESSION['login']."<br><a  href='pregame.php'>�� �������</a>";
    }
    ?>
	</div>
	</div>
    </body>
 
    
    </html>