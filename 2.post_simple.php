<?php
error_reporting(-1);
$params   = [
    'var1'=>'some content',
    'var2'=>'doh',
    'var3'=>'asdasdasd'
];
$defaults = array(
  CURLOPT_URL => 'http://loftschool/curl/test.php',
  CURLOPT_POST => true,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POSTFIELDS => $params
);
$ch = curl_init();
curl_setopt_array($ch, $defaults);
$result = curl_exec($ch);
if( !curl_errno($ch) ) {
    echo $result;
} else {
    echo curl_error($ch);
}
curl_close($ch);
