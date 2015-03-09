<?php
        // --- Начало модуля: 'Информация о портах' ---
  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
    {
      // Описание портов
    $portDescription = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.6", $timeout, $retries);

    for ($pi = 1; $pi < $portscount[$ModelType] + 1; $pi++)
      {
      $portDescription[$pi - 1] = str_ireplace(' ', '', $portDescription[$pi - 1]);
      $portDescription[$pi - 1] = str_ireplace('"', '', $portDescription[$pi - 1]);
      $portDescription[$pi - 1] = str_ireplace('00', '', $portDescription[$pi - 1]);
      $portDescription[$pi - 1] = str_ireplace(chr(10), '', $portDescription[$pi - 1]);
      $portDescription[$pi - 1] = str_ireplace(chr(9), '', $portDescription[$pi - 1]);
      if ($ModelType != 'DES-3200-28') $portDescription[$pi - 1] = hextostr($portDescription[$pi - 1]);
      }

      // Административный статус порта
    $portAdminState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.3", $timeout, $retries); 
      // Выставленная скорость на порту
    $portCtrlNwayState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.4", $timeout, $retries); 
      // Состояние линка
    $portLinkStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.1.1.4", $timeout, $retries); 
      // Фактическая скорость линка
    $portNwayStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.1.1.5", $timeout, $retries);  
    }

    if ($ModelType == 'DGS-3100-24TG')
    {
      // Описание портов
    $portDescription = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.31.1.1.1.18", $timeout, $retries); 
      // Административный статус порта
    $portAdminState = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.2.2.1.7", $timeout, $retries); 
      // Выставленная скорость на порту
    $portCtrlNwayState = array(); 
      // Состояние линка
    $portLinkStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.2.2.1.8", $timeout, $retries);
      // Фактическая скорость 
    $portNwayStatus = array();  
    }

  if ($ModelType == 'DES-3026')
    {
      // Описание портов
    $portDescription = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.31.1.1.1.18", $timeout, $retries); 
      // Административный статус порта
    $portAdminState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.2", $timeout, $retries); 
      // Выставленная скорость на порту
    $portCtrlNwayState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.3", $timeout, $retries); 
      // Состояние линка
    $portLinkStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.1.1.4", $timeout, $retries); 
      // Фактическая скорость 
    $portNwayStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.1.1.5", $timeout, $retries);  
    }

  if ($ModelType == 'DES-3526')
    {
      // Описание портов
    $portDescription = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.31.1.1.1.18", $timeout, $retries); 
      // Административный статус порта
    $portAdminState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.4.2.1.3", $timeout, $retries); 
      // Выставленная скорость на порту
    $portCtrlNwayState = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.4.2.1.4", $timeout, $retries); 
      // Состояние линка
    $portLinkStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.4.1.1.4", $timeout, $retries); 
      // Фактическая скорость линка
    $portNwayStatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.4.1.1.5", $timeout, $retries);  
    }

    // CRC-errors на порту
  $portCrcErrors = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.16.1.1.1.8", $timeout, $retries); 
    // Undersize-errors на порту
  $portUnderSizeErrors = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.16.1.1.1.9", $timeout, $retries); 
    // Oversize-errors на порту
  $portOverSizeErrors = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.16.1.1.1.10", $timeout, $retries); 
    // Fragment-errors на порту
  $portFragmentErrors = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.16.1.1.1.11", $timeout, $retries); 
    // Jabber-errors на порту
  $portJabberErrors = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.16.1.1.1.12", $timeout, $retries); 
    // Всего TX на порту
  $portTxTotal = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.2.2.1.16", $timeout, $retries); 
    // Всего RX на порту
  $portRxTotal = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.2.2.1.10", $timeout, $retries); 

  if (($ModelType != 'DES-3526' && $skipcablediaginitfor3526 == 'false') || $ModelType != 'DES-3026' || $ModelType != 'DGS-3100-24TG') 
    {
    for ($pi = 1; $pi < 25; $pi++) 
      if (@snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.12." . $pi, "i", "1", $writetimeout, $retries) == false) $noerror = false;
      // Для 3200-28 делаем паузу в опросе, иначе часто получаем статус пары 'other'. Может исправят в новых прошивках
    if ($ModelType == 'DES-3200-28') usleep($timeout);
    }
    
    //Диагностика кабеля
  for ($pi = 1; $pi < 25; $pi++) 
    {
      //без этой конструкции у меня не работал скрипт на 3026, с ней на 3028
    if ($ModelType == 'DES-3026') 
      if (@snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.12." . $pi, "i", "1", $writetimeout, $retries) == false) $noerror = false;

      // Статус линка
    $cableDiagLinkStatus[$pi - 1] = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.3." . $pi, $timeout, $retries); 
      // Статус 1-й пары
    $cableDiagPair1Status[$pi - 1] = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.4." . $pi, $timeout, $retries);
      // Статус 2-й пары
    $cableDiagPair2Status[$pi - 1] = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.5." . $pi, $timeout, $retries); 
      // Длина 1-й пары
    $cableDiagPair1Length[$pi - 1] = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.8." . $pi, $timeout, $retries); 
      // Длина 2-й пары
    $cableDiagPair2Length[$pi - 1] = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.58.1.1.1.9." . $pi, $timeout, $retries); 
    } 

    // Список названий vlan
  $dot1qTpVlanStaticName = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.1", $timeout, $retries);         
    // Список нетегированных портов в вланах
  $dot1qVlanStaticUntaggedPorts = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.4", $timeout, $retries);     
    // Оставляем в ключе массива только нужную информацию
  $dot1qTpVlanStaticName = keyscut($dot1qTpVlanStaticName);                    
    // Оставляем в ключе массива только нужную информацию
  $dot1qVlanStaticUntaggedPorts = keyscut($dot1qVlanStaticUntaggedPorts);            
    // Заполняем массив с vlan'ами пустотой, иначе array_splice глючит безбожно
  $untag_vlan = array_fill(0, $uniqueportscount[$ModelType], '');                

  for ($t = 0; $t < count($dot1qTpVlanStaticName); $t++)
    {
    $vlan_name = $dot1qTpVlanStaticName[key($dot1qTpVlanStaticName)];
    $vlan_name = str_ireplace('"', "", $vlan_name);
    $vid = key($dot1qTpVlanStaticName);
    $uports = $dot1qVlanStaticUntaggedPorts[$vid];
    $uports = stripstr($uports);

      // Чит для 3526, когда вместо hex-строки возвращается string
    if (strlen($uports) == 4) $uports = strtohex($uports);
    $uports = decbin(hexdec($uports));
    while (strlen($uports) < 32) $uports = "0" . $uports;
    for ($tt = 1; $tt < $uniqueportscount[$ModelType] + 1; $tt++)
      if ($uports[$tt - 1] == 1) $untag_vlan[$tt - 1] = $vlan_name . ': ' . $vid;
    next($dot1qTpVlanStaticName);
    }

  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028P')
    {
    array_splice($untag_vlan, 25, 0, 'n\a');
    array_splice($untag_vlan, 27, 0, 'n\a');

    array_splice($portCrcErrors, 25, 0, 'n\a');
    array_splice($portCrcErrors, 27, 0, 'n\a');

    array_splice($portUnderSizeErrors, 25, 0, 'n\a');
    array_splice($portUnderSizeErrors, 27, 0, 'n\a');

    array_splice($portOverSizeErrors, 25, 0, 'n\a');
    array_splice($portOverSizeErrors, 27, 0, 'n\a');

    array_splice($portFragmentErrors, 25, 0, 'n\a');
    array_splice($portFragmentErrors, 27, 0, 'n\a');

    array_splice($portJabberErrors, 25, 0, 'n\a');
    array_splice($portJabberErrors, 27, 0, 'n\a');

    array_splice($portTxTotal, 25, 0, 'n\a');
    array_splice($portTxTotal, 27, 0, 'n\a');

    array_splice($portRxTotal, 25, 0, 'n\a');
    array_splice($portRxTotal, 27, 0, 'n\a');
    }

  if ($ModelType == 'DES-3028G' || $ModelType == 'DES-3200-28')
    {
    array_splice($untag_vlan, 25, 0, 'n\a');
    array_splice($untag_vlan, 27, 0, 'n\a');
    array_splice($untag_vlan, 29, 0, 'n\a');
    array_splice($untag_vlan, 31, 0, 'n\a');

    array_splice($portCrcErrors, 25, 0, 'n\a');
    array_splice($portCrcErrors, 27, 0, 'n\a');
    array_splice($portCrcErrors, 29, 0, 'n\a');
    array_splice($portCrcErrors, 31, 0, 'n\a');

    array_splice($portUnderSizeErrors, 25, 0, 'n\a');
    array_splice($portUnderSizeErrors, 27, 0, 'n\a');
    array_splice($portUnderSizeErrors, 29, 0, 'n\a');
    array_splice($portUnderSizeErrors, 31, 0, 'n\a');

    array_splice($portOverSizeErrors, 25, 0, 'n\a');
    array_splice($portOverSizeErrors, 27, 0, 'n\a');
    array_splice($portOverSizeErrors, 29, 0, 'n\a');
    array_splice($portOverSizeErrors, 31, 0, 'n\a');

    array_splice($portFragmentErrors, 25, 0, 'n\a');
    array_splice($portFragmentErrors, 27, 0, 'n\a');
    array_splice($portFragmentErrors, 29, 0, 'n\a');
    array_splice($portFragmentErrors, 31, 0, 'n\a');

    array_splice($portJabberErrors, 25, 0, 'n\a');
    array_splice($portJabberErrors, 27, 0, 'n\a');
    array_splice($portJabberErrors, 29, 0, 'n\a');
    array_splice($portJabberErrors, 31, 0, 'n\a');

    array_splice($portTxTotal, 25, 0, 'n\a');
    array_splice($portTxTotal, 27, 0, 'n\a');
    array_splice($portTxTotal, 29, 0, 'n\a');
    array_splice($portTxTotal, 31, 0, 'n\a');

    array_splice($portRxTotal, 25, 0, 'n\a');
    array_splice($portRxTotal, 27, 0, 'n\a');
    array_splice($portRxTotal, 29, 0, 'n\a');
    array_splice($portRxTotal, 31, 0, 'n\a');
    }

  if ($ModelType == 'DES-3526') $nocomboports = 2; else $nocomboports = 0;
  if ($ModelType == 'DES-3526' && $skipcablediaginitfor3526 == 'true') $diagskip = '<br>(<font color=#ff0000>информация не актуальна</font>)'; 
    else  $diagskip = '';

  $swtable = "\n<table border=1 width='100%'>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>№<br>порта</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Описание<br>порта</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Метка untag<br>(Имя vlan/VID)</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Статус<br>(Адм./Линк)</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Скорость<br>(Адм.)</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Состояние<br>линка</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Диагностика кабеля{$diagskip}</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Ошибки<br>(CRC/Und/Ovr/Frg/Jab)</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Пакеты<br>(Rx/Tx)</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Управление<br>";
    // Отображать или нет кнопку 'Сохранить'
  $savestr = '';
  if ($enablesavecontrol == 'true') $savestr = "<a class='save' href='#' onclick='return PortControl(0,\"save\")'>Сохранить</a>";
  $swtable .= $savestr."</td>";

  for ($pi = 1; $pi < $portscount[$ModelType] + 1 - $nocomboports; $pi++)
    {
    $kport = $pi;
    $pitmp = $pi - 1;
    if (strlen($kport) == 1) $kport = "0" . $kport;

    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028P')
      {
      if ($kport == 26) $kport = "25(F)";
      if ($kport == 27) $kport = "26";
      if ($kport == 28) $kport = "26(F)";
      if ($kport == 29) $kport = "27";
      if ($kport == 30) $kport = "28";
      }

    if ($ModelType == 'DES-3028G' || $ModelType == 'DES-3200-28')
      {
      if ($kport == 26) $kport = "25(F)";
      if ($kport == 27) $kport = "26";
      if ($kport == 28) $kport = "26(F)";
      if ($kport == 29) $kport = "27";
      if ($kport == 30) $kport = "27(F)";
      if ($kport == 31) $kport = "28";
      if ($kport == 32) $kport = "28(F)";
      }

    $pDesc = str_ireplace('"', '', $portDescription[$pi - 1]);
    $pDesc = htmlspecialchars($pDesc);
    $pLnkSt = "unknown";
    $pAdmSt = "unknown";
    $pCtlSpd = "unknown";
    $pLnkSpd = "unknown";

      
    if ($ModelType != 'DGS-3100-24TG')
      {
        //Состояние линка порта
      if ($portLinkStatus[$pi - 1] == 2) $pLnkSt = "<font color=#00b400>LinkUp</font>";
      if ($portLinkStatus[$pi - 1] == 3) $pLnkSt = "LinkDown";

        //Включен порт или выключен
      if ($portAdminState[$pi - 1] == 2) $pAdmSt = "<font color=#ff0000>Disabled</font>";
      if ($portAdminState[$pi - 1] == 3) $pAdmSt = "Enabled";
      }
      else
      {
      if ($portLinkStatus[$pi - 1] == 1) $pLnkSt = "<font color=#00b400>LinkUp</font>";
      if ($portLinkStatus[$pi - 1] == 2) $pLnkSt = "LinkDown";

        //Включен порт или выключен
      if ($portAdminState[$pi - 1] == 2) $pAdmSt = "<font color=#ff0000>Disabled</font>";
      if ($portAdminState[$pi - 1] == 1) $pAdmSt = "Enabled";
      }
      
      //Скорость выставленная на порту для 3028, 3028g, 3026, 3200-28
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
      {
      if ($portCtrlNwayState[$pi - 1] == 1) $pCtlSpd = "Auto";
      if ($portCtrlNwayState[$pi - 1] == 2) $pCtlSpd = "10Mbps-Half";
      if ($portCtrlNwayState[$pi - 1] == 3) $pCtlSpd = "10Mbps-Full";
      if ($portCtrlNwayState[$pi - 1] == 4) $pCtlSpd = "100Mbps-Half";
      if ($portCtrlNwayState[$pi - 1] == 5) $pCtlSpd = "100Mbps-Full";
      if ($portCtrlNwayState[$pi - 1] == 6) $pCtlSpd = "1Gigabps-Half";
      if ($portCtrlNwayState[$pi - 1] == 7) $pCtlSpd = "1Gigabps-Full";
      if ($portCtrlNwayState[$pi - 1] == 8) $pCtlSpd = "1Gigabps-Full-Master";
      if ($portCtrlNwayState[$pi - 1] == 9) $pCtlSpd = "1Gigabps-Full-Slave";
      }

      //Скорость выставленная на порту для 3526
    if ($ModelType == 'DES-3526')
      {
      if ($portCtrlNwayState[$pi - 1] == 2) $pCtlSpd = "Auto";
      if ($portCtrlNwayState[$pi - 1] == 3) $pCtlSpd = "10Mbps-Half";
      if ($portCtrlNwayState[$pi - 1] == 4) $pCtlSpd = "10Mbps-Full";
      if ($portCtrlNwayState[$pi - 1] == 5) $pCtlSpd = "100Mbps-Half";
      if ($portCtrlNwayState[$pi - 1] == 6) $pCtlSpd = "100Mbps-Full";
      if ($portCtrlNwayState[$pi - 1] == 7) $pCtlSpd = "1Gigabps-Half";
      if ($portCtrlNwayState[$pi - 1] == 8) $pCtlSpd = "1Gigabps-Full";
      }

      //Скорость на порту для 3028, 3028g, 3200-28
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
      {
      if ($portNwayStatus[$pi - 1] == 1) $pLnkSpd = "Linkdown";
      if ($portNwayStatus[$pi - 1] == 2) $pLnkSpd = "10Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 3) $pLnkSpd = "10Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 4) $pLnkSpd = "100Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 5) $pLnkSpd = "100Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 6) $pLnkSpd = "1Gigabps-Half";
      if ($portNwayStatus[$pi - 1] == 7) $pLnkSpd = "1Gigabps-Full";
      }

      //Скорость на порту для 3526
    if ($ModelType == 'DES-3526')
      {
      if ($portNwayStatus[$pi - 1] == 2) $pLnkSpd = "Linkdown";
      if ($portNwayStatus[$pi - 1] == 3) $pLnkSpd = "10Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 4) $pLnkSpd = "10Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 5) $pLnkSpd = "100Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 6) $pLnkSpd = "100Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 7) $pLnkSpd = "1Gigabps-Half";
      if ($portNwayStatus[$pi - 1] == 8) $pLnkSpd = "1Gigabps-Full";    
      }

      //Скорость на порту для 3026
    if ($ModelType == 'DES-3026')
      {
      if ($portNwayStatus[$pi - 1] == 1) $pLnkSpd = "Linkdown";
      if ($portNwayStatus[$pi - 1] == 5) $pLnkSpd = "10Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 3) $pLnkSpd = "10Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 9) $pLnkSpd = "100Mbps-Half";
      if ($portNwayStatus[$pi - 1] == 7) $pLnkSpd = "100Mbps-Full";
      if ($portNwayStatus[$pi - 1] == 13) $pLnkSpd = "1Gigabps-Half";
      if ($portNwayStatus[$pi - 1] == 11) $pLnkSpd = "1Gigabps-Full";    
      }

      //Отображение результатов теста кабеля
    $cP1S="unknown";
    if ($cableDiagPair1Status[$pi - 1] == 0) $cP1S = "OK";
    if ($cableDiagPair1Status[$pi - 1] == 1) $cP1S = "open";
    if ($cableDiagPair1Status[$pi - 1] == 2) $cP1S = "short";
    if ($cableDiagPair1Status[$pi - 1] == 3) $cP1S = "open-short";
    if ($cableDiagPair1Status[$pi - 1] == 4) $cP1S = "crosstalk";
    if ($cableDiagPair1Status[$pi - 1] == 5) $cP1S = "unknown";
    if ($cableDiagPair1Status[$pi - 1] == 6) $cP1S = "count";
    if ($cableDiagPair1Status[$pi - 1] == 7) $cP1S = "no-cable";
    if ($cableDiagPair1Status[$pi - 1] == 8) $cP1S = "other";

    $cP2S="unknown";
    if ($cableDiagPair2Status[$pi - 1] == 0) $cP2S = "OK";
    if ($cableDiagPair2Status[$pi - 1] == 1) $cP2S = "open";
    if ($cableDiagPair2Status[$pi - 1] == 2) $cP2S = "short";
    if ($cableDiagPair2Status[$pi - 1] == 3) $cP2S = "open-short";
    if ($cableDiagPair2Status[$pi - 1] == 4) $cP2S = "crosstalk";
    if ($cableDiagPair2Status[$pi - 1] == 5) $cP2S = "unknown";
    if ($cableDiagPair2Status[$pi - 1] == 6) $cP2S = "count";
    if ($cableDiagPair2Status[$pi - 1] == 7) $cP2S = "no-cable";
    if ($cableDiagPair2Status[$pi - 1] == 8) $cP2S = "other";

    if ($cableDiagPair1Status[$pi - 1] != 7) $cP1S = "Pair 1 " . $cP1S . " at " . $cableDiagPair1Length[$pi - 1]; else $cP1S = "";
    if ($cableDiagPair2Status[$pi - 1] != 7) $cP2S = "Pair 2 " . $cP2S . " at " . $cableDiagPair2Length[$pi - 1]; else $cP2S = "";
    if ($cP1S != "" && $cP2S != "") $cP1S .= ", ";
    $cDiagRes = $cP1S . $cP2S;
    if ($cDiagRes == "") $cDiagRes = "No Cable";

    if ($cableDiagLinkStatus[$pi - 1] == 0 && $cableDiagPair1Status[$pi - 1] == 0 && $cableDiagPair2Status[$pi - 1] == 0) $cDiagRes = "OK";
    if ($cableDiagLinkStatus[$pi - 1] == 1 && $cableDiagPair1Status[$pi - 1] == 0 && $cableDiagPair2Status[$pi - 1] == 0) $cDiagRes = "OK, Cable Length: " . $cableDiagPair1Length[$pi - 1];

    if ($ModelType == 'DGS-3100-24TG') $cDiagRes = "not supported";

    if ($pi > 24) $cDiagRes = "n/a";

      //Отображение ошибок на порту
    $pErCrc = $portCrcErrors[$pi - 1];
    $pErUnd = $portUnderSizeErrors[$pi - 1];
    $pErOvs = $portOverSizeErrors[$pi - 1];
    $pErFrg = $portFragmentErrors[$pi - 1];
    $pErJab = $portJabberErrors[$pi - 1];
    $errtmp = 0;

    if ($portCrcErrors[$pi - 1] != 0) $errtmp++;
    if ($portUnderSizeErrors[$pi - 1] != 0) $errtmp++;
    if ($portOverSizeErrors[$pi - 1] != 0) $errtmp++;
    if ($portFragmentErrors[$pi - 1] != 0) $errtmp++;
    if ($portJabberErrors[$pi - 1] != 0) $errtmp++;

    if ($errtmp == 0) $errclass = 'errgood';
    if ($errtmp == 1) $errclass = 'errpoor';
    if ($errtmp > 1) $errclass = 'errbad';
    $pErrors = $pErCrc . " / " . $pErUnd . " / " . $pErOvs . " / " . $pErFrg . " / " . $pErJab;

      //Отображение количества переданных и принятых данных
    $pRx = $portRxTotal[$pi - 1];
    $pTx = $portTxTotal[$pi - 1];

      //Преобразование в кило-, мега- и прочие байты
    if ($shortrxtx == 'true')                
      {
        //Преобразование размера принятых данных
      if ($pRx > 1099511627776) $pRx = round($pRx/1099511627776, 2) . "<font class='t'> T</font>";
      if ($pRx > 1073741824) $pRx = round($pRx/1073741824, 2) . "<font class='g'> G</font>";
      if ($pRx > 1048576) $pRx = round($pRx/1048576, 2) . "<font class='m'> M</font>";
      if ($pRx > 1024) $pRx = round($pRx/1024, 2) . "<font class='k'> K</font>";

        //Преобразование размера переданных данных
      if ($pTx > 1099511627776) $pTx = round($pTx/1099511627776, 2) . "<font class='t'> T</font>";
      if ($pTx > 1073741824) $pTx = round($pTx/1073741824, 2) . "<font class='g'> G</font>";
      if ($pTx > 1048576) $pTx = round($pTx/1048576, 2) . "<font class='m'> M</font>";
      if ($pTx > 1024) $pTx = round($pTx/1024, 2) . "<font class='k'> K</font>";
      }

    $pRxTx = 'Rx ' . $pRx . ', Tx ' . $pTx;
    $rxtxclass = 'normal';
    $pRxtmp = $portRxTotal[$pi - 1];
    $pTxtmp = $portTxTotal[$pi - 1];

    if ($pRxtmp == 0 && $pTxtmp == 0) $rxtxclass = 'nobytes';
    if (($pRxtmp == 0 && $pTxtmp != 0) || ($pRxtmp != 0 && $pTxtmp == 0)) $rxtxclass = 'onlyonedirect';

    if ($portscount[$ModelType] == 30)
      if ($pi == 26 || $pi == 28)
        {
        $pRxTx = "n/a";
        $pErrors = "n/a";
        $errclass = 'normal';
        $rxtxclass = 'normal';
        }

    if ($portscount[$ModelType] == 32)
      if ($pi == 26 || $pi == 28 || $pi == 30 || $pi == 32)
        {
        $pRxTx = "n/a";
        $pErrors = "n/a";
        $errclass = 'normal';
        $rxtxclass = 'normal';
        }

    if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';
    if ($pclass == 'podd') $pclass = 'peven'; else $pclass = 'podd';

    $ctrlspeedclass = 'normal';
    $linkspeedclass = 'normal';
    $diagclass = 'normal';

      //Задание классов для отображения скоростей на порту
    if (stripos($pCtlSpd, 'Full') !== false) $ctrlspeedclass = 'full';
    if (stripos($pCtlSpd, 'Half') !== false) $ctrlspeedclass = 'half';
    if (stripos($pCtlSpd, '10Mb') !== false) $ctrlspeedclass = 'mb10';
    if (stripos($pLnkSpd, 'Full') !== false) $linkspeedclass = 'full';
    if (stripos($pLnkSpd, 'Half') !== false) $linkspeedclass = 'half';
    if (stripos($pLnkSpd, '10Mb') !== false) $linkspeedclass = 'mb10';

      //Задание классов для отображения диагностики кабеля на порту
    if (($cP1S == "" && $cP2S != "") || ($cP1S != "" && $cP2S == "")) $diagclass = 'diagpairerr';
    if (abs($cableDiagPair1Length[$pi - 1] - $cableDiagPair2Length[$pi - 1]) > 4) $diagclass = 'diagpairerr';
    if (stripos($cDiagRes,'short') !== false || stripos($cDiagRes,'crosstalk') !== false) $diagclass = 'diagbad';
    if (stripos($cDiagRes,'Cable Length') !== false) $diagclass = 'diagok';
    if ($cDiagRes == "No Cable") $diagclass = 'diagnocable';

      //Отображать или нет управление обычными портами
    if ($pi < 25)
      if ($enableportscontrol != 'true') $pctrl = "n/a";
        else 
        {
        $pctrl = "<a class='up' href='#' onclick='return PortControl(\"$kport\",\"up\")'>Up</a>/";
        $pctrl .= "<a class='down' href='#' onclick='return PortControl(\"$kport\",\"down\")'>Down</a>/";
        $pctrl .= "<a class='mb10' href='#' onclick='return PortControl(\"$kport\",\"mb10\")'>10M</a>/";
        $pctrl .= "<a class='mb100' href='#' onclick='return PortControl(\"$kport\",\"mb100\")'>100M</a>/";
        $pctrl .= "<a class='auto' href='#' onclick='return PortControl(\"$kport\",\"auto\")'>Auto</a>";
        }

      //Отображать или нет управление магистральными портами
    if ($pi > 24)
      if ($enabledatawayportscontrol != 'true') $pctrl = "n/a";
        else 
        {
        $pctrl = "<a class='up' href='#' onclick='return PortControl(\"$kport\",\"up\")'>Up</a>/";
        $pctrl .= "<a class='down' href='#' onclick='return PortControl(\"$kport\",\"down\")'>Down</a>/";
        $pctrl .= "<a class='mb10' href='#' onclick='return PortControl(\"$kport\",\"mb10\")'>10M</a>/";
        $pctrl .= "<a class='mb100' href='#' onclick='return PortControl(\"$kport\",\"mb100\")'>100M</a>/";
        $pctrl .= "<a class='auto' href='#' onclick='return PortControl(\"$kport\",\"auto\")'>Auto</a>";
        }

      //Вывод таблицы с информацией о портах
    $swtable .= "\n\t</tr>\n\t<tr class=$rowclass>\n\t\t<td class=$pclass>".$kport."</td>\n\t\t";
    $swtable .= "<td>".$pDesc."</td>\n\t\t<td>".$untag_vlan[$pi - 1]."</td>\n\t\t";
    $swtable .= "<td>".$pAdmSt."/".$pLnkSt."</td>\n\t\t<td class=$ctrlspeedclass>".$pCtlSpd."</td>\n\t\t";
    $swtable .= "<td class=$linkspeedclass>".$pLnkSpd."</td>\n\t\t<td class=$diagclass>".$cDiagRes."</td>\n\t\t";
    $swtable .= "<td class=$errclass>".$pErrors."</td>\n\t\t<td class=$rxtxclass>".$pRxTx."</td>\n\t\t<td style='text-align:center;'>".$pctrl."</td>";

  }
  $swtable .= "\n\t</tr>\n</table>\n";
  $swtable .= "<div style='padding-left:2;border:0px;font:7pt Verdana;font-weight:normal;'>";
  $swtable .= "<u>Журнал действий:</u><div id='log'></div>\n";
  $modulever = "0.14";
        // --- Конец модуля: 'Информация о портах' ---
?>