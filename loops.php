<?php

$json_file = 'cities.json';

$json_string = file_get_contents($json_file);

//var_dump($json_string);
//die();

$data = json_decode($json_string, true);


//var_dump($data['cities']['0']['name']);
//die();

foreach ($data['cities'] as $city) {
    var_dump($city);
    die();
}

while (true) {
    echo 34;
    break;
}

