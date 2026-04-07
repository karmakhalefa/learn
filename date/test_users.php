<?php
// قراءة ملف JSON من نفس مجلد الملف الحالي
$data = file_get_contents(__DIR__ . '/users.json');

// تحويله لمصفوفة
$users = json_decode($data, true);

foreach($users as $user){
    echo $user['name'] . "<br>";
}
?>