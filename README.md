# My Books (Server)

## Setup DEV environment

### Requirements

- PHP >= 7.2.5  installed and accessible in the PATH
- Mysql

### Installation

- install composer locally into folder `./tools`. From the project root folder : 
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php -r "unlink('composer-setup.php');"
php composer-setup.php --filename=composer --install-dir=bin
```
- test with
```
php tools/composer --version
```
- install dependencies
```
cd ./server
php ../tools/composer install
```

### Usage

#### Web Server
- start 
```bash
cd ./server

php yii serve 
# To set server port: php yii serve --port=8888
```
- to stop the server : Ctrl+C

#### MySQL
From the MySQL installation folder:
- start 
```
mysqld
```
- stop 
```
mysqladmin -u root shutdown
```
