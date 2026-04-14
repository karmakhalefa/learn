<?php

$file = __DIR__ . '/users.json';

if(file_exists($file)){
    $data = file_get_contents($file);
    $users = json_decode($data, true);
} else {
    $users = [];
}

echo "<pre>";
print_r($users);
echo "</pre>";

?>