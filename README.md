# HTweb
FuelPHP based web application for dorm administration. Initially developed by Melcher Stikkelorum, now maintained by Wick Wijnholds with patches from Tom Veldman.

## Features
* Complete point based diner tracking module including enrollments of guests, cooks and dishwashers. 
* Product module for easy cost logging
* Receipt module including cost distribution tools
* Bilingual user interface (Dutch and English)
## Installation
### PHP 7.4
Install using the official installation instructions, found at https://www.php.net/manual/en/install.php.
Also install Composer, preferably using your distributions' package manager.
### FuelPHP
(Optional) Install oil standalone `$ curl get.fuelphp.com/oil | sh`.
Next, download and install FuelPHP itself using composer `$ composer update` in the project folder.

## Configuration and setup
### Setting up a MariaDB database
First, install MariaDB and MariaDB-server, if you have not already.

For example, on Fedora, run: `$ sudo dnf install mariadb mariadb-server`
Then, enable the MariaDB-server systemctl file with `systemctl enable --now mariadb.service`.

Now, setup your server using `mariadb-secure-installation`. Say yes to all, and enter a password.

Log in to your MariaDB server, and set up a new database and a user. Enter the credentials in the file at `fuel/app/config/db.php`.

For production environments please be sure to configure both `auth.php` and `ormauth.php` as well.

## Migrations
Run all migrations. Please note there's a strict order in which to run migrations:
1. auth tables and others `$ oil r migrate --packages=auth` 
3. session tables `$ oil r migrate --modules=sessions` (some other modules depend on sessions' functionality)
4. all others `$ oil r migrate --all`

## Run it
Oil has a built-in web server. Run the server using `$ oil s`
