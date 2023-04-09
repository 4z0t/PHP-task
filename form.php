<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

/** Creates alert message on client side
 */
function js_alert(string $message): void
{
    echo "<script type='text/javascript'>alert('$message');</script>";
}

function validateEmail(string $email): bool
{
    if (!str_contains($email, "@"))
        return false;
    return true;
}

function validatePassword(string $password1, string $password2): array
{
    if ($password1 !== $password2)
        return array(false, "passwords do not match");
    if (strlen($password1) < 8)
        return array(false, "password length must be at least 8 characters");
    return array(true, "");
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeatPassword = $_POST['repeatPassword'];

if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($repeatPassword)) {
    http_response_code(400);
    js_alert('Please fill in all fields.');
    exit;
}

list($success, $reason) = validatePassword($password, $repeatPassword);
if (!$success) {
    http_response_code(400);
    js_alert($reason);
    exit;
}


if (!validateEmail($email)) {
    http_response_code(400);
    js_alert("Incorrect email");
    exit;
}




// test data
$users = [
    ["name" => "user1234", "email" => "user1234@mail", "id" => 1],
    ["name" => "4z0t", "email" => "test@php", "id" => 2],
    ["name" => "phptest", "email" => "a@b", "id" => 3],
];


$success = false;
$foundUser = null;
foreach ($users as $user) {
    if ($user["email"] === $email) {
        $success = true;
        $foundUser = $user;
        break;
    }
}




if ($success) {
    $userName = $foundUser['name'];
    $msg = "User $userName logged in\n";

    file_put_contents("logs/server.log", $msg, FILE_APPEND | LOCK_EX);

    http_response_code(200);
    readfile("success.html");
} else {
    http_response_code(400);
    js_alert("Incorrect data");
}
exit;
