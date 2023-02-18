<?php

$json_file = 'cities.json';

$json_string = file_get_contents($json_file);

//var_dump($json_string);
//die();

$data = json_decode($json_string, true);

// $data теперь является ассоциативным массивом
// можно получить доступ к данным, например:

echo $data['cities'][0]['name']; // Москва