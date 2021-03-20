# 🔐 PHP Authentication (Register / Login / Logout)
Simple & secure script for user authentication using PHP & Mysqli prepared statements. Demo uses HTML POST forms and GET for returning the status.

### 👉 Prerequisites
- **Hosting:** either XAMPP locally or any external web host

- Create a MySQL database
```
CREATE TABLE `test`.`useraccounts` ( `userID` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(64) NOT NULL , `firstname` TINYTEXT NULL , `lastname` TINYTEXT NULL , `token` VARCHAR(64) NOT NULL , `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `password` VARCHAR(128) NOT NULL , PRIMARY KEY (`userID`)) ENGINE = InnoDB;
```

- Connect your database in **functions.php**

- That is it! 👌
