<?php
        // --- Начало модуля: 'Таблица коммутации' ---
    
    // Таблица коммутации для всех vlan
  $dot1dTpFdbAddress = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.2.2.1.2", $timeout, $retries);
    // Статус записей
  $dot1dTpFdbStatus = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.2.2.1.3", $timeout, $retries);
    // Список названий vlan
  $dot1qTpVlanStaticName = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.1", $timeout, $retries);
  asort($dot1dTpFdbAddress);
    
    // Оставляем в ключе массива только нужную информацию
  $dot1dTpFdbAddress = keyscutvlanmac($dot1dTpFdbAddress);
    // Оставляем в ключе массива только нужную информацию
  $dot1dTpFdbStatus = keyscutvlanmac($dot1dTpFdbStatus);
    // Оставляем в ключе массива только нужную информацию
  $dot1qTpVlanStaticName = keyscut($dot1qTpVlanStaticName);
    
    // Создаем шапку FDB таблицы
  $swtable = "\n<table border=1 width='100%'>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead' colspan=5>Таблица коммутации</td>\n\t</tr>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>VID</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Название vlan</td>\n\t\t<td class='tablehead'>MAC-адрес</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Порт</td>\n\t\t<td class='tablehead'>Тип</td>";

    //Выводим таблицу FDB
  reset($dot1dTpFdbAddress);
  for ($q = 0; $q < count($dot1dTpFdbAddress); $q++)
    {
    $stat_key = key($dot1dTpFdbAddress);
    $entry_stat = "unknown";

    if ($dot1dTpFdbStatus[$stat_key] == 1) $entry_stat = "Other/Unknown (Возможно, заблокирован IMP)";
    if ($dot1dTpFdbStatus[$stat_key] == 2) $entry_stat = "Invalid";
    if ($dot1dTpFdbStatus[$stat_key] == 3) $entry_stat = "Dynamic";
    if ($dot1dTpFdbStatus[$stat_key] == 4) $entry_stat = "Self";
    if ($dot1dTpFdbStatus[$stat_key] == 5) $entry_stat = "Static";

    if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';

    $vlan_mac = key($dot1dTpFdbAddress);
    $vlan_mac_arr = explode('.', $vlan_mac);
    $mac = "";

    for ($m = 1; $m < 7; $m++)
      {
      $mactmp = dechex($vlan_mac_arr[$m]);
      if (strlen($mactmp) == 1) $mactmp = "0" . $mactmp;
      $mac .= $mactmp;
      if ($m < 6) $mac .= ":";
      }

    $vid = $vlan_mac_arr[0];
    $vlan_name = $dot1qTpVlanStaticName[$vid];
    $port = $dot1dTpFdbAddress[key($dot1dTpFdbAddress)];
    $vlan_name = str_ireplace('"', "", $vlan_name);

    if ($port < 25)
      {
      $swtable .= "\n\t</tr>\n\t<tr class=$rowclass>\n\t\t<td class=$pclass>" . $vid . "</td>\n\t\t";
      $swtable .= "<td>" . $vlan_name . "</td>\n\t\t<td>" . $mac . "</td>\n\t\t<td>" . $port . "</td>\n\t\t<td>" . $entry_stat . "</td>";
      }

    next($dot1dTpFdbAddress);
    }
  $swtable .= "\n\t</tr>\n</table>\n";
  $modulever = "0.04";
        // --- Конец модуля: 'Таблица коммутации' ---
?>