/* Creating database */
SET @creatDatabaseTemplate := 'CREATE DATABASE IF NOT EXISTS {DBNAME} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
SET @creatDatabaseCommand := REPLACE (@creatDatabaseTemplate, '{DBNAME}', @databaseName);
PREPARE command FROM @creatDatabaseCommand;
EXECUTE command;
DEALLOCATE PREPARE command;
