<?php
  // Описание модели
  $sysDescr = @snmpget($ip, $rcomm, ".1.3.6.1.2.1.1.1.0");
    
  // Определяем тип модели
  if (stripos($sysDescr, 'DES-1228ME')    !== false) $ModelType = 'DES-1228ME';
  if (stripos($sysDescr, 'DES-3026')      !== false) $ModelType = 'DES-3026';
  if (stripos($sysDescr, 'DES-3028')      !== false) $ModelType = 'DES-3028';
  if (stripos($sysDescr, 'DES-3028G')     !== false) $ModelType = 'DES-3028G';
  if (stripos($sysDescr, 'DES-3028P')     !== false) $ModelType = 'DES-3028P';
  if (stripos($sysDescr, 'DES-3200-28')   !== false) $ModelType = 'DES-3200-28';
  if (stripos($sysDescr, 'DES-3526')      !== false) $ModelType = 'DES-3526';
  if (stripos($sysDescr, 'DGS-3100-24TG') !== false) $ModelType = 'DGS-3100-24TG';
?>