<html>
    <head>
    <title>Регистрация</title>
	<link rel="shortcut icon" href="/images/cow_(2).ico" type="image/x-icon">
	<link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
	
	<div id="maket">
    <div id="header">Регистрация</div>
	<div id="reg">
    <form action="save_user.php" method="post">
    <!--**** save_user.php - это адрес обработчика.  То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей  отправятся на страничку save_user.php методом "post" ***** -->
<p>
    <label>Ваш логин:<br></label>
    <input name="login" type="text" size="15" maxlength="15">
    </p>
<!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
<p>
    <label>Ваш пароль:<br></label>
    <input name="password" type="password" size="15" maxlength="15">
    </p>
<!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** --> 
<p>
    <input type="submit" name="submit" value="Зарегистрироваться">
<!--**** Кнопочка (type="submit") отправляет данные на страничку save_user.php ***** --> 
</p></form>
</div>
</div>
    </body>
    </html>