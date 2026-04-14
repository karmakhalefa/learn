<?php
session_start();

$num1 = $_SESSION['num1'] ?? 0;
$num2 = 10;

echo $num1 + $num2;