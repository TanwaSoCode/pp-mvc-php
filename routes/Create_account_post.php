<?php

$fullName = trim($_POST['name'] ?? '');

$nameParts = preg_split('/\s+/', $fullName);
$fname = $nameParts[0] ?? '';
$lname = $nameParts[1] ?? '';

$email = $_POST['email'] ?? '';
$username = $email;

$date = $_POST['birth_date'] ?? '';
$gender = $_POST['gender'] ?? '';
$password = $_POST['password'] ?? '';


$age = 0;
if ($date) {
   try {
      $dob = new DateTime($date);
      $age = (int) $dob->diff(new DateTime())->y;
   } catch (Exception $e) {
   }
}

$resule = membership($username, $fname, $lname, $date, $gender, $email, $password, $age);
if ($resule) {
   $_SESSION['membership'] = 'สมัครสมาชิกเรียบร้อย';
   header('location: /create_account');
} else {
   $_SESSION['membership'] = 'สมัครสมาชิกไม่สำเร็จ';
   header('location: /create_account');
}
