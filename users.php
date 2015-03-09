<?php
      // --- Учетные записи пользователей ---
      // Для каждого пользователя задается пароль и три вида пользовательских прав:
      // passwords - пароль пользователя в открытом виде или его md5-hash
      // portsrights - управление портами с 1 по 24
      // datawayportsrights - управление магистральными портами, номера которых превышают 24
      // savecontrolrights - управлением сохранением настроек
      // Логин и пароль по умолчанию - guest/guest . Права доступа минимальные
    //user #1 - guest
  $passwords['guest']='084e0343a0486ff05530df6c705c8bb4';
  $portsrights['guest']='false';
  $datawayportsrights['guest']='false';
  $savecontrolrights['guest']='false';
?>