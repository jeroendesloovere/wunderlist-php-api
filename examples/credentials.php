<?php

// define your own credentials
$username = ''; // required
$password = ''; // required

// throw error
if (empty($username) || empty($password)) {
    echo 'Please define your username and password in ' . __DIR__ . '/credentials.php';
}
