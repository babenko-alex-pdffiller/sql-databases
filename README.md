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

| Comparing by  | req/sec |      total time (1000 req) |
|---------------|:-------:|---------------------------:|
| without index |  0.36   |                      36.12 |
| btree         |  0.003  |                       0.36 |
| hash          |  0.001  |                       0.10 |


Compare performance in insert mode by different settings of innodb_flush_log_at_trx_commit :

| insert mode               | flush_log: 0 (req/sec) |  flush_log: 1 (req/sec) |  flush_log: 2 (req/sec) |
|---------------------------|:---------------:|:--------------:|:--------------:|
| without_index 100 items   | 0.0039   | 0.0152  | 0.0064  |
| btree 100 items   | 0.0042   | 0.0146  | 0.0068  |
| hash 100 items   | 0.0084   | 0.0068  | 0.0066  |
| without_index 1000 items  | 0.0039   | 0.0160  | 0.0073  |
| btree 1000 items  | 0.0041   | 0.0144  | 0.0068  |
| hash 1000 items  | 0.0080   | 0.0072  | 0.0071  |
| without_index 10000 items | 0.0039   | 0.0152  | 0.0067  |
| btree 10000 items | 0.0064   | 0.0139  | 0.0069  |
| hash 10000 items | 0.0118   | 0.0064  | 0.0064  |
