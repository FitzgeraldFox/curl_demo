<?php
require_once("curl_class.php");
try {
    $curl = new CURL();
    $curl->configure("webcodegeeks.com");
    $response = $curl->execute();
    echo $response;

    $file = fopen("webcodegeeks.com.html", "c");
    $curl->configure("webcodegeeks.com", ["s" => "php"], "GET", [CURLOPT_RETURNTRANSFER => true, CURLOPT_FILE => $file]);
    $response2 = $curl->execute();

    $curl->close();
    fclose($file);
} catch (Exception $exception) {
    die("An exception has been thrown: " . $exception->getMessage());
}