# My Books (Server)

## Setup DEV environment

Target platform :**Windows 10**

### Requirements

- PHP >= 7.2.5  installed and accessible in the PATH
- MySql

Check version :
```bash
# check PHP version and CLI accessibility
$ php -version
PHP 7.4.27 (cli) (built: Dec 14 2021 19:52:13) ( ZTS Visual C++ 2017 x64 )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies

# check MySQL version and CLI accessibility
mysqld --version
C:\dev\tools\mysql-8.0.27-winx64\bin\mysqld.exe  Ver 8.0.27 for Win64 on x86_64 (MySQL Community Server - GPL)
```
### Installation

- install composer locally into folder `./tools`. Jump to the `./tools` folder and enter the commands described in the [Composer Install Page](https://getcomposer.org/download/)

For example :
```bash
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
```
- test with
```bash
$ cd <PROJECT_ROOT>
$ php tools/composer.phar --version
Composer version 2.2.3 2021-12-31 12:18:53
```
- install PHP dependencies with *Composer*
```bash
$ cd <PROJECT_ROOT>
$ php ../tools/composer install
```

### Usage

#### Web Server
- start the Web server embbeded in PHP 
```bash
$ cd ./server
$ php yii serve 
# To set server port: php yii serve --port=8888
```
- to stop the server : `Ctrl+C`

#### MySQL
Make sure MySQL bin folder is in the `$PATH` environment variable.
- start DB
```bash
$ mysqld --console
```
- stop DB
```bash
$ mysqladmin -u root shutdown
```
