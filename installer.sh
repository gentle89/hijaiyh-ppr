#!/bin/bash

# Premium PHP Redirect - a product by HijaIyh.
# Author : justalinko
# Installer : justalinko
# Version : 3.1
# 
# Tested on ubuntu 18.04 LTS
#
# Disclaimer : - This product should only be used by Hijaiyh members who have already purchased it.

# color variable
m="\033[1;31m"
k="\033[1;33m"
h="\033[1;32m"
b="\033[1;34m"
bl="\033[0;34m"
n="\033[1;0m"
# hijaiyh

iyh_banner()
{

echo -e $b"  _   _ _  _       ___      _     "
echo -e $b" | | | (_)(_) __ _|_ _|   _| |__  "
echo -e $b" | |_| | || |/ _' || | | | | '_ \ "
echo -e $b" |  _  | || | (_| || | |_| | | | |"
echo -e $b" |_| |_|_|/ |\__,_|___\__, |_| |_|"
echo -e $b"        |__/          |___/       "
echo -e $k" +--------------------------------+"
echo -e $k" |   HijaIyh Premium PHP Redirect |"
echo -e $h" |    Installer Script - v1.0     |"$n
echo -e $m" |    @author  :: justalinko      |"$n
echo -e $k" +--------------------------------+"$n

}

iyh_depen()
{
	echo "[!] Checking dependencies ..."
	echo ""
	echo "[!] This software only support Debian,ubuntu and family !"
	echo "Press ENTER to continue;"; read x
	sleep 1
	echo "[!] Ensure that your system supports ..."
	which lsb_release > /dev/null 2>&1
	if [[ $? -eq 0 ]]; then
		lsb_release -id
	else
		echo "Your system not supported."
		exit 1
	fi

	clear ; iyh_banner
	echo "Lets start bruhhh ...."
	sleep 1
	echo "[!] Updating your system ...."
	apt-get update -y
	clear ; iyh_banner
	echo "[!] Installing apache2 webserver , php ..."
	apt-get install apache2 libapache2-mod-php php php-cli php-curl php-zip php-common php-mbstring php-mysql -y
	clear ; iyh_banner
    echo "[!] Installing mariadb-server ..."
    apt-get install mariadb-server -y
    clear ; iyh_banner
	echo "[!] Installing unzip,wget,git ..."
	apt-get install unzip wget git -y
	clear ; iyh_banner
	echo "Installing dependencies DONE."
	echo "Press ENTER to continue"; read x
}
iyh_install()
{

	clear ; iyh_banner
	echo "[!] Cloning from repository ..."
	git clone https://github.com/justalinko/hijaiyh-ppr.git
	echo "[!] Moving to /var/www/html ..."
	mv hijaiyh-ppr/* /var/www/html/
	mv hijaiyh-ppr/.htaccess /var/www/html/
	sleep 1
	echo "[!] Configuring databases ..."
    echo "!!!! Create database password !!!!!"
    mysql_secure_installation
    clear ; iyh_banner
    read -p "Input database password : " dbpass
    echo "[!] Cleaning database ..."
    mysql -h localhost -u root -p$dbpass -e "grant all privileges on *.* to 'root'@'localhost' identified by '${dbpass}'; "
    mysql -h localhost -u root -p$dbpass -e 'flush privileges;'
    echo "[!] Creating database ..."
    mysql -h localhost -u root -p$dbpass -e 'CREATE DATABASE hijaiyh_ppr;'
    echo "[!] Importing database ..."
    mysql -h localhost -u root -p$dbpass hijaiyh_ppr -e 'source /var/www/html/hijaiyh_ppr.sql;'
    sleep 2
    echo "[!] Configuring database.php ..."
    sed -i "s|#hijaiyh_password#|${dbpass}|g" /var/www/html/_AppData/config/database.php
    sleep 1
    cat /var/www/html/_AppData/config/database.php
    echo "Ensure this config was correct."
    echo "if wrong you can edit /var/www/html/_AppData/config/database.php ! "
    read -p "[PRESS ENTER TO CONTINUE]" x

    clear ; iyh_banner
    echo "[!] Activating mod rewrite ..."
    a2enmod rewrite
    echo "[!] Replacing apache2 config ..."
    wget -q https://pastebin.com/raw/3JHuq3Wm -O apache2.conf
    rm /etc/apache2/apache2.conf
    mv apache2.conf /etc/apache2/
    sleep 1
    echo "[!] Restart apache2 ///"
    /etc/init.d/apache2 restart
    sleep 3
    clear
    iyh_banner
    echo -e $h"INSTALLATION WAS DONE !"$n
    echo -e $k"http://YourIPserver/auth"$n" To login with default :"
    echo "username : admin | password : hijaiyh"

}

if [[ `whoami` != 'root' ]]; then
	echo "ROOT ONLY !"
	exit 1
else
	iyh_banner
	iyh_depen
	iyh_install
fi