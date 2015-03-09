<?php
    // Подключаем блок с переменными
  include 'variables.php';
    // Определяем ip коммутатора и используемый модуль
  if (isset($_GET['ip'])) $ip = $_GET['ip']; else $ip = $defaultip;
  if (isset($_GET['module'])) $module = $_GET['module']; else $module = $defaultmodule;
    //  Определяем дополнительную строку редиректа на случай, если он понадобится
  $rdrstr='?module='.$module.'&ip='.$ip;
    // Проверяем, заданы ли пользователь и пароль в cookies
  $user = (isset($_COOKIE['user']))?$_COOKIE['user']:"anonymous";
  $password = (isset($_COOKIE['password']))?$_COOKIE['password']:"nopassword";
    // Если имя пользователя и пароль заданы в блоке переменных и не определены явно, то для авторизации используем значения из файла variables.php
  if (($defaut_user!='' && $default_password!='') && ($user=='anonymous' || $password=='nopassword'))
    {
    $user=$defaut_user;
    $password=$default_password;
    }
    // Если пользователь или пароль не определены, вызываем страницу авторизации (в случае, если авторизация включена глобально)
  if (($user=='anonymous' || $password=='nopassword') && ($authorizationrequired=='true'))
    {
    header('Location: logon.php'.$rdrstr);
    exit;
    }
    // Подключаем блок с учетными записями
  include 'users.php';
  $needredirect='false';
    // Если пользователь определен (в файле)...
  if (isset($passwords[$user])&&($authorizationrequired=='true'))
      // ..проверяем соответствие пароля
    {
    if (md5($passwords[$user])==$password || $passwords[$user]==$password)
      {
        // Если права для пользователя определены (в файле) то перекрываем ими права по умолчанию (при верном пароле)
      if (isset($portsrights[$user])) $enableportscontrol=$portsrights[$user];
      if (isset($datawayportsrights[$user])) $enabledatawayportscontrol=$datawayportsrights[$user];
      if (isset($savecontrolrights[$user])) $enablesavecontrol=$savecontrolrights[$user];
      }
        // Если пароль не верен то говорим о необходимости редиректа
      else $needredirect='true';
    }
      // Если пользователь не определен (в файла) то также говорим о необходимости редиректа
    else $needredirect='true';
    // Если необходим редирект, выполняем его, удалив cookies
  if (($needredirect=='true') && ($authorizationrequired=='true'))
      {
      setcookie('user', '', time()-3600*$cookieslifetime );
      setcookie('password', '', time()-3600*$cookieslifetime );
      header('Location: logon.php'.$rdrstr);
      exit;
      }
    // Подключаем блок, определяющий модель коммутатора
  include 'models.php';
    // Подключаем блок с функциями
  include 'functions.php';
    // Переводим время для snmp - функций из секунд в микросекунды
  $timeout = $timeout * 1000000;
  $writetimeout = $writetimeout * 1000000;
    // Для модели DGS-3100-24TG увеличиваем время ожидания вдвое
  if ($ModelType == 'DGS-3100-24TG')
    {
    $timeout=$timeout*2;
    $max_exec_time=$max_exec_time*2;
    }
    // Устанавливаем максимальное время исполнения скрипта
  ini_set('max_execution_time', $max_exec_time);
    // Устанавливаем сокращенный вывод для snmp-запросов
  snmp_set_quick_print(1);
    // Устанавливаем числовой вывод для snmp-запросов если версия PHP старше 5.2
  if (substr(phpversion(),0,3)>5.2) @snmp_set_enum_print(1);
    // Устанавливаем тип вывода для snmp-запросов
  snmp_set_valueretrieval(0);
    // По умолчанию ошибок не обнаружено, о чем сообщаем в значении переменной
  $noerrors = "true";
    // Определяем значение версии модуля на случай, если оно не определено в самом модуле
  $modulever = '0.00';
    // Текущая версия скрипта
  $current_version = '0.99b';
    // Подключаем блок c информацией о коммутаторе
  include 'infosw.php';
    // Подключаем основной модуль
  @include('./modules/' . $module . '_mod.php');

        //<--Начало блока:'Формирование верхнего меню со вкладками'--
    // Говорим, что по дефолту у нас как минимум 1 колонка (модуль)
  $col_count = 1;            
    // Считаем, сколько модулей определено всего
  while (isset(${'menu_item' . $col_count})) 
    {
    $col_count++;
    }
    // Считаем ширину каждой колонки меню в зависимости от количества модулей
  $wdthprc = 100 / ($col_count - 1);
    // Обнуляем значение переменной
  $menuline = '';
    // Снова начинаем пробег с одного модуля
  $col_count = 1;
    // Выполняем цикл по всему списку
  while (isset(${'menu_item' . $col_count})) 
    {   
        // Определяем активный модуль и подсвечиваем его
    if (${'menu_item' . $col_count . 'mod'} == $module) 
      {
      $itemclass = 'itemselected';
      $curr_mod = ${'menu_item' . $col_count};
      }
      else $itemclass = 'itemnormal';
        // Формируем ряд таблицы, содержащий вкладки со ссылками
    $menuline .= "\n\t\t<td class='{$itemclass}' width=$wdthprc%>";
    $menuline .= "<a href='index.php?module=${'menu_item'.$col_count.'mod'}&ip={$ip}'>";
    $menuline .= "${'menu_item'.$col_count}</a></td>";
        // Инкрементируем значение переменной для перехода по циклу
    $col_count++;
    }
    // Поскольку значение на единицу больше фактического - отнимаем 1
  $col_count--;
    // Определяем начало таблицы меню
  $menutop_tbl = "\n<table class='topmenu'>";
    // Добавляем в таблицу подготовленный ряд вкладок
  $menutop_tbl .= "\n\t<tr>{$menuline}\n\t</tr>";
    // Добавляем декоративный нижний ряд
  $menutop_tbl .= "\n\t<tr class='bottomline'>\n\t\t<td colspan={$col_count}></td>\n\t</tr>";
    // Закрываем таблицу
  $menutop_tbl .= "\n</table>\n";
        //--- Конец блока:'Формирование верхнего меню со вкладками'--->

        // <--- Начало блока: 'Формирование таблицы с информацией о коммутаторе' ---
  $smalltbl = "\n<table border=1 width=100% class='smalltbl'>\n\t<tr class='head'>\n\t\t";
  $smalltbl .= "<td class='tablehead' colspan=6>Информация о коммутаторе</td>";
  $smalltbl .= "\n\t</tr>\n\t<tr>\n\t\t";
  $smalltbl .= "<td class='tdhgl1'>Название модели:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm1'>" . str_ireplace('"', '', $sysDescr) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl2'>Имя:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm2'>" . str_ireplace('"', '', $sysName) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl3'>Прошивка 1 во flash:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm3'>" . $swFirm1Info . "</td>";
  $smalltbl .= "\n\t</tr>\n\t<tr>\n\t\t<td class='tdhgl1'>IP-адрес:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm1'>" . $ip . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl2'>Расположение:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm2'>" . str_ireplace('"', '', $sysLocation) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl3'>Прошивка 2 во flash:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm3'>" . $swFirm2Info . "</td>";
  $smalltbl .= "\n\t</tr>\n\t<tr>\n\t\t<td class='tdhgl1'>MAC-адрес:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm1'>" . str_ireplace('"', '', $sysMACaddr) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl2'>Контакты:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm2'>" . str_ireplace('"', '', $sysContact) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl3'>Кто и откуда прошил №1:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm3'>" . $swUser1Info . "</td>";
  $smalltbl .= "\n\t</tr>\n\t<tr>\n\t\t<td class='tdhgl1'>Версия прошивки:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm1'>" . str_ireplace('"', '', $sysFirmvare) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl2'>Корневой порт:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm2'>" . $sysRootPort . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl3'>Кто и откуда прошил №2:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm3'>" . $swUser2Info . "</td>";
  $smalltbl .= "\n\t</tr>\n\t<tr>\n\t\t<td class='tdhgl1'>Время работы:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm1'>" . str_ireplace('Timeticks: ', '', $sysUptime) . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl2'>Приоритет STP:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm2'>" . $swMSTPInstPriority . "</td>\n\t\t";
  $smalltbl .= "<td class='tdhgl3'>Серийный номер:</td>\n\t\t";
  $smalltbl .= "<td class='tdnorm3'>" . str_ireplace('"', '', $sysSerial) . "</td>";
  $smalltbl .= "\n\t</tr>\n</table>\n";
        // --- Конец блока: 'Формирование таблицы с информацией о коммутаторе' --->

        // <--- Начало блока: 'Вывод html-кода' ---
  echo "<html>\n";
  echo "\n<head>";
  echo "\n<META http-equiv=Content-Type content='text/html; charset=utf-8'>";
  echo "\n<link rel='stylesheet' href='./_swtoolz.css'/>";
  echo "\n<title>swtoolz ver. $current_version - '$curr_mod' v {$modulever} - [$user]</title>\n";
    // Подключаем блок со скриптом для журнала модуля 'ports'
  include('log_script.php');
  echo "\n</head>\n";
  echo "\n<body>\n";
    // Выводим таблицу с меню
  echo $menutop_tbl;
    // Выводим таблицу с информацией о коммутаторе
  echo $smalltbl;
    // Выводим таблицу из основного модуля
  echo $swtable;
    // Выводим блок с информацией о версии модуля, с вспомогательной информацией и с информацией об ошибках
  echo "\n<div class='bottom'>\n";
  echo "<br>SWToolz ver. $current_version - Набор модулей для опроса коммутаторов D-Link © 2010";
  if ($authorizationrequired=='true') echo "<br><br><a href='logon.php".$rdrstr."'>Смена пользователя / Выход из системы</a>";
  if ($noerrors == false)
    {
    echo "<font color=#ff0000><br>* Часть функций отработала некорректно.";
    echo "Возможно, Вы используете старую прошивку на коммутаторе или неправильные настройки.</font>";
    }
  echo "\n</div>\n";
  echo "\n</body>";
  echo "\n</html>";
    // --- Конец блока: 'Вывод html-кода' --->
?>