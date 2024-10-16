CREATE DATABASE IF NOT EXISTS invoice_management;

GRANT CREATE, ALTER, INDEX, LOCK TABLES, REFERENCES, UPDATE, DELETE, DROP, SELECT, INSERT ON `invoice_management`.* TO 'user'@'%';

FLUSH PRIVILEGES;

