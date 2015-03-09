<?php
  function hextostr($hex)
    {
    $str = '';
    for ($i = 0; $i < strlen($hex) - 1; $i += 2)
      {
      if ($hex[$i] . $hex[$i+1] != '00') $str .= chr(hexdec($hex[$i] . $hex[$i+1]));
      }
    return $str;
    }
 
  function strtohex($str)
    {
    $hex = '';
    for ($i = 0; $i < strlen($str); $i++)
      {
      $hex .= dechex(ord($str[$i]));
      }
    return $hex;
    }
  
  function stripstr($str)
    {
    $str = str_ireplace('Hex: ', '', $str);
    $str = str_ireplace(' ', '', $str);
    $str = str_ireplace('"', '', $str);
    $str = str_ireplace(chr(10), '', $str);
    $str = str_ireplace(chr(13), '', $str);
    $str = substr($str, 0, 8);
    return $str;
    }
  
  function keyscut($arr)
    {
    $new_arr = array();
    reset($arr);
    for ($i = 0; $i < count($arr); $i++)
      {
      $val = $arr[key($arr)];
      $key = key($arr);
      $key = substr(strrchr($key, '.'), 1);
      $new_arr[$key] = $val;
      next($arr);
      }
    return $new_arr;
    }
  
  function keyscutvlanmac($arr)
    {
    $new_arr = array();
    reset($arr);
    for ($i = 0; $i < count($arr); $i++)
      {
      $val = $arr[key($arr)];
      $key = key($arr);
      $arrkey = explode('.', $key);
      $arrkey = array_reverse($arrkey);
      $key = $arrkey[6] . '.' . $arrkey[5] . '.' . $arrkey[4] . '.' . $arrkey[3] . '.' . $arrkey[2] . '.' . $arrkey[1] . '.' . $arrkey[0];
      $new_arr[$key] = $val;
      next($arr);
      }
    return $new_arr;
    }
?>