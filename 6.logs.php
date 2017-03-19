<?php
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, "http://php.net");
curl_setopt($curl, CURLOPT_VERBOSE, true);
$file = fopen('log.txt', 'c');
curl_setopt($curl, CURLOPT_STDERR, $file);

curl_exec ($curl);
curl_close ($curl);
?>