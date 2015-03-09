<?php
        //<--Начало модуля:'Информация о vlan'--
    // Список названий vlan
  $dot1qTpVlanStaticName = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.1");
    // Список отмеченных портов в вланах
  $dot1qVlanStaticEgressPorts = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.2");
    // Список запрещенных портов в вланах
  $dot1qVlanForbiddenEgressPorts = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.3");
    // Список нетегированных портов в вланах
  $dot1qVlanStaticUntaggedPorts = @snmpwalkoid($ip, $rcomm, ".1.3.6.1.2.1.17.7.1.4.3.1.4");

    // Оставляем в ключе массива только нужную информацию
  $dot1qTpVlanStaticName = keyscut($dot1qTpVlanStaticName);
  $dot1qVlanStaticEgressPorts = keyscut($dot1qVlanStaticEgressPorts);
  $dot1qVlanForbiddenEgressPorts = keyscut($dot1qVlanForbiddenEgressPorts);
  $dot1qVlanStaticUntaggedPorts = keyscut($dot1qVlanStaticUntaggedPorts);

  $colspanvalue = $uniqueportscount[$ModelType] + 1;

    // Создаем шапку таблицы с информацией о vlan    
  $swtable = "\n<table border=1 width='100%'>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead' colspan=$colspanvalue>Таблица vlan</td>\n\t</tr>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>Vlan Name</td>";

  for ($t = 1; $t < $colspanvalue; $t++)
    {
    if (strlen($t) == 1) $vport = "0".$t; else $vport = $t;
    $swtable .= "\n\t\t<td class='tablehead'>" . $vport . "</td>";
    }

  $swtable .= "\n\t</tr>";

    //Выводим таблицу с информацией о вланах
  reset($dot1qTpVlanStaticName);
  for ($q = 0; $q < count($dot1qTpVlanStaticName); $q++)
    {     
    if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';
    $vlan_name = $dot1qTpVlanStaticName[key($dot1qTpVlanStaticName)];
    $vlan_name = str_ireplace('"', "", $vlan_name);
    $vid = key($dot1qTpVlanStaticName);
    
    $eports = $dot1qVlanStaticEgressPorts[$vid];
    $eports = stripstr($eports);
      // Чит для 3526, когда вместо hex - строки возвращается string        
    if (strlen($eports) == 4) $eports = strtohex($eports);
    $eports = decbin(hexdec($eports));       
    while (strlen($eports) < 32) $eports = "0" . $eports;

    $fports = $dot1qVlanForbiddenEgressPorts[$vid];
    $fports = stripstr($fports);
      // Чит для 3526, когда вместо hex - строки возвращается string        
    if (strlen($fports) == 4) $fports = strtohex($fports);
    $fports = decbin(hexdec($fports));
    while (strlen($fports) < 32) $fports = "0" . $fports;

    $uports = $dot1qVlanStaticUntaggedPorts[$vid];
    $uports = stripstr($uports);
      // Чит для 3526, когда вместо hex - строки возвращается string        
    if (strlen($uports) == 4) $uports = strtohex($uports);
    $uports = decbin(hexdec($uports));
    while (strlen($uports) < 32) $uports = "0".$uports;

    $swtable .= "\n\t<tr class=$rowclass>\n\t\t<td>" . $vlan_name . "</td>";
    for ($t = 1; $t < $colspanvalue; $t++)
      {
      $vi = "-";
      if ($eports[$t-1] == 1) $vi = "T";
      if ($fports[$t-1] == 1) $vi = "F";
      if ($uports[$t-1] == 1) $vi = "U";
      $swtable .= "\n\t\t<td style='text-align:center;'>" . $vi . "</td>";
      }
    $swtable .= "\n\t</tr>";
    next($dot1qTpVlanStaticName);
    }

  $swtable .= "\n</table>\n";
  $modulever = "0.09";
        // --- Конец модуля: 'Информация о vlan' --->
?>