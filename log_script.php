<?php
  echo "<script type='text/javascript' src='./_jquery.js'></script>";
  echo "<script type='text/javascript'>";
  echo "function PortControl(aport, action)";
  echo "{";
  echo "    var ip = '$ip';";
  echo "    var model = '$ModelType';";
  echo "    var txt = $.ajax({";
  echo "        url: './portctrl.php?tport=' + aport + '&ip=' + ip + '&model=' + model + '&action=' + action,";
  echo "        async: false,";
  echo "        }).responseText;";
  echo "    var _log = document.getElementById('log');";
  echo "    _log.innerHTML += txt + '<br/>';";
  echo "    return (false);";
  echo "}";
  echo "</script>";
?>