# 8 SQL Databases

MySQL on InnoDB engine, table on 40m users

## Start the stack with docker compose

```bash
$ docker-compose up
```

Command to write 40m items to the database:

`php filling_users_data.php`

Compare performance by indexes:

![Example of requests](./indexes.png?raw=true "Example of requests")

| Comparing by  | req/sec | total time |
|---------------|:-------:|-----------:|
| without index |  0.36   |      36.12 |
| btree         |  0.003  |       0.36 |
| hash          |  0.001  |       0.10 |


Compare performance in insert mode by different settings of innodb_flush_log_at_trx_commit :

| insert mode               | innodb_flush_log_at_trx_commit 0 |  innodb_flush_log_at_trx_commit 1  | innodb_flush_log_at_trx_commit 2 |
|---------------------------|:--------------------------------:|:----------------------------------:|:--------------------------------:|
| without_index 100 items   |          0.0039 req/sec          |           0.0152 req/sec           |          0.0064 req/sec          |
| btree 100 items   |          0.0042 req/sec          |           0.0146 req/sec           |          0.0068 req/sec          |
| hash 100 items   |          0.0084 req/sec          |           0.0068 req/sec           |          0.0066 req/sec          |
| without_index 1000 items  |          0.0039 req/sec          |           0.0160 req/sec           |          0.0073 req/sec          |
| btree 1000 items  |          0.0041 req/sec          |           0.0144 req/sec           |          0.0068 req/sec          |
| hash 1000 items  |          0.0080 req/sec          |           0.0072 req/sec           |          0.0071 req/sec          |
| without_index 10000 items |          0.0039 req/sec          |           0.0152 req/sec           |          0.0067 req/sec          |
| btree 10000 items |          0.0064 req/sec          |           0.0139 req/sec           |          0.0069 req/sec          |
| hash 10000 items |          0.0118 req/sec          |           0.0064 req/sec           |          0.0064 req/sec          |
