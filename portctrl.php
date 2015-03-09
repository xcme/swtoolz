<?php
  header('Content-type: text/html; charset=utf-8');

  if (isset($_GET['tport'])) $tport = $_GET['tport']; else $tport = 0;
  if (isset($_GET['ip'])) $ip = $_GET['ip']; else $ip = "172.17.76.250";
  if (isset($_GET['model'])) $model = $_GET['model']; else $model = 'DES-3028';
  if (isset($_GET['action'])) $action = $_GET['action']; else $action = "";

    // Подключаем блок с переменными
  include('variables.php');                
   
    // Проверяем, заданы ли пользователь и пароль в cookies
  $user = (isset($_COOKIE['user']))?$_COOKIE['user']:"anonymous";
  $password = (isset($_COOKIE['password']))?$_COOKIE['password']:"nopassword";

    // Подключаем блок с учетными записями
  include 'users.php';
  $usercannotcontrol='false';
    // Если пользователь определен (в файле)...
  if (isset($passwords[$user])&& ($authorizationrequired=='true'))
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
      else $usercannotcontrol='true';
    }
      // Если пользователь не определен (в файла) то также говорим о необходимости редиректа
    else $usercannotcontrol='true';
    // Если необходим редирект, выполняем его, удалив cookies
  if (($usercannotcontrol=='true') && ($authorizationrequired=='true'))
      {
      exit;
      }
      
    // Для совместимости с другими блоками пользуемся переменной 'ModelType'
  $ModelType = $model;                    
    // Получаем уникальный указатель для моделей 3028/3200
  $model = $p_oid[$ModelType];                

    // Переводим время для snmp-функций из секунд в микросекунды
  $timeout = $writetimeout*1000000;             
  $res = "";
  $actstr = "";

  if ($tport[0] == '0' && $tport != 0) $tport = str_ireplace('0', '', $tport);

  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28' || $ModelType == 'DGS-3100-24TG')
    {
      // Начальная часть OID
    $ctrlOID1 = ".1.3.6.1.4.1.171.11.";
      // Средняя часть OID
    $ctrlOID2 = ".2.2.2";
    if ($ModelType == 'DES-3026')
      {
        // Включение/выключение порта
      $ctrlOIDUpDown = ".1.2.";
        // Установка скорости порта
      $ctrlOIDSpd = ".1.3.";
      $sfx = "";
      }
      else
      {
            // Включение/выключение порта
      $ctrlOIDUpDown = ".1.3.";
            // Установка скорости порта
      $ctrlOIDSpd = ".1.4.";
            // Проверяем и указываем тип порта:
            //101 - оптика, 100 - медь
      if (stripos($tport, '(F)') !== false) $sfx = ".101"; else $sfx = ".100";
      }
      // Получаем переменную для отображения названия порта
    $echoport = $tport;
      // Удаляем символы '(F)' в переменной для управления портом
    $tport = str_ireplace('(F)', '', $tport);
      // Задаем скорость 10Mbps-Full - 3
    $act_mb10 = 3;
      // Задаем скорость 100Mbps-Full - 5
    $act_mb100 = 5;
      // Задаем скорость Auto - 1
    $act_auto = 1;
      // Определяем значение переменной для включения порта
    $act_en=3;
      // Определяем значение переменной для выключения порта
    $act_dis=2;
    }

  if ($ModelType == 'DES-3526')
    {
      // Начальная часть OID
    $ctrlOID1 = ".1.3.6.1.4.1.171.11.64";
      // Средняя часть OID
    $ctrlOID2 = ".1.2.4.2";
      // Включение/выключение порта
    $ctrlOIDUpDown = ".1.3.";
      // Установка скорости порта
    $ctrlOIDSpd = ".1.4.";
      // Для 3526 после порта указывается ничего не указывается
    $sfx = "";
      // Задаем скорость 10Mbps-Full - 4
    $act_mb10 = 4;
      // Задаем скорость 100Mbps-Full - 6
    $act_mb100 = 6;
      // Задаем скорость Auto - 2
    $act_auto = 2;
      // Определяем значение переменной для включения порта
    $act_en=3;
      // Определяем значение переменной для выключения порта
    $act_dis=2;
    }

  if ($ModelType == 'DGS-3100-24TG')
    {
      // Начальная часть OID
    $ctrlOID1 = ".1.3.6.1.2.1.2.2";
      // Средняя часть OID
    $ctrlOID2 = "";
      // Включение/выключение порта
    $ctrlOIDUpDown = ".1.7.";
      // Для 3526 после порта указывается ничего не указывается
    $sfx = "";
      // Определяем значение переменной для включения порта
    $act_en=1;
      // Определяем значение переменной для выключения порта
    $act_dis=2;
    }

  if (($tport != 0 && $tport < 25 && $enableportscontrol=='true') || ($tport != 0 && $tport > 24 && $enabledatawayportscontrol == 'true'))
    {
      // Включениие порта
    if ($action == "up")
      {
      if (@snmpset($ip, $wcomm, $ctrlOID1 . $model . $ctrlOID2 . $ctrlOIDUpDown . $tport . $sfx, "i", $act_en, $timeout, $retries) != false)
        $res = "<font color=#00ff00>OK</font>";
        else
        $res = "<font color=#ff0000>Fail!</font>";
      $actstr = "Порт {$echoport}: <font color=#00b400>включение</font>... ";
      }

      // Выключениие порта
    if ($action == "down")
      {
      if (@snmpset($ip, $wcomm, $ctrlOID1 . $model . $ctrlOID2 . $ctrlOIDUpDown . $tport . $sfx, "i", $act_dis, $timeout, $retries) != false)
        $res = "<font color=#00ff00>OK</font>";
        else
        $res = "<font color=#ff0000>Fail!</font>";
      $actstr = "Порт {$echoport}: <font color=#ff0000>выключение</font>... ";
      }

      // 10Мбит на порту
    if ($action == "mb10")
      {
      if (@snmpset($ip, $wcomm, $ctrlOID1 . $model . $ctrlOID2 . $ctrlOIDSpd . $tport . $sfx, "i", $act_mb10, $timeout, $retries) != false)
        $res = "<font color=#00ff00>OK</font>";
        else
        $res = "<font color=#ff0000>Fail!</font>";
      $actstr = "Порт {$echoport}: <font color=#00c8ff>10M Full</font>... ";
      }

      // 100Мбит на порту
    if ($action == "mb100")
      {
      if (@snmpset($ip, $wcomm, $ctrlOID1 . $model . $ctrlOID2 . $ctrlOIDSpd . $tport . $sfx, "i", $act_mb100, $timeout, $retries) != false)
        $res = "<font color=#00ff00>OK</font>";
        else
        $res = "<font color=#ff0000>Fail!</font>";
      $actstr = "Порт {$echoport}: <font color=#0000ff>100M Full</font>... ";
      }

      // Автоопределение скорости на порту
    if ($action == "auto")
      {
      if (@snmpset($ip, $wcomm, $ctrlOID1 . $model . $ctrlOID2 . $ctrlOIDSpd . $tport . $sfx, "i", $act_auto, $timeout, $retries) != false)
        $res = "<font color=#00ff00>OK</font>";
        else
        $res = "<font color=#ff0000>Fail!</font>";
      $actstr = "Порт {$echoport}: <font color=#808080>Auto</font>... ";
      }

    $actstr .= $res;
    }

  if ($action == "save" && $enablesavecontrol=='true')
    {
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
      // Сохранение параметров коммутатора
    if (@snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.1.2.6.0", "i", "5", $timeout, 0) != false)
      $res = "<font color=#00ff00>OK</font>";
      else
      $res = "<font color=#ff0000>Fail!</font>";

    if ($ModelType == 'DES-3526')
      {
        // Сохранение параметров коммутатора
      @snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.1.2.6.0", "i", "3", $timeout, 0);
      $res = "<font color=#0000ff>Запрос на сохранении конфигурации отправлен!</font>";
      }

    if ($ModelType == 'DGS-3100-24TG')
      {
        // Сообщение в случае использования DGS-3100-24TG
      $res = "<font color=#0000ff>Сохранение конфигурации для DGS-3100-24TG данным модулем не поддерживается!</font>";
      }

    $actstr = "<font color=#606060>Сохранение настроек</font>... ";
    $actstr .= $res;
    }
  echo $actstr;
?>