<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,"ftp://ftp.gnu.org");
curl_setopt($curl, CURLOPT_FTPLISTONLY, 1);
curl_setopt($curl, CURLOPT_USERPWD, "anonymous:andrey.xwz@mail.ru");
//Поставьте рандомные данные, например, "foo:barbaz", в 3 арг. CURLOPT_USERPWD, и получите сообщение об ошибке
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec ($curl);
echo curl_error($curl);
curl_close ($curl);
print $result;
?>