<?php
    // Подключаем блок с переменными
  include 'variables.php';
    // Определяем ip коммутатора и используемый модуль
  if (isset($_GET['ip'])) $ip = $_GET['ip']; else $ip = $defaultip;
  if (isset($_GET['module'])) $module = $_GET['module']; else $module = $defaultmodule;
    // Обнуляем cookies
  setcookie('user', '', time()-3600*$cookieslifetime );
  setcookie('password', '', time()-3600*$cookieslifetime );;
    // Проверяем, заданы ли логин и пароль в предыдущей сессии (была нажата кнопка 'Войти')
  if (isset($_REQUEST["login"])) $login=$_REQUEST["login"]; else $login="";
  if (isset($_REQUEST["pass"])) $pass=$_REQUEST["pass"]; else $pass="";
  if (isset($_REQUEST["rdrstr"])) $rdrstr=$_REQUEST["rdrstr"]; else $rdrstr="";
    // Если логин и пароль не пустые, записываем их в cookies
  if ($login!='' && $pass!='')
    {
    setcookie('user', $login, time()+3600*$cookieslifetime );
    setcookie('password', md5($pass), time()+3600*$cookieslifetime );
    header('Location: index.php'.$rdrstr);
    }
    // Если имя пользователя и пароль заданы в блоке переменных, то формируем дополнительную надпись под кнопкой 'Войти в систему'
  if ($defaut_user!='' && $default_password!='') $tmpstr="<br><a href='index.php'>Войти в гостевом режиме</a>"; else $tmpstr='';
    // Формируем блок ввода логина и пароля
  $formtable  = "\n<form>";
  $formtable .= "\n<table border=1 width=250 class='smalltbl'>\n\t<tr class='head'>\n\t\t";
  $formtable .= "<td class='tablehead' colspan=6>Пожалуйста, авторизуйтесь!</td>";
  $formtable .= "\n\t</tr>\n\t<tr>\n\t\t";
  $formtable .= "<td class='tdhgl1' style='padding: 4px 10px;'>Логин:</td>\n\t\t";
  $formtable .= "<td class='tdnorm1' style='padding: 2px 20px;'><input type='text' name='login' value=''><br></td>";
  $formtable .= "\n\t</tr>\n\t<tr>\n\t\t";
  $formtable .= "<td class='tdhgl1' style='padding: 4px 10px;'>Пароль:</td>\n\t\t";
  $formtable .= "<td class='tdnorm1' style='padding: 2px 20px;'><input type='password' name='pass' value=''><br></td>";
  $formtable .= "\n\t</tr>\n\t<tr>\n\t\t";
  $formtable .= "<td colspan=2 style='background-color: #fff9bd;text-align: center;'><input type='submit' value='Войти в систему'>".$tmpstr."</td>";
  $formtable .= "\n\t</tr>\n</table>";
  $formtable .= "\n<input type='hidden' name='rdrstr' value='?module=".$module."&ip=".$ip."'>\n</form>\n";
  echo "<html>\n";
  echo "\n<head>";
  echo "\n<META http-equiv=Content-Type content='text/html; charset=utf-8'>";
  echo "\n<link rel='stylesheet' href='./_swtoolz.css'/>";
  echo "\n<title>swtoolz - Авторизация</title>";
  echo "\n</head>\n";
  echo "\n<body>\n";
  echo "<div style='width:250px;height:250px;position:relative;left:50%;top:40%;margin-left:-125px;margin-top:-125px;'>";
  echo $formtable;
  echo "</div>";
  echo "\n</body>";
  echo "\n</html>";
?>