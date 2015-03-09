<?php
        // --- Начало модуля: 'Описания портов' ---
  if (isset($_REQUEST['doit'])) $doit = $_REQUEST['doit']; else $doit = "";

  $portval = array();
  $portactres = array();
  $saveres = '';

  if ($doit != '')
    {
      //Собственно подписывание портов
      for ($m = 1; $m < $portscount[$ModelType] + 1; $m++)
        {
        $pdport = $m;
        $actres = 0;
        if (strlen($pdport) == 1) $pdport = "0" . $pdport;
        if (isset($_REQUEST['pd' . $pdport])) ${'pd' . $pdport}=$_REQUEST['pd' . $pdport]; else ${'pd' . $pdport}="";
        $pdportval[$m] = ${'pd' . $pdport};
        $actres = @snmpset($ip, $wcomm, ".1.3.6.1.2.1.31.1.1.1.18." . $m, "s", $pdportval[$m], $timeout, $retries);
        if ($actres == 1) $portactres[$pdport] = 'OK'; else $portactres[$pdport] = 'Fail';
        }

      // Для 3028 подписываем дополнительно порты 25(F) и 26(F)
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028P') 
      for ($mm = 25; $mm < 27; $mm++)
        {
        $pdport = $mm . '(F)';
        $actres = 0;
        if (isset($_REQUEST['pd' . $pdport])) ${'pd' . $pdport} = $_REQUEST['pd' . $pdport]; else ${'pd' . $pdport} = "";
        $pdportval[$mm] = strtohex(${'pd' . $pdport});
        $actres = @snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.6." . $mm . ".101", "x", $pdportval[$mm], $timeout, $retries);
        if ($actres == 1) $portactres[$pdport] = 'OK'; else $portactres[$pdport] = 'Fail';
        }

      // Для 3028G/3200-28 подписываем дополнительно порты 25(F), 26(F), 27(F) и 28(F)
    if ($ModelType == 'DES-3028G' || $ModelType == 'DES-3200-28') 
      for ($mm = 25; $mm < 29; $mm++)
        {
        $pdport = $mm . '(F)';
        $actres = 0;
        if (isset($_REQUEST['pd' . $pdport])) ${'pd' . $pdport} = $_REQUEST['pd' . $pdport]; else ${'pd' . $pdport} = "";
        $pdportval[$mm] = strtohex(${'pd' . $pdport});
        $actres = @snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.11." . $p_oid[$ModelType] . ".2.2.2.1.6." . $mm . ".101", "x", $pdportval[$mm], $timeout, $retries);
        if ($actres == 1) $portactres[$pdport] = 'OK'; else $portactres[$pdport] = 'Fail';
        }

      // Сохранение результатов подписи портов для DES-3028, 3028, 3026, 3200-28
    if ($ModelType == 'DES-3028' || $ModelType == 'DES-3028G' || $ModelType == 'DES-3026' || $ModelType == 'DES-3028P' || $ModelType == 'DES-3200-28') 
      if (@snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.1.2.6.0", "i", "5", $timeout * 100, 0) != false) $saveres = "<font color=#00ff00>Конфигурация успешно сохранена!</font>";
        else $saveres = "<font color=#ff0000>Ошибка сохранения конфигурации!</font>";

      // Сохранение результатов подписи портов для DES-3526
    if ($ModelType == 'DES-3526')
      {
      @snmpset($ip, $wcomm, ".1.3.6.1.4.1.171.12.1.2.6.0", "i", "3", $timeout, 0);
      $saveres = "<font color=#0000ff>Запрос на сохранении конфигурации отправлен!</font>";
      }

      // Сообщение в случае использования DGS-3100-24TG
    if ($ModelType == 'DGS-3100-24TG')
      {
      $saveres = "<font color=#0000ff>Сохранение конфигурации для DGS-3100-24TG данным модулем не поддерживается!</font>";
      }
    }
    // Создаем шапку FDB таблицы
  $swtable = "\n<form method='post'>";
  $swtable .= "\n<table border=1 width='100%'>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead' colspan=3>Таблица описаний портов<br>";
      // Отображать или нет кнопку 'Подписать'
  $savestr = '';
  if ($enablesavecontrol == 'true') $savestr = "<input type='submit' name='doit' value='Подписать' class='pdesc'>";
  $swtable .= $savestr."</td>\n\t</tr>";
  $swtable .= "\n\t<tr class='head'>\n\t\t<td class='tablehead'>№</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Описание порта для правки</td>\n\t\t";
  $swtable .= "<td class='tablehead'>Описание порта для сравнения</td>";

  if ($ModelType == 'DES-3526') $nocomboports = 2; else $nocomboports = 0;

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
    }

  if ($ModelType == 'DES-3526' || $ModelType == 'DES-3026' || $ModelType == 'DGS-3100-24TG') 
    {
      // Описание портов
    $portDescription = @snmpwalk($ip, $rcomm, ".1.3.6.1.2.1.31.1.1.1.18", $timeout, $retries);
    }
    
  for ($pi = 1; $pi < $portscount[$ModelType] + 1 - $nocomboports; $pi++)
    {
    $kport = $pi;
    if (strlen($kport) == 1) $kport = "0" . $kport;
    if ($portscount[$ModelType] == 30)
      {
      if ($kport == 26) $kport = "25(F)";
      if ($kport == 27) $kport = "26";
      if ($kport == 28) $kport = "26(F)";
      if ($kport == 29) $kport = "27";
      if ($kport == 30) $kport = "28";
      }

    if ($portscount[$ModelType] == 32)
      {
      if ($kport == 26) $kport = "25(F)";
      if ($kport == 27) $kport = "26";
      if ($kport == 28) $kport = "26(F)";
      if ($kport == 29) $kport = "27";
      if ($kport == 30) $kport = "27(F)";
      if ($kport == 31) $kport = "28";
      if ($kport == 32) $kport = "28(F)";
      }

    if ($rowclass == 'odd') $rowclass = 'even'; else $rowclass = 'odd';
    if ($pclass == 'podd') $pclass = 'peven'; else $pclass = 'podd';

    $pDesc = str_ireplace('"', '', $portDescription[$pi - 1]);
    $pDesc = htmlspecialchars($pDesc);
    $pdstat = '';
    $pfx = '';
    $sfx = '';

    if ($portactres[$kport] == 'OK') 
      {
      $pfx = "<font color=#00ff00>";
      $sfx = "</font>";
      }

    if ($portactres[$kport] == 'Fail') 
      {
      $pfx = "<font color=#ff0000>";
      $sfx = "</font>";
      }

    $swtable .= "\n\t</tr>\n\t<tr class=$rowclass>\n\t\t<td class=$pclass width='30' ";
    $swtable .= "style='vertical-align: middle;'>" . $pfx . $kport . $sfx . "</td>\n\t\t";
    $swtable .= "<td width='230'><input height=5 maxlength='32' size='34' ";
    $swtable .= "type='text' {$pdstat} name='pd" . $kport . "' value='" . $pDesc . "' class='pdesc'></td>\n\t\t";
    $swtable .= "<td style='padding-left:10px;vertical-align: middle;'>" . $pDesc . "</td>";
    }

  $swtable .= "\n\t</tr>\n</table>\n";
  $swtable .= "</form>";

  if ($saveres != '') $swtable .= "\n<div class='bottom'>\n" . $saveres . "\n</div>\n";

  $modulever = "0.11";
        // --- Конец модуля: 'Описания портов' ---
?>