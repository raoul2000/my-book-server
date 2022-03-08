# Setup DEV DB

In order to use the **db-manager** Yii2 extension in the dev environment, it may be required to create a user with a password. Snippets below guide you through this task.

- login to MySQL console ad *root*
```shell
$ mysql -u root     
```
- create user *admin* and grant **all privileges**
```sql
mysql> create user admin@localhost identified by 'admin';
/* check backtick !*/
mysql> grant all privileges on `my_books`.* to admin@localhost;
```

- show privileges for user *admin*
```sql
mysql> show grants for admin@localhost;
+-------------------------------------------------------------+
| Grants for admin@localhost                                  |
+-------------------------------------------------------------+
| GRANT USAGE ON *.* TO `admin`@`localhost`                   |
| GRANT ALL PRIVILEGES ON `my_books`.* TO `admin`@`localhost` |
+-------------------------------------------------------------+
```

- show all users
```sql
mysql> select user, host from mysql.user;
+------------------+-----------+
| user             | host      |
+------------------+-----------+
| admin            | localhost |
| mysql.infoschema | localhost |
| mysql.session    | localhost |
| mysql.sys        | localhost |
| root             | localhost |
+------------------+-----------+
```

- show current user (here *root*)
```sql
mysql> select USER(), CURRENT_USER();
+----------------+----------------+
| USER()         | CURRENT_USER() |
+----------------+----------------+
| root@localhost | root@localhost |
+----------------+----------------+

```
