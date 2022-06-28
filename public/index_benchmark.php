<?php

$pdo = new PDO('mysql:host=mysql;dbname=test', 'user', 'pass');

$tables = [
    'without_index' => 'users',
    'btee_index' => 'users_btree',
    'hash_index' => 'users_hash',
];

foreach ($tables as $desc => $table) {
    echo "\nstarted measurement: $desc \n";

    $startTime = microtime(true);
    foreach (range(1, 1000) as $item) {
        $birthdayAt = date('Y-m-d', strtotime("-$item days"));
        $pdo->query("SELECT SQL_NO_CACHE * from $table WHERE birthday_at = '$birthdayAt' LIMIT 100")->fetchAll();
    }
    $time = (microtime(true) - $startTime);
    echo "total time: $time sec \n";
    echo "avg time: " .$time/100 . " req/sec \n";
    echo "finished measurement: $desc \n";
}
