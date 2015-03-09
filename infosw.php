<?php
        //Блок описания коммутатора для 3028 и ему подобных
  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
    {
      // Версия прошивки
    $sysFirmvare = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.16.19.2.0", $timeout, $retries);
      // MAC - адрес устройства   
    $sysMACaddr = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.15.2.1.0", $timeout, $retries);
      // STP Root Port
    $sysRootPort = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.15.2.3.1.18.0", $timeout, $retries);
      // Приоритет STP
    $swMSTPInstPriority = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.15.2.3.1.12.0", $timeout, $retries);
      // Время работы устройства
    $sysUptime = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.3.0", $timeout, $retries);
      // Серийный номер
    $sysSerial = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.1.12.0", $timeout, $retries);
      // Контакты
    $sysContact = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.4.0", $timeout, $retries);
      // Имя
    $sysName = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.5.0", $timeout, $retries);
      // Расположение
    $sysLocation = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.6.0", $timeout, $retries);
      // Версия прошивки 1
    $swImage1Version = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.2.1", $timeout, $retries);
      // Версия прошивки 2
    $swImage2Version = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.2.2", $timeout, $retries);
      // Время обновления прошивки 1
    $swImage1UpdateTime = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.4.1", $timeout, $retries);
      // Время обновления прошивки 2
    $swImage2UpdateTime = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.4.2", $timeout, $retries);
      // Способ подключения при обновлении прошивки 1
    $swImage1From = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.5.1", $timeout, $retries);
      // Способ подключения при обновлении прошивки 2
    $swImage2From = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.5.2", $timeout, $retries);
      // Пользователь, обновивший прошивку 1
    $swImage1SendUser = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.6.1", $timeout, $retries);
      // Пользователь, обновивший прошивку 2
    $swImage2SendUser = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.6.2", $timeout, $retries);

    $swImage1UpdateTime = str_ireplace('"', '', $swImage1UpdateTime);
    $swImage2UpdateTime=str_ireplace('"', '', $swImage2UpdateTime);
    }

  if ($ModelType == 'DGS-3100-24TG')
    {
      // Версия прошивки
    $sysFirmvare_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.53.14.1.2.1", $timeout, $retries);
    $sysBoot_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.53.14.1.3.1", $timeout, $retries);
    $sysFirmvare=$sysFirmvare_only.' ('.$sysBoot_only.')';

      // MAC - адрес устройства   
    $sysMACaddr = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.12.0", $timeout, $retries);
    $sysMACaddr = str_ireplace(chr(34), '', $sysMACaddr);
    $sysMACaddr = trim($sysMACaddr);
    $sysMACaddr = str_replace(' ', ':', $sysMACaddr);

      // STP Root Port
    $sysRootPort = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.15.2.3.1.18.0", $timeout, $retries);
      // Приоритет STP
    $swMSTPInstPriority = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.15.2.3.1.12.0", $timeout, $retries);

      // Время работы устройства
    $sysUptime = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.3.0", $timeout, $retries);
      // Серийный номер
    $sysSerial = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.53.14.1.5.1", $timeout, $retries);
      // Контакты
    $sysContact = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.4.0", $timeout, $retries);
      // Имя
    $sysName = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.5.0", $timeout, $retries);
      // Расположение
    $sysLocation = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.6.0", $timeout, $retries);
      // Версия прошивки 1
    $swImage1Version = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.4.1", $timeout, $retries);
      // Версия прошивки 2
    $swImage2Version = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.5.1", $timeout, $retries);
      // Номер загруженной прошивки
    $rndActiveSoftwareFileTable = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.13.1.1.2.1", $timeout, $retries);
    if ($rndActiveSoftwareFileTable==1) $swImage1Version='*'.$swImage1Version;
    if ($rndActiveSoftwareFileTable==2) $swImage2Version='*'.$swImage2Version;

      // Время обновления прошивки 1
    $swImage1UpdateDate_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.6.1", $timeout, $retries);
    $swImage1UpdateDate_only = str_ireplace(chr(34), '', $swImage1UpdateDate_only);
    $swImage1UpdateDate_only = trim($swImage1UpdateDate_only);
    $swImage1UpdateTime_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.8.1", $timeout, $retries);
    $swImage1UpdateTime_only = str_ireplace(chr(34), '', $swImage1UpdateTime_only);
    $swImage1UpdateTime_only = trim($swImage1UpdateTime_only);
    $swImage1UpdateTime=$swImage1UpdateDate_only.' '.$swImage1UpdateTime_only;

      // Время обновления прошивки 2
    $swImage2UpdateDate_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.7.1", $timeout, $retries);
    $swImage2UpdateDate_only = str_ireplace(chr(34), '', $swImage2UpdateDate_only);
    $swImage2UpdateDate_only = trim($swImage2UpdateDate_only);
    $swImage2UpdateTime_only = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.10.94.89.89.2.16.1.1.9.1", $timeout, $retries);
    $swImage2UpdateTime_only = str_ireplace(chr(34), '', $swImage2UpdateTime_only);
    $swImage2UpdateTime_only = trim($swImage2UpdateTime_only);
    $swImage2UpdateTime=$swImage2UpdateDate_only.' '.$swImage2UpdateTime_only;

      // Пользователь, обновивший прошивку 1
    $swImage1SendUser = '';
      // Пользователь, обновивший прошивку 2
    $swImage2SendUser = '';
    }

        //Блок описания коммутатора для 3026
  if ($ModelType == 'DES-3026')
    {
      //Root Port для 3026 (может и не найтись)
    $swRootPort = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.16.4.1.4", $timeout, $retries); 
      //Собственно поиск Root порта  
    for ($pi = 0; $pi < $portscount[$ModelType]; $pi++)
      {
      if ($swRootPort[$pi] == 4) $sysRootPort = $pi + 1;
      }
    if ($sysRootPort == "") $sysRootPort = "None";

      //Определение MAC-адреса устройства
    $swIfIndex = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.4.20.1.2." . $ip, $timeout, $retries);
    $sysMACaddr = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.4.22.1.2." . $swIfIndex . "." . $ip, $timeout, $retries);
    $sysMACaddr = str_ireplace(chr(34), '', $sysMACaddr);
    $sysMACaddr = trim($sysMACaddr);
    $sysMACaddr = str_replace(' ', ':', $sysMACaddr);

      // Время работы устройства
    $sysUptime = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.3.0", $timeout, $retries);
      // Контакты
    $sysContact = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.4.0", $timeout, $retries);
      // Имя
    $sysName = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.5.0", $timeout, $retries);
      // Расположение
    $sysLocation = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.6.0", $timeout, $retries);
      // Версия прошивки (нету поддержки Dual Image, поэтому только одна)
    $swImage1Version = @snmpget($ip, $rcomm, ".1.3.6.1.4.1.171.12.1.2.7.1.2.0", $timeout, $retries);
      // Версия прошивки 2
    $swImage2Version = "None";
      // Пользователь, обновивший прошивку 1
    $swImage1SendUser = "Unknown";
      // Пользователь, обновивший прошивку 2
    $swImage2SendUser = "Nobody";
    }

    //Приведение времени обновления прошивки к нормальному виду для моделей 3028 и 3028G и 3200-28
  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
    {
    $swImage1UpdateTime = str_ireplace(' ', '', $swImage1UpdateTime);
    $swImage1UpdateTime = str_ireplace(chr(10), '', $swImage1UpdateTime);
    $swImage1UpdateTime = str_ireplace(chr(13), '', $swImage1UpdateTime);
    $swImage1UpdateTime = hextostr($swImage1UpdateTime);
    $swImage2UpdateTime = str_ireplace(' ', '', $swImage2UpdateTime);
    $swImage2UpdateTime = str_ireplace(chr(10), '', $swImage2UpdateTime);
    $swImage2UpdateTime = str_ireplace(chr(13), '', $swImage2UpdateTime);
    $swImage2UpdateTime = hextostr($swImage2UpdateTime);
    }

    // Это чит для прошивок вроде 2.10B02, которые произвольно выдают версию то в string то в hex формате.
  if (stripos($sysFirmvare, '.') == false)  
    {
    $sysFirmvare = str_ireplace('"', '', $sysFirmvare);
    $sysFirmvare = str_ireplace(' ', '', $sysFirmvare);
    $sysFirmvare = str_ireplace(chr(10), '', $sysFirmvare);
    $sysFirmvare = str_ireplace(chr(13), '', $sysFirmvare);
    $sysFirmvare = hextostr($sysFirmvare);
    }

    //Подготовка информации о прошивке к выводу на экран
    $swImage1Version = str_ireplace('"', '', $swImage1Version);
    $swImage2Version = str_ireplace('"', '', $swImage2Version);
    $swImage1SendUser = str_ireplace('"', '', $swImage1SendUser);
    $swImage2SendUser = str_ireplace('"', '', $swImage2SendUser);

    //Для моделей 3028 и ей подобных
  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28' || $ModelType == 'DGS-3100-24TG')
    {
    if ($swImage1Version != "") $swFirm1Info = str_ireplace('"', '', $swImage1Version) . " (" . $swImage1UpdateTime . ")"; else $swFirm1Info = "not installed";  
    if ($swImage2Version != "") $swFirm2Info = str_ireplace('"', '', $swImage2Version) . " (" . $swImage2UpdateTime . ")"; else $swFirm2Info = "not installed";
    if ($swImage1SendUser != "" && $swImage1Version != "") $swUser1Info = str_ireplace('"', '', $swImage1SendUser) . " через " . str_ireplace('"', '', $swImage1From); else $swUser1Info="n/a";
    if ($swImage2SendUser != "" && $swImage2Version != "") $swUser2Info = str_ireplace('"', '', $swImage2SendUser) . " через " . str_ireplace('"', '', $swImage2From); else $swUser2Info = "n/a";
    }
  
    //Для моделей 3026
  if ($ModelType == 'DES-3026')
    {
    if ($swImage1Version != "") $swFirm1Info = str_ireplace('"', '', $swImage1Version); else $swFirm1Info = "";
    if ($swImage2Version != "") $swFirm2Info = $swImage2Version; else $swFirm2Info = "";
    if ($swImage1SendUser != "" && $swImage1Version != "") $swUser1Info = $swImage1SendUser; else $swUser1Info = "";
    if ($swImage2SendUser != "" && $swImage2Version != "") $swUser2Info = $swImage2SendUser; else $swUser2Info = "";
    $sysFirmvare=$swFirm1Info;
    }
?>
