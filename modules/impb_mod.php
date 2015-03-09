<?php
        // <--- Начало модуля: 'Таблица записей IMP' ---
  if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28')
    {
      // список IP в таблице IMP
    $swIMBip = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.1", $timeout, $retries); 
      // список MAC в таблице IMP
    $swIMBmac = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.2", $timeout, $retries);
      // список статусов в таблице IMP
    $swIMBstatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.3", $timeout, $retries); 
      // список портов в таблице IMP
    $swIMBports = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.4", $timeout, $retries); 
      // список состояний в таблице IMP
    if ($ModelType != 'DES-3200-28') $swIMBaction = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.5", $timeout, $retries); 
      // список режимов в таблице IMP
    $swIMBmode = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.1.1.6", $timeout, $retries); 
      // список VID где есть заблокированные MAC
    $swIMBblockedVID = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.2.1.1", $timeout, $retries); 
      // список заблокированных MAC
    $swIMBblockedMAC = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.2.1.2", $timeout, $retries); 
      // список VLAN где есть заблокированные MAC
    $swIMBblockedVlanName = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.2.1.3", $timeout, $retries); 
      // список портов где есть заблокированные MAC
    $swIMBblockedPort = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.2.1.4", $timeout, $retries); 
      // тип блокировок
    $swIMBblockedType = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.12.23.4.2.1.5", $timeout, $retries); 
    }

  if ($ModelType == 'DES-3526')
    {
      // список IP в таблице IMP
    $swIMBip = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.1", $timeout, $retries); 
      // список MAC в таблице IMP
    $swIMBmac = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.2", $timeout, $retries); 
      // список статусов в таблице IMP
    $swIMBstatus = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.3", $timeout, $retries); 
      // список портов в таблице IMP
    $swIMBports = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.4", $timeout, $retries); 
      // список состояний в таблице IMP
    $swIMBaction = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.5", $timeout, $retries); 
      // список режимов в таблице IMP
    $swIMBmode = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.2.1.6", $timeout, $retries); 
      // список VID где есть заблокированные MAC
    $swIMBblockedVID = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.3.1.1", $timeout, $retries); 
      // список заблокированных MAC
    $swIMBblockedMAC = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.3.1.2", $timeout, $retries); 
      // список VLAN где есть заблокированные MAC
    $swIMBblockedVlanName = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.3.1.3", $timeout, $retries); 
      // список портов где есть заблокированные MAC
    $swIMBblockedPort = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.3.1.4", $timeout, $retries); 
      // тип блокировок
    $swIMBblockedType = @snmpwalk($ip, $rcomm, ".1.3.6.1.4.1.171.11.64.1.2.7.3.1.5", $timeout, $retries); 
    }

  $swtable = "\n<table border=1 width='100%'>";

  if (count($swIMBblockedMAC) > 0)
    {
    $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead' colspan=6>";
    $swtable .= "<font color=#ff0000>Список заблокированных MAC-адресов</font></td>\n\t</tr>";
    $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>№</td>\n\t\t";
    $swtable .= "<td class='tablehead'>VID</td>\n\t\t<td class='tablehead'>VLAN Name</td>\n\t\t";
    $swtable .= "<td class='tablehead'>MAC</td>\n\t\t<td class='tablehead'>Порт</td>\n\t\t<td class='tablehead'>Тип</td>";

    for ($e = 0; $e < count($swIMBblockedMAC); $e++)
      {
      $kport = $e + 1;
      if (strlen($kport) == 1) $kport = "0" . $kport;

      $bvlan = str_ireplace('"', '', $swIMBblockedVlanName[$e]);
      $bmac_addr = str_ireplace('Hex: ', '', $swIMBblockedMAC[$e]);
      $bmac_addr = str_ireplace('"', '', $bmac_addr);
      $bmac_addr = trim($bmac_addr);
      $bmac_addr = str_ireplace(' ', ':', $bmac_addr);
      $btype = "unknown";

      if ($swIMBblockedType[$e] == 1) $btype = "other";
      if ($swIMBblockedType[$e] == 2) $btype = "blockByAddrBind";
      if ($swIMBblockedType[$e] == 3) $btype = "delete";

      if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';

      $swtable .= "\n\t</tr>\n\t<tr class=$rowclass>\n\t\t";
      $swtable .= "<td><font color=#ff0000>" . $kport . "</font></td>\n\t\t";
      $swtable .= "<td>" . $swIMBblockedVID[$e] . "</td>\n\t\t";
      $swtable .= "<td>" . $bvlan . "</td>\n\t\t<td>" . $bmac_addr . "</td>\n\t\t";
      $swtable .= "<td style='text-align:center;'>" . $swIMBblockedPort[$e] . "</td>\n\t\t<td>" . $btype . "</td>";
      }
    $swtable.="\n\t</tr>";
    }

  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead' colspan=6>";
  $swtable .= "Список записей в таблице IP-MAC-Port-Binding</td>\n\t</tr>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>№</td>\n\t\t";
  $swtable .= "<td class='tablehead'>IP</td>\n\t\t<td class='tablehead'>MAC</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Режим</td>\n\t\t<td class='tablehead'>Порты</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Статус</td>";
    
  for ($q = 0; $q < count($swIMBip); $q++)
    {
    $kport = $q + 1;
    if (strlen($kport) == 1) $kport = "0" . $kport;

    $ip_addr = str_ireplace('IpAddress:', '', $swIMBip[$q]);
    $mac_addr = str_ireplace('"', '', $swIMBmac[$q]);
    $mac_addr = trim($mac_addr);
    $mac_addr = str_ireplace(' ', ':', $mac_addr);
    $imb_mode = "unknown";

    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P')
      {
      if ($swIMBmode[$q] == 1) $imb_mode = "arp";
      if ($swIMBmode[$q] == 2) $imb_mode = "acl";
      if ($swIMBmode[$q] == 3) $imb_mode = "auto";
      }

    if ($ModelType == 'DES-3200-28')
      {
      if ($swIMBmode[$q] == 1) $imb_mode = "arp";
      if ($swIMBmode[$q] == 2) $imb_mode = "acl";
      if ($swIMBmode[$q] == 3) $imb_mode = "dhcp-snooping";
      if ($swIMBmode[$q] == 4) $imb_mode = "static";
      }
  
    if ($ModelType == 'DES-3526')
      {
      if ($swIMBmode[$q] == 0) $imb_mode = "any";
      if ($swIMBmode[$q] == 1) $imb_mode = "acl";
      if ($swIMBmode[$q] == 2) $imb_mode = "ipbind";
      if ($swIMBmode[$q] == 4) $imb_mode = "other";
      }

    $imb_action = "unknown";
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3028P')
      {
      if ($swIMBaction[$q] == 1) $imb_action = "inactive";
      if ($swIMBaction[$q] == 2) $imb_action = "active";
      }

    if ($ModelType == 'DES-3200-28')
     {
     $imb_action="n/a";
     }

    if ($ModelType == 'DES-3526')
      {
      if ($swIMBaction[$q] == 1) $imb_action = "active";
      if ($swIMBaction[$q] == 2) $imb_action = "notInService";
      if ($swIMBaction[$q] == 3) $imb_action = "notReady";
      if ($swIMBaction[$q] == 4) $imb_action = "createAndGo";
      if ($swIMBaction[$q] == 5) $imb_action = "createAndWait";
      if ($swIMBaction[$q] == 6) $imb_action = "destroy";
      }

    if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';
    if ($pclass == 'podd') $pclass = 'peven'; else $pclass = 'podd';

    $imb_port = str_ireplace('Hex: ', '', $swIMBports[$q]);
    $imb_port = str_ireplace('00 00 00 00', '', $imb_port);
    $imb_port = str_ireplace(' ', '', $imb_port);
    $imb_port = decbin(hexdec($imb_port));

    while (strlen($imb_port) < 32) $imb_port = "0" . $imb_port;

    $imb_ports = "";

    for ($w = 0; $w < strlen($imb_port); $w++)
    if ($imb_port[$w] == "1")
      {
      $imb_ports .= ( $w + 1 );
      if ($w < strripos($imb_port, '1')) $imb_ports .= ", ";
      }

    $swtable .= "\n\t</tr>\n\t<tr class=$rowclass>\n\t\t";
    $swtable .= "<td class=$pclass>" . $kport . "</td>\n\t\t<td>" . $ip_addr . "</td>\n\t\t";
    $swtable .= "<td>" . $mac_addr . "</td>\n\t\t<td>" . $imb_mode . "</td>\n\t\t";
    $swtable .= "<td>" . $imb_ports . "</td>\n\t\t<td>" . $imb_action . "</td>";
    }

  $swtable .= "\n\t</tr>\n</table>\n";

    // Если модель коммутатора DGS-3100-24TG выводим сообщение, что данный функционал не поддерживается
  if ($ModelType == 'DGS-3100-24TG')
    {
    $swtable = "\n<table border=1 width='100%'>";
    $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>";
    $swtable .= "\n\t\t<font color=#ff0000>Данный функционал моделью DGS-3100-24TG не поддерживается!</font>";
    $swtable .= "\n\t\t</td>\n\t</tr>\n</table>\n";    
    }

  $modulever = "0.09";
        // --- Конец модуля: 'Таблица записей IMP' --->
?>