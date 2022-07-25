
<?php

function getcurl($endpointme){


    $ch2 = curl_init();

    curl_setopt($ch2,CURLOPT_URL,$endpointme);
    curl_setopt($ch2,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch2);
    curl_close($ch2);

    return $response;

}
