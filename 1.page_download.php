<?php

$ch = curl_init("http://www.example.com/");
$fp = fopen("example_homepage.html", "c");

curl_setopt($ch, CURLOPT_FILE, $fp);

curl_exec($ch);
curl_close($ch);
fclose($fp);
?>