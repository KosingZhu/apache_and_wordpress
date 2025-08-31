# MySQL 操作指导

## 1. 数据库基本操作

### 创建数据库
```sql
CREATE DATABASE dbname;
# MySQL 操作指导

## 1. 数据库基本操作

### 创建数据库

```sql
CREATE DATABASE dbname;
```

### 连接数据库

```bash
mysql -u username -p
```

### 查看所有数据库

```sql
SHOW DATABASES;
```

### 选择数据库

```sql
USE dbname;
```

### 退出当前数据库（返回上一级）

```sql
USE mysql;
```

或直接退出 MySQL：

```bash
exit
```

## 2. 数据表操作

### 查看当前数据库中的所有表

```sql
SHOW TABLES;
```

### 查看表结构

```sql
DESCRIBE tablename;
```

### 查看表中的数据

```sql
SELECT * FROM tablename;
```

## 3. 数据查询

### 查询指定条件的数据

```sql
SELECT * FROM tablename WHERE condition;
```

## 4. 数据备份与恢复

### 备份数据库

```bash
mysqldump -u username -p dbname > backup.sql
```

### 导入数据库

```bash
mysql -u username -p dbname < backup.sql
```

## 5. PHP 操作 MySQL 示例

```php
<?php
$mysqli = new mysqli('localhost', 'username', 'password', 'dbname');
if ($mysqli->connect_error) {
    die('Connect Error: ' . $mysqli->connect_error);
}
$result = $mysqli->query('SELECT * FROM tablename');
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
$mysqli->close();
?>
```

## 6. 常用命令速查

- SHOW DATABASES;  # 查看所有数据库
- USE dbname;      # 选择数据库
- SHOW TABLES;     # 查看所有表
- DESCRIBE tablename; # 查看表结构
- SELECT * FROM tablename; # 查看表数据
- exit;            # 退出 MySQL

---

如需自动化备份/恢复，可使用批处理脚本 `mysql_table_backup_restore.bat`。
```

## 6. 常用命令速查
- SHOW DATABASES;  # 查看所有数据库
- USE dbname;      # 选择数据库
- SHOW TABLES;     # 查看所有表
- DESCRIBE tablename; # 查看表结构
- SELECT * FROM tablename; # 查看表数据
- exit;            # 退出 MySQL

---

如需自动化备份/恢复，可使用批处理脚本 `mysql_table_backup_restore.bat`。
