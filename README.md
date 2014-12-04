antdelno.lt
===========

Simple website for the private event with few friends invited. The website should be hosted privately, so no Facebook or other media sharing websites will be involved.

##### The purpose of using
Closed circle of people get one password to log in and see the information you provide on the event.

##### Install process
1. Run SQL commands found inside the /install/antdelno_lt.sql -- this will create database(DB), DB tables, sample data. Sample data could be deleted or changed by using MySQL DB management tools like phpMyAdmin, MySQL Workbench, HeidiSQL, etc.
2. Copy "/config/config.\*.global.php" files to "/config/config.\*.local.php" and change the information inside all /config/config.\*.local.php -- this will configure the web (e.g. will configure DB connection).
3. Connect to the website. You will be asked for the password. The default one is "ourspassword". The existing password could be edited or removed via MySQL DB management tools (go to table "passwords_public" for changes).
4. That`s it?
