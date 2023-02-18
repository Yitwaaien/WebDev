<?php

function resolveJson (string $path = null): array|string {

    if (!$path){
        echo 'введите путь к файлу';
        die();
    }

    return json_decode(file_get_contents($path), true);
}