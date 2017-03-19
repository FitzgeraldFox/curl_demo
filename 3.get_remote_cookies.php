<?php
function getGemoteCookies( $url ){
    // адрес для  удаленного подключения
    $ch = curl_init( $url );
    // результат вернуть в переменную, а не на экран
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // вернуть заголовки
    curl_setopt($ch, CURLOPT_HEADER, 1);
    // выполнить запрос
    $result = curl_exec($ch);
    // получаем cookies, исходя из блока Set-Cookie заголовков
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();
    foreach($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }
    return $cookies;
}
var_dump(getGemoteCookies('http://yandex.ru'));