<?php



// ord
$encoded = "Hello Wirld";   // <-- encoded string from the request
$decoded = "";

function stringCrypt($str, $key) {
  
  $strLength = strlen($str);
  $newStr = '';
  for( $i = 0; $i < $strLength; $i++ ) {
      $b = ord($str[$i]);
      $a = $b ^ $key;
      $newStr .= chr($a);
  }
  return $newStr;

}

print stringCrypt($encoded, 123);

// JS
//  function enc(str, key) {
//    var newStr = '';
//    for (var i = 0; i < str.length; i++) {
//      var a = str.charCodeAt(i);
//      var b = a ^ key;
//      newStr = newStr+String.fromCharCode(b);
//    }
//    return newStr;
//  }