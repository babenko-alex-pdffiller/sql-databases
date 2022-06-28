<?php

$pdo = new PDO('mysql:host=mysql;dbname=test', 'user', 'pass');

$query = 'CREATE TABLE users(
        email  VARCHAR(20) NOT NULL,
        birthday_at DATE NOT NULL
    );';
$ret = $pdo->exec($query);

$query = 'CREATE TABLE users_btree(
        email  VARCHAR(20) NOT NULL,
        birthday_at DATE NOT NULL,
        INDEX birthday (birthday_at) USING BTREE
    );';
$ret = $pdo->exec($query);

$query = 'CREATE TABLE users_hash( 
        email  VARCHAR(20) NOT NULL,
        birthday_at DATE NOT NULL,
        INDEX birthday (birthday_at) USING HASH        
    ) ENGINE = MEMORY;';

$ret = $pdo->exec($query);

echo 'Tables created successfully', "\n";

foreach (range(1, 40000) as $firstItem) {
    $values = '';
    foreach (range(1, 1000) as $secondItem) {
        $email  = $firstItem . $secondItem . '@test.com';
        $birthdayAt = date('Y-m-d', strtotime("-$secondItem days"));
        $values .= "('$email', '$birthdayAt'),";
    }
    $values = substr($values, 0, -1);
    $pdo->exec("INSERT INTO users (email, birthday_at) VALUES $values");
    $pdo->exec("INSERT INTO users_btree (email, birthday_at) VALUES $values");
    $pdo->exec("INSERT INTO users_hash (email, birthday_at) VALUES $values");
    echo '.';
}

echo '.';

echo 'Users data inserted successfully', "\n";
