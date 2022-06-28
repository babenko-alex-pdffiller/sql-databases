<?php

foreach ([0,1,2] as $configValue) {
    $pdo = new PDO('mysql:host=mysql;dbname=test', 'root', 'pass');
    $pdo->exec("SET GLOBAL innodb_flush_log_at_trx_commit=$configValue");
    $data = $pdo->query('SHOW GLOBAL VARIABLES LIKE "innodb_flush_log_at_trx_commit"')->fetchObject();
    echo "Currenct value of $data->Variable_name: $data->Value \n";

    $tables = [
        'without_index' => 'users',
        'btree_index' => 'users_btree',
        'hash_index' => 'users_hash',
    ];

    foreach ($tables as $desc => $table) {
        echo 'start measurement: '.$desc."\n";
        foreach ([100, 1000, 10000] as $maxItem) {
            $startTime = microtime(true);
            foreach (range(1, $maxItem) as $item) {
                $birthdayAt = date('Y-m-d', strtotime("-$item days"));
                $pdo->exec("INSERT INTO $table (email, birthday_at) VALUES ('user@test.com', '$birthdayAt')");
            }
            $time = (microtime(true) - $startTime);
            echo "total time: $maxItem request per $time sec \n";
            echo 'avg time: '. $time / $maxItem . " sec \n";
        }
        echo 'finish measurement: '.$desc."\n";
    }
}
