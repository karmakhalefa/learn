<?php

$students = [
[
    "name" => "karma",
    "age" => "26",
    "grade" => "85"
],

[
  "name" => "mody",
    "age" => "28",
    "grade" => "90"


],
[
  "name" => "gemy",
    "age" => "28",
    "grade" => "90"


],
[
  "name" => "ahmed",
    "age" => "28",
    "grade" => "90"
]

];

echo "<pre>";
print_r($students);
echo "</pre>";


echo "<h3>درجات الطلاب:</h3>";
foreach ($students as $X ) {
    echo $X['grade'] . "<br>";
}

$new_student = ['name'=>'Omar','age'=>21,'grade'=>100];
$students[] = $new_student;

echo "<pre>";
print_r($students); // هتشوفي كل الطلاب بما فيهم Omar
echo "</pre>";

// 2️⃣ طريقة باستخدام بحث عن الاسم
$found = false;
foreach($students as $student){
    if($student['name'] == 'Omar'){
        $found = true;
        break;
    }
}

if($found){
    echo "الطالب Omar اتضاف!";
}else{
    echo "الطالب Omar مش موجود!";
}
echo "<pre>";

$last_student = end($students);
if($last_student['name'] == 'Omar'){
    echo "الطالب Omar آخر طالب في المصفوفة ✅";
}
echo "</pre>";

// 4️⃣ Edit::
$students[0]['age'] = '29';
echo "<pre>";
print_r($students); 
echo "</pre>";
// 5️⃣ Delete:
unset($students[2]);
echo "<pre>";
print_r($students); 
echo "</pre>";

$search = "Ali";
$found = array_filter($students, fn($s) => stripos($s['name'], $search) !== false);
$grades = array_column($students, 'grade');

echo "<pre>";
print_r($grades);
echo "</pre>";
echo max($grades);
echo "<pre>";
echo min($grades);
echo "</pre>";
echo array_sum($grades) / count($grades);

echo "<pre>";
// اعاده ترتيب 
usort($students, function($a, $b){
    return $b['age'] <=> $a['age'];
});

echo "<pre>";
print_r($students);
echo "</pre>";


?>
